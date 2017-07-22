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
            $filters = '{"match":"and","rules":[{"field":"field_110_raw","operator":"is","value":"' . $id . '"}]}';
        } else {
            $filters = '{"match":"and","rules":[{"field":"field_110_raw","operator":"is","value":"' . $id . '"},{"field":"field_109_raw","operator":"is","value":"' . $code . '"}]}';
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
    
}


//class Knack {
//    private $context = array(
//            'http'=>array(
//                'method'=>"GET",
//                'header'=>  "Accept-language: en\r\n" . "X-Knack-Application-Id:" . KNACK_ID . "\r\n" . "X-Knack-REST-API-KEY:" . KNACK_KEY . "\r\n"
//    ));
//    
//    public function getID($table, $id, $code=NULL){
//        $apiUrl = KNACK_URL . "objects/" . $table . "/records";
//
//        //Field_110 = Link Show
//        //Field_109 = Verification Code
//        
//        if(!isset($code)) {
//            $filters = '{"match":"and","rules":[{"field":"field_110_raw","operator":"is","value":"' . $id . '"}]}';
//        } else {
//            $filters = '{"match":"and","rules":[{"field":"field_110_raw","operator":"is","value":"' . $id . '"},{"field":"field_109_raw","operator":"is","value":"' . $code . '"}]}';
//        }
//
//        // with child records will need to use
//        // . '&rows_per_page=1000';
//        
//        $apiUrl .= '?filters=' . urlencode($filters);
//        $find = json_decode(file_get_contents($apiUrl, false, stream_context_create($this->context)));
//       
//        if (isset($find->records[0])) {
//            return $find->records[0]->id;
//        }
//        return false;
//    }
//
//    public function getObject($table, $id) {
//        $apiUrl = KNACK_URL . "objects/" . $table . "/records/" . $id;
//        if($record = json_decode(file_get_contents($apiUrl, false, stream_context_create($this->context)))) {
//            return $record;
//        }
//        return false;
//    }
//    
//}
