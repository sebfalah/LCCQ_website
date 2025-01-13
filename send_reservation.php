<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $date = $data['date'];
    $guests = $data['guests'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.mail.yahoo.com'; // Yahoo's SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'lacasadelcangrejo@yahoo.com'; // Your Yahoo email
        $mail->Password = 'lmshlasjdcrgveih'; // Your Yahoo App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('lacasadelcangrejo@yahoo.com', 'La Casa del Cangrejo');
        $mail->addAddress('lacasadelcangrejo@yahoo.com'); // The recipient email

        // Content
        $mail->isHTML(false);
        $mail->Subject = "Nueva Reserva de $name";
        $mail->Body = "Detalles de la reserva:\n\n" .
                      "Nombre: $name\n" .
                      "Correo: $email\n" .
                      "Teléfono: $phone\n" .
                      "Fecha: $date\n" .
                      "Número de Personas: $guests\n";

        $mail->send();
        http_response_code(200);
        echo json_encode(["message" => "Reserva enviada con éxito"]);
    } catch (Exception $e) {
        file_put_contents('reservation_log.txt', "PHPMailer Error: " . $mail->ErrorInfo . "\n", FILE_APPEND);
        http_response_code(500);
        echo json_encode(["message" => "Error al enviar la reserva."]);
    }
} else {
    file_put_contents('reservation_log.txt', "No data received.\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(["message" => "Datos inválidos recibidos."]);
}
?>
