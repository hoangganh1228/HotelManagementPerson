<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=vietnamese" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="./assets/css/main.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="./assets/css/base.css?v=<?php echo time(); ?>">

<?php
    session_start();
    date_default_timezone_set("Asia/Ho_Chi_Minh");

    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');
    
    $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $contact_r =mysqli_fetch_assoc( select($contact_q, $values, 'i'));
    $settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));

    if($settings_r['shutdown']) {
        echo<<<alertbar

            <div class='bg-danger text-center p-2 fw-bold'> 
                <i class="bi bi-exclamation-triangle-fill"></i>
                Bookings are temporarily closed!
            </div>

        alertbar;
    }
?>