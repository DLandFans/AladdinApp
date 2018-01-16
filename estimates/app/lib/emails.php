<?php

class Email {
    
    public static function prepareEmails(EstimateMail $estimate){

        $email_est = array();
        
        if (isset($estimate->contacts)) {
            foreach($estimate->contacts as $contact) {
                $email_est[] = array(
                    'name'=>$contact->fullName,
                    'email'=>$contact->email,
                    'type'=>$contact->type
                );
            }
        }
        
        if (isset($estimate->estimator)) {
            $email_est[] = array(
                'name'=>$estimate->estimator,
                'email'=>$estimate->estimatorEmail,
                'type'=>ESTIMATOR_TYPE
            );
        } 
        
        
        return array_merge($email_est,Knack::getAdminEmails());
        
    }
    
    public static function sendEmails($sendEmailList, $estimateArray) { 
        
        $mail = new PHPMailer(); // create a new object
        
        $mail->IsSMTP(); 
//        $mail->SMTPDebug = 3;

        $mail->SMTPAuth = SMTP_AUTH; 
        $mail->SMTPSecure = SMTP_SECURE;
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

        $mail->Subject = "Aladdin Roofing Inpsection for " . $estimateArray['jobName'] . " (" . $estimateArray['date'] . ")";

        $body = "A roof inspection report has been completed for you and may viewed here. Any deficiencies that have been found will be detailed on this report along with the estimated costs for repairs.<br /><br />";
        $body .= "<a href='" . BASE_URL . $estimateArray['id'] . "'>View your inpsection report for " . $estimateArray['jobName'] . "</a><br /><br />";
        $body .= "Aladdin Roofing<br />";
        $body .= "<a href='tel:6022967354'>(602) 296-7354</a><br />";
        $body .= "AZ ROC #195596";
        
        $mail->Body = $body;
        
        if(!$mail->send()) {
//            echo "<br><br><pre><br><br>";
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;   
//            
//            var_dump($mail);
//            exit;
            return false;
        } 
       
        return $sendEmailList;
    }

    public static function sendApprovalNotification($sendEmailList, $estimateArray) { 
        
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
            $mail->addAddress($sendto['email'], $sendto['name']);
        }
       
        $mail->Subject = "Aladdin Roofing Estimate #" . $estimateArray->field_99_raw . " Approved (" . $estimateArray->field_1_raw . ")";
        
        $body =  "Estimate #" . $estimateArray->field_99_raw . " Approved<br />";
        $body .= "Name: " . $estimateArray->field_1_raw . "<br />";
        
        $body .= "Address: " . $estimateArray->field_32_raw->street . " ";

        if ($estimateArray->field_32_raw->street2) {
            $body .= $estimateArray->field_32_raw->street2 . " ";
        }

        $body .= $estimateArray->field_32_raw->city . ", " . $estimateArray->field_32_raw->state . "  " . $estimateArray->field_32_raw->zip . "<br />";
        $body .= "Approved by: " . $estimateArray->field_156_raw . "<br /><br />";
        $body .= "View the here: <a href='" . BASE_URL . $estimateArray->field_110_raw . "'>" . $estimateArray->field_1_raw . "</a><br /><br />";
        $body .= "<a href='http://aladdinroofing.com/estimates/#estimate-status/?view_238_filters=%7B%22match%22%3A%22and%22%2C%22rules%22%3A%5B%7B%22field%22%3A%22field_79%22%2C%22operator%22%3A%22is%22%2C%22value%22%3A%22Approved%22%2C%22field_name%22%3A%22Job%20Status%22%7D%5D%7D&view_238_page=1'>View all Approved Jobs waiting to be verifited.</a>";
        $mail->Body = $body;
        
        if(!$mail->send()) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;   
            return false;
        } 
       
        return true;
    }
}