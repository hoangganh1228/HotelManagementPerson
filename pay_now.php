<?php
    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');

    // require('inc/Payment/payAtmMomo.php');

    date_default_timezone_set("Asia/Ho_Chi_Minh");

    session_start();
    
    function regenrate_session($uid) {
        $user_q = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$uid], 'i');
        $user_fetch = mysqli_fetch_assoc($user_q);

        $_SESSION['login'] = true;
        $_SESSION['uId'] = $user_fetch['id'];
        $_SESSION['uName'] = $user_fetch['name'];
        $_SESSION['uPic'] = $user_fetch['profile'];
        $_SESSION['uPhone'] = $user_fetch['phonenum'];
    } 

    echo '<pre>';
    print_r($_SESSION['user_data']) ;
    echo '</pre>';
    if(!isset($_SESSION['login']) && $_SESSION['login'] == true) {
        redirect('index.php');
    }
    
    echo isset($_GET['partnerCode']);

    if(isset($_GET['partnerCode'])) {
        // echo $_GET['partnerCode'];
        $CUST_ID = $_SESSION['uId'];
        $CHECK_IN = $_SESSION['user_data']['checkin'];
        $CHECK_OUT = $_SESSION['user_data']['checkout'];



        $frm_data = filteration($_GET);

        echo '<pre>';
        print_r($frm_data);
        echo '</pre>';

        $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `order_id`, `trans_status`) VALUES (?, ?, ?, ?, ?, ?)";

        insert($query1, [$CUST_ID, $_SESSION['room']['id'], $CHECK_IN,
         $CHECK_OUT, $frm_data['orderId'], $_GET['message']], 'isssss');

        $booking_id = mysqli_insert_id($con);

        $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`,
          `user_name`, `phone_num`, `address`) VALUES (?, ?, ?, ?, ?, ?, ?)";

        insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $frm_data['amount'], $_SESSION['user_data']['name'],
         $_SESSION['user_data']['phonenum'], $_SESSION['user_data']['address']], 'issssss');

        
        $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id`='$_GET[orderId]'";

        $slct_res = mysqli_query($con, $slct_query);
        
        if(mysqli_num_rows($slct_res) == 0) {
            redirect('index.php');
        }

        $slct_fetch = mysqli_fetch_assoc($slct_res);
        print_r($slct_fetch);

        // if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        //     regenrate_session($slct_fetch['user_id']);
        // }

        if($_GET['message'] == "Successful.") {
            $upd_query = "UPDATE `booking_order` SET `booking_status`='booked'
             WHERE `booking_id`='$slct_fetch[booking_id]'";
            
            mysqli_query($con, $upd_query);
        } else {
            $upd_query = "UPDATE `booking_order` SET `booking_status`='payment_failed'
             WHERE `booking_id`='$slct_fetch[booking_id]'";
            mysqli_query($con, $upd_query);
        }
        redirect('pay_status.php?order='.$_GET['orderId']);


    }

?>

