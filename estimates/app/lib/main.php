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
    
    public function doEstimate()
    {
        if(!$id = Knack::getID(T_ESTIMATES, $this->recId)) return false;
        return Display::estimate(new EstimateView($id));
    }
    
    public function doEmail() 
    {
         
        //Do GET
        if($this->method == "GET") {
            if(!$id = Knack::getID(T_ESTIMATES, $this->recId, $this->recCode)) return false;

            $estimate = new EstimateMail($id);
            $emails = Email::prepareEmails($estimate);
            
            return Display::emailChoose($estimate, $emails);
            
        }

        //Do POST
        $emails = $_SESSION['emails'];
        $emailList = filter_input(INPUT_POST, 'emailList', FILTER_VALIDATE_BOOLEAN, FILTER_REQUIRE_ARRAY);
        $estimateArray = $_SESSION['estimateArray'];
        
        $sendEmails = array();
        
        if(count($emailList)>0) {
            foreach($emailList as $id=>$value) {
                $sendEmails[] = array(
                    'name' => $emails[$id]['name'],
                    'email' => $emails[$id]['email'],
                    'type' => $emails[$id]['type']
                );
            } 
        }
        
        $result = Email::sendEmails($sendEmails,$estimateArray);
        return Display::emailSent($result,$estimateArray); 
        
    }
    
}
