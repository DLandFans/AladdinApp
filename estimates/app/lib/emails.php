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
    
}