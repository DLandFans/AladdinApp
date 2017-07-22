<?php

class Knack {
    private $context;
    
    public function __construct($id,$key,$url) {
        $this->context = stream_context_create(array(
            'http'=>array(
                'method'=>"GET",
                'header'=>  "Accept-language: en\r\n" . "X-Knack-Application-Id:" . KNACK_ID . "\r\n" . "X-Knack-REST-API-KEY:" . KNACK_KEY . "\r\n"
        )));
    }
    
    public function getID($table, $id, $code=NULL){
        $apiUrl = KNACK_URL . "objects/" . $table . "/records";

        //Field_112 = Link Show
        //Field_109 = Verification Code
        
        if(!isset($code)) {
            $filters = '{"match":"and","rules":[{"field":"field_112","operator":"is","value":"' . $id . '"}]}';
        } else {
            $filters = '{"match":"and","rules":[{"field":"field_112","operator":"is","value":"' . $id . '"},{"field":"field_109","operator":"is","value":"' . $code . '"}]}';
        }

        // with child records will need to use
        // . '&rows_per_page=1000';
        
        $apiUrl .= '?filters=' . urlencode($filters);
        $find = json_decode(file_get_contents($apiUrl, false, $this->context));

        if (isset($find->records[0])) {
            return $find->records[0]->id;
        }
        return false;
    }

    public function getObject($table, $id) {
        $apiUrl = KNACK_URL . "objects/" . $table . "/records/" . $id;
        if($record = json_decode(file_get_contents($apiUrl, false, $this->context))) {
            return $record;
        }
        return false;
    }
    
}
