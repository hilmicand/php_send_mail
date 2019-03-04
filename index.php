<?php

// Local db
$con = new mysqli("ip_address", "user", "password", "database");

  if($_POST){
    $advisor_name = $_POST['adv_name'];
    $advisor_sname = $_POST['adv_sname'];
    $advisor_mail = $_POST['adv_mail'];
    $advisor_msg = $_POST['adv_msg'];
    $current_time = date_timestamp_get(date_create());


    if(isset($_POST['adv_send'])) {
      if($advisor_name != "" && $advisor_sname != "" && $advisor_mail != "" && $advisor_msg != "") {
        if(!strpos($advisor_mail, "@") || !strpos($advisor_mail, "mail")){
          echo "<script>alert('Yazdığınız mail adresi geçersiz....');</script>";
        } else {
          if($con) {
            $query = $con->query("INSERT INTO messages SET msg_id='".$current_time."',
                                                           name='".$advisor_name."',
                                                           sname='".$advisor_sname."',
                                                           email_adress='".$advisor_mail."',
                                                           message='".$advisor_msg."'");

            if($query) {
              sendMail($advisor_mail, $advisor_name);
              echo "<script>alert('Geri bildiriminiz için teşekkürler ".$advisor_name." ".$advisor_sname."');</script>";
            } else {
              echo "<script>alert('Geri bildiriminizi şu anlık alamadık. Daha sonra tekrar denerseniz memnun oluruz...');</script>";
            }
          }
        }
      } else {
        echo "<script>alert('Size zahmet boş alanları doldurur musunuz??');</script>";
      }
    }
  }

  function sendMail($mailadress, $name) {
    /// Yorum yapan kullanıcıya mail gönderme işlemi...

    include "class.phpmailer.php";
    include "class.smtp.php";
    include "class.pop3.php";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->IsHTML(true);
    $mail->Username = 'mail_adresi';
    $mail->Password = 'mail_adresinin_sifresi';
    $mail->SetFrom('mail_adresi', 'Gonderici_basligi');
    $mail->AddAddress($mailadress, $name);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Mesajınızı Aldım :)';
    $mail->MsgHTML("<p>Test</p>");
    if($mail->Send()) {
    } else {
    }
  }

?>

