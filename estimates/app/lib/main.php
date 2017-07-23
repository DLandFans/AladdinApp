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
    }
    
    public function displayEstimate()
    {

        if(!$id = Knack::getID(T_ESTIMATES, $this->recId)) return false;

        $estimate = new Estimate($id);
        
        return Action::displayEstimate($estimate);
    }
    
    public function displayEmail() 
    {
        //Do GET
        if($this->method == "GET") {
            if(!$id = Knack::getID(T_ESTIMATES, $this->recId, $this->recCode)) return false;

            $estimate = new Estimate($id);
            $emails = Email::prepareEmails($estimate);

            return Action::displayEmail($estimate, $emails);
        }

        //Do POST
        
        $html = "Doing Post";
        return $html;
        
    }
    
}
