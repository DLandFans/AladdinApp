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
                $this->recId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                $this->recCode = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
                break;
            default:
                $this->type = null;
        }
    }
}