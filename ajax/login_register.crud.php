<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');
    require('../inc/phpmailer/Exception.php');
    require('../inc/phpmailer/PHPMailer.php');
    require('../inc/phpmailer/SMTP.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($to, $content) {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
    
        try {
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
            $mail->addAddress($to);     //Add a recipient
    
            
    
            //Content
            $mail-> CharSet = "UTF-8";
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Account Verification Link';
            $mail->Body    = $content;
    
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
        $content = "Click the link to confirm you email: <br>
        <a href='".SITE_URL."email_confirm.php?email_confirmation&email=$email&token=$token". "'>
            CLICK ME
        </a>
        ";

        $sendEmail = sendMail($email, $content);
        
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



   

?>