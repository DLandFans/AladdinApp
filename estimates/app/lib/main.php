<?php

class AladdinRoofingApp {
    public $method;
    public $type;
    public $recId;
    public $recCode;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        
        switch ($this->method) {
            case "POST":
//                $this->type = $_POST['page'];
                break;
            case "GET":
                $this->recId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
                $this->recCode = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
                break;
            default:
                $this->type = null;
        }
    }
    
    public function displayEstimate()
    {
        $knack = new Knack(KNACK_ID, KNACK_KEY, KNACK_URL);
        //$id = $knack->getID(T_ESTIMATES, $this->recId);
        if(!$id = $knack->getID(T_ESTIMATES, $this->recId)) return false;


        $estimate = $knack->getObject(T_ESTIMATES, $id);
        var_dump($estimate);
        exit;
        
        $html = "Displaying an estimate with id " . $id;
        return $html;
    }
    
    public function displayEmail() 
    {
        $knack = new Knack(KNACK_ID, KNACK_KEY, KNACK_URL);
        if(!$id = $knack->getID(T_ESTIMATES, $this->recId, $this->recCode)) return false;
        
        $html = "Doing Email with id " . $id;
        return $html;
    }

}
