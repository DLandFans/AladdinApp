<?php

class Email {
    
    public static function prepareEmails(Estimate $estimate){

        $email_est = array();

        if (isset($estimate->estimator)) {
            $email_est[] = array(
                'name'=>$estimate->estimator,
                'email'=>$estimate->estimatorEmail,
                'type'=>'Estimator'
            );
        } 
        
        if (isset($estimate->contacts)) {
            foreach($estimate->contacts as $contact) {
                $email_est[] = array(
                    'name'=>$contact->fullName,
                    'email'=>$contact->email,
                    'type'=>$contact->type
                );
            }
        }
        
        
        return array_merge($email_est,Knack::getAdminEmails());
        
    }
    
    public static function sendEmails($list) {
        
       
        $mail = new PHPMailer(); // create a new object

        
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SetFrom("dlandfans@gmail.com");
        $mail->Subject = "Test";
        $mail->Body = "hello";
        $mail->AddAddress("marc@toddtamcsinphotograpy.com");

        var_dump($mail);
        
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message has been sent";
        }
        
        exit;
        
        
        return $list;
    }
    
}