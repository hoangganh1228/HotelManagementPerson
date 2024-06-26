<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');
    require('../inc/phpmailer/Exception.php');
    require('../inc/phpmailer/PHPMailer.php');
    require('../inc/phpmailer/SMTP.php');

    date_default_timezone_set("Asia/Ho_Chi_Minh");


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($email, $token, $type) {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
    
        try {
            if($type == "email_confirmation") {
                $page = 'email_confirm.php';
                $subject = 'Account Verification Link';
                $content = 'Confirmation your email';
            } else {
                $page = 'index.php';
                $subject = 'Account Reset Link';
                $content = 'reset your account';
            }


            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'shynke20004@gmail.com';                     //SMTP username
            $mail->Password   = 'wnvq nnqo nbom qcci ';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
            //Recipients
            $mail->setFrom('hoanganh52521352@gmail.com', 'hoangganh');
            $mail->addAddress($email);     //Add a recipient
    
            
    
            //Content
            $mail-> CharSet = "UTF-8";
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = "Click the link to $content: <br>
                <a href='".SITE_URL."$page?$type&email=$email&token=$token". "'>
                    CLICK ME
                </a>
                ";
    
            // phpMailer certificate verify failed
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
    
            $sendMail = $mail->send();
            if($sendMail) {
                return $sendMail;
            }
            
        } catch (Exception $e) {
            echo "Gửi mail thất bài. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    if(isset($_POST['register'])) {
        $data = filteration($_POST);

        // match password and confirm password field
        
        if($data['pass'] != $data['cpass']) {
            echo 'pass_mismatch';
            exit;
        }

        // check user exist or not

        $u_exist = select("SELECT * FROM `user_cred` WHERE `email` = ? OR `phonenum` = ? LIMIT 1",
         [$data['email'], $data['phonenum']], "ss");
        
        if(mysqli_num_rows($u_exist) != 0) {
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
            exit;
        }
        
        // upload user image to server

        $img = uploadUserImage($_FILES['profile']);

        if($img == 'inv_img') {
            echo 'inv_img';
            exit;
        } else if($img == 'upd_failed') {
            echo 'upd_failed';
            exit;
        } 

        // send confirmation link to user's email
        $token = bin2hex(random_bytes(16));
        $email = $data['email'];

        $sendEmail = sendMail($email, $token, "email_confirmation");
        
        if(!$sendEmail) {
            echo 'mail_failed';
            exit;
        } 

        $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

        $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, `pincode`, `dob`,
         `profile`, `password`, `token`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $values = [$data['name'], $data['email'], $data['address'], $data['phonenum'], $data['pincode'],
        $data['dob'], $img, $enc_pass, $token];

        if(insert($query, $values, 'sssssssss')) {
            echo 1;
        } else {
            echo 'ins_failed';
        }

        

    }

    if(isset($_POST['login'])) {
        $data = filteration($_POST);

        $u_exist = select("SELECT * FROM `user_cred` WHERE `email` = ? OR `phonenum` = ? LIMIT 1",
         [$data['email_mob'], $data['email_mob']], "ss");
        
        if(mysqli_num_rows($u_exist) == 0) {
            echo 'inv_email_mob';
        } else {
            $u_fetch = mysqli_fetch_assoc($u_exist);
            if($u_fetch['is_verified'] == 0) {
                echo 'not_verified';
            } else if($u_fetch['status'] == 0) {
                echo 'inactive';
            } else {
                if(!password_verify($data['pass'], $u_fetch['password'])) {
                    echo 'invalid_pass';
                } else {
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uId'] = $u_fetch['id'];
                    $_SESSION['uName'] = $u_fetch['name'];
                    $_SESSION['uPic'] = $u_fetch['profile'];
                    $_SESSION['uPhone'] = $u_fetch['phonenum'];
                    echo 1;
                }
            }
        }
        
        
    }

    if(isset($_POST['forgot_pass'])) {
        $data = filteration($_POST);

        $u_exist = select("SELECT * FROM `user_cred` WHERE `email` = ? LIMIT 1", [$data['email']], "s");
        
        if(mysqli_num_rows($u_exist) == 0) {
            echo 'inv_email';
        } else {
            $u_fetch = mysqli_fetch_assoc($u_exist);
            if($u_fetch['is_verified'] == 0) {
                echo 'not_verified';
            } else if($u_fetch['status'] == 0) {
                echo 'inactive';
            }
            else {
                // send reset link to email
                $token = bin2hex(random_bytes(16));
                $email = $data['email'];
                if(!sendMail($email, $token, "account_recovery")) {
                    echo 'mail_failed';
                } else {
                    $date = date("Y-m-d");
                    
                    $query = mysqli_query($con, "UPDATE `user_cred` SET `token`='$token',`t_expire`='$date' 
                        WHERE `id`='$u_fetch[id]'");

                    if($query) {
                        echo 1;
                    } else {
                        echo 'upd_failed';
                    }
                }
            }
        }
    }

    if(isset($_POST['recovery_pass'])) {
        $data = filteration($_POST);

        $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

        $query = "UPDATE `user_cred` SET `password`=?, `token`=?,`t_expire`=? 
            WHERE `email`=? AND `token`=?"; 
        
        $values = [$enc_pass, null, null, $data['email'], $data['token']];

        if(update($query, $values, 'sssss')) {
            echo 1;
        } else {
            echo 'failed';
        }

    }
?>