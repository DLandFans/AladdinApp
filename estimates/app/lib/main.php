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
            return Action::displayEmail($estimate,$emails);
        }

        //Do POST
        $emails = $_SESSION['emails'];
        $estimate = $_SESSION['estimate'];
        
        $emailList = filter_input(INPUT_POST, 'emailList', FILTER_VALIDATE_BOOLEAN, FILTER_REQUIRE_ARRAY);
        
        foreach($emailList as $id=>$value) 
        {
            $html .= $emails[$id]['name'] . " &lt;" . $emails[$id]['email'] . "&gt;<br>";
        }
        
        $html .= '<br><br><a href="' . BASE_URL . $this->recId . '">View Estimate for ' . $estimate['jobName'] . '</a>';
        
        return $html;
        
    }
    
}
