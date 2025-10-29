<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__.'/../config/config.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

class MakeAndSendCode {
    public static function sendCode($email) {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $code = random_int(100000, 999999); 

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = AUTH_EMAIL;
            $mail->Password = AUTH_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(AUTH_EMAIL, 'M-Blogger');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Mã xác nhận lấy lại mật khẩu';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif;'>
                    <h2>Xin chào!</h2>
                    <p>Bạn đã yêu cầu lấy lại mật khẩu.</p>
                    <p>Mã xác nhận của bạn là:</p>
                    <h1 style='color:#007bff;'>$code</h1>
                    <p>Mã có hiệu lực trong 5 phút.</p>
                </div>
            ";

            $mail->send();

            return [
                'success' => true,
                'message' => 'Đã gửi mã xác nhận!',
                'email' => $email,
                'code' => $code
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => "Gửi email thất bại: {$mail->ErrorInfo}"
            ];
        }
    }
}

