<?php

class Knack {
    private static $context = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>  "Accept-language: en\r\n" . "X-Knack-Application-Id:" . KNACK_ID . "\r\n" . "X-Knack-REST-API-KEY:" . KNACK_KEY . "\r\n"
    ));
    
    public static function getID($table, $id, $code=NULL){
        $apiUrl = KNACK_URL . "objects/" . $table . "/records";

        //Field_110 = Link Show
        //Field_109 = Verification Code
        
        if(!isset($code)) {
//            $filters = '{"match":"and","rules":[{"field":"field_110_raw","operator":"is","value":"' . $id . '"}]}';
            $filters = '{"match":"and","rules":[{"field":"field_110","operator":"is","value":"' . $id . '"}]}';
        } else {
//            $filters = '{"match":"and","rules":[{"field":"field_110_raw","operator":"is","value":"' . $id . '"},{"field":"field_109_raw","operator":"is","value":"' . $code . '"}]}';
            $filters = '{"match":"and","rules":[{"field":"field_110","operator":"is","value":"' . $id . '"},{"field":"field_109","operator":"is","value":"' . $code . '"}]}';
        }
        
        // with child records will need to use
        // . '&rows_per_page=1000';
        
        $apiUrl .= '?filters=' . urlencode($filters);
        $find = json_decode(file_get_contents($apiUrl, false, stream_context_create(self::$context)));
      
        if (isset($find->records[0])) {
            return $find->records[0]->id;
        }
        return false;
    }

    public static function getObject($table, $id) {
        $apiUrl = KNACK_URL . "objects/" . $table . "/records/" . $id;
        if($record = json_decode(file_get_contents($apiUrl, false, stream_context_create(self::$context)))) {
            return $record;
        }
        return false;
    }
    
    public static function getClassificationCode($classification) {
        $apiUrl = KNACK_URL . "objects/" . T_IMAGECLASSIFICATIONS . "/records";
        
        $filters = '{"match":"and","rules":[{"field":"field_38","operator":"is","value":"' . $classification . '"}]}';
        $apiUrl .= '?filters=' . urlencode($filters);
        
        $find = json_decode(file_get_contents($apiUrl, false, stream_context_create(self::$context)));

        if (isset($find->records[0])) {
            return $find->records[0]->field_113;
        }
        
        return false;
    } 
    
    public static function getClassification($classCode) {
        $apiUrl = KNACK_URL . "objects/" . T_IMAGECLASSIFICATIONS . "/records";
        
        $filters = '{"match":"and","rules":[{"field":"field_113","operator":"is","value":"' . $classCode . '"}]}';
        $apiUrl .= '?filters=' . urlencode($filters);
        
        $find = json_decode(file_get_contents($apiUrl, false, stream_context_create(self::$context)));

        if (isset($find->records[0])) {
            return $find->records[0]->field_38;
        }
        
        return false;
    }
    
    public static function getAdminEmails() {
        $apiUrl = KNACK_URL . "objects/" . T_ADMINISTRATORS . "/records?rows_per_page=1000";
        $admins = json_decode(file_get_contents($apiUrl, false, stream_context_create(self::$context)));

        $email_adm = array();
        foreach($admins->records as $admin) {
            if ($admin->field_114_raw) {
                $email_adm[] = array(
                    'name'=>$admin->field_14,
                    'email'=>$admin->field_15_raw->email,
                    'type'=>'Aladdin Corporate'
                );
            }
        }
        return $email_adm;
    }
   
}


