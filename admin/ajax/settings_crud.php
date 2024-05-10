<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();


    if(isset($_POST['get_general']))     {
        $q = "SELECT * FROM `settings` WHERE `sr_no`=?";
        $values = [1]; //Đây là một mảng chứa các giá trị sẽ được thay thế vào các placeholder trong câu truy vấn SQL. Trong trường hợp này, mảng chỉ chứa một giá trị là 1, vì chúng ta muốn lấy dữ liệu cho sr_no có giá trị là 1.
        $res = select($q, $values, "i"); //Tham số thứ nhất là câu truy vấn SQL, tham số thứ hai là mảng chứa các giá trị sẽ được thay thế vào câu truy vấn, và tham số thứ ba là một chuỗi chỉ định kiểu của các giá trị trong mảng. Trong trường hợp này, "i" có thể chỉ định rằng tất cả các giá trị trong mảng là kiểu integer.
        $data = mysqli_fetch_assoc($res);
        $json_data = json_encode($data);
        echo $json_data;
    }

    if(isset($_POST['upd_general'])) {
        $frm_data = filteration($_POST);

        $q = "UPDATE `settings` SET `site_title`=?,`site_about`=?  WHERE `sr_no`=?";
        
        $values = [$frm_data['site_title'], $frm_data['site_about'], 1];
        
        $res = update($q, $values, 'ssi');

        echo $res;
    }

    if(isset($_POST['upd_shutdown'])) {
        $frm_data = ($_POST['upd_shutdown']==0) ? 1 : 0;

        $q = "UPDATE `settings` SET `shutdown`=?  WHERE `sr_no`=?";
        
        $values = [$frm_data, 1];
        
        $res = update($q, $values, 'ii');

        echo $res;
    }

?>