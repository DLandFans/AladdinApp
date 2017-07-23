<?php

class Email {
    
    public static function prepareEmails(Estimate $estimate){
        
        $email_est = array();
        
        foreach($estimate->contacts as $contact) {
            $email_est[] = array(
                'name'=>$contact->fullName,
                'email'=>$contact->email
            );
        }
        
        return array_merge($email_est,Knack::getAdminEmails());
        
    }
    
}