<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <title><?php echo $settings_r['site_title']?> BOOKING STATUS</title>
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>

    

  
    
    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-3 px-4">
                <h2 class="fw-bold">PAYMENT STATUS</h2>
                
            </div>

            <?php

                $frm_data = filteration($_GET);
                
                if(!isset($_SESSION['login']) && $_SESSION['login'] == true) {
                    redirect(('index.php'));
                }

                // echo '<pre>';
                // print_r($_SESSION);
                // echo '</pre>';

                $booking_q = "SELECT bo.*,  bd.*
                 FROM `booking_order` bo
                    INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
                    WHERE bo.order_id=? AND bo.user_id=? AND bo.booking_status!=?";

                $booking_res = select($booking_q, [$frm_data['order'], $_SESSION['uId'], 'pending'], 'sis');
                
                if(mysqli_num_rows($booking_res)==0) {
                    redirect('index.php');
                }

                $booking_fetch = mysqli_fetch_assoc($booking_res);
                //  
                if($booking_fetch['trans_status']=="Successful.") {
                    echo<<<data
                        <div class="col=12 px-4">
                            <p class="fw-bold alert alert-success">
                            <i class="bi bi-check-circle-fill"></i> 
                            Thanh toán thành công! Đã đặt được phòng thành công.
                            <br>
                            <a href='bookings.php'>Go to booking</a>
                            </p>
                        </div>
                    data;
                } else {
                    echo<<<data
                        <div class="col=12 px-4">
                            <p class="fw-bold alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                Thanh toán thất bại! $booking_fetch[trans_status]
                                <br>
                                <a href='bookings.php'>Go to booking</a>
                            </p>
                        </div>
                    data;
                }
                
            ?>

            

            
        </div>
    </div>

    <?php require('inc/footer.php')?>
    <script>
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        function check_availability() {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;
            // booking_form.elements['pay_now'].setAttribute('disabled', true);

            if(checkin_val != '' && checkout_val != '') {
                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');
                info_loader.classList.remove('d-none');

                let data = new FormData();

                data.append('check_availability', '');
                data.append('check_in', checkin_val);
                data.append('check_out', checkout_val);

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking.crud.php", true); // yêu cầu là một yêu cầu POST (được xác định bằng "POST"). Địa chỉ URL mà yêu cầu sẽ được gửi đến là "ajax/settings_crud.php". Tham số thứ ba là true, nó cho biết yêu cầu là không đồng bộ.
                

                xhr.onload = function() {
                    let data = JSON.parse(this.responseText);
                    
                    if(data.status == 'check_in_out_equal') {
                        pay_info.innerText = "You cannot check-out on the same day!"
                    } else if(data.status == 'check_out_earlier') {
                        pay_info.innerText = "Check-out date is earlier than check-in date!"
                    } else if(data.status == 'check_in_earlier') {
                        pay_info.innerText = "Check-in date is earlier than today's date!"
                    } else if(data.status == 'unavailable') {
                        pay_info.innerText = "Room not available for this check-in date!"
                    } else {
                        pay_info.innerHTML = "No. of Days " + data.days + "<br>Total Amoount Pay: " + data.payment + " VND"
                        pay_info.classList.replace('text-danger', 'text-dark');

                    } 
                    
                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');

                }

                xhr.send(data);

                }
            }


    </script>


    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  

</body>
</html>

