<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'florian.thomy01@gmail.com'; // Votre email Gmail
        $mail->Password = 'votre_mot_de_passe_d_application'; // Votre mot de passe d'application Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Destinataires
        $mail->setFrom($email, $name);
        $mail->addAddress('florian.thomy01@gmail.com');

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message de contact - Portfolio';
        $mail->Body = "
            <h2>Nouveau message de contact</h2>
            <p><strong>Nom:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        ";

        $mail->send();
        header("Location: index.php?status=success#contact");
    } catch (Exception $e) {
        header("Location: index.php?status=error#contact");
    }
} else {
    header("Location: index.php#contact");
}
exit();
?>