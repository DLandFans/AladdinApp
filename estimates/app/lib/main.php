<?php

class AladdinRoofingApp {
    public $method;
    public $type;
    public $recId;
    public $recCode;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->recId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $this->recCode = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);

        
        switch ($this->method) {
            case "POST":
//                $this->type = $_POST['page'];
                break;
            case "GET":
//                $this->recId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
//                $this->recCode = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
                break;
            default:
                $this->type = null;
        }
    }
    
    public function displayEstimate()
    {
        if(!$id = Knack::getID(T_ESTIMATES, $this->recId)) return false;

        $estimate = new Estimate(Knack::getObject(T_ESTIMATES, $id));

        var_dump($estimate);
        exit;
        
        $html = "Displaying an estimate with id " . $id;
        return $html;
    }
    
    public function displayEmail() 
    {
        if(!$id = Knack::getID(T_ESTIMATES, $this->recId, $this->recCode)) return false;
        
        $html = "Doing Email with id " . $id;
        return $html;
    }

}
