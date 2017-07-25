<?php

class Email {
    
    public static function prepareEmails(Estimate $estimate){

        $email_est = array();

        if (isset($estimate->estimator)) {
            $email_est[] = array(
                'name'=>$estimate->estimator,
                'email'=>$estimate->estimatorEmail,
                'type'=>ESTIMATOR_TYPE
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
    
    public static function sendEmails($sendEmailList, $estimateArray) { 
        
        $mail = new PHPMailer(); // create a new object
        
        $mail->IsSMTP(); 
//        $mail->SMTPDebug = 1;


        $mail->SMTPAuth = SMTP_AUTH; 
        $mail->Host = SMTP_SERVER;
        $mail->Port = SMTP_PORT;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SetFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        
        $mail->IsHTML(true);
      

        //Queue Emails and set Aladdin Employees to BCC
        foreach($sendEmailList as $sendto) {
            if ($sendto['type'] == ESTIMATOR_TYPE) {
                $mail->addCC($sendto['email'], $sendto['name']);
            } elseif($sendto['type'] == CORPORATE_TYPE) {
                $mail->addBCC($sendto['email'], $sendto['name']);
            } else {
                $mail->addAddress($sendto['email'], $sendto['name']);
            }
        }

        $mail->Subject = "Aladdin Roofing Estimate for " . $estimateArray['jobName'];
        $mail->Body = "Here is your estimate for <a href='" . BASE_URL . $estimateArray['id'] . "'>" . $estimateArray['jobName'] . "</a>";

        
        if(!$mail->send()) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;   
            return false;
        } 
       
        return $sendEmailList;
    }
    
}