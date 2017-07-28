<?php

class Contact {
    
    private $id;
    public $firstName;
    public $lastName;
    public $fullName;
    public $email;
    public $phone;
    public $phoneRaw;
    public $street1;
    public $street2;
    public $city;
    public $state;
    public $zip;
    public $type;
    private $typeId;

    public function __construct($contact) {
        //$contact = Knack::getObject(T_CONTACTS, $id);
        
        $this->id = $contact->id;
        $this->fullName = $contact->field_90;
        $this->firstName = $contact->field_90_raw->first;
        $this->lastName = $contact->field_90_raw->last;
        $this->email = $contact->field_94_raw->email;
        $this->phone = $contact->field_96_raw->formatted;
        $this->phoneRaw = $contact->field_96_raw->full;
        $this->street1 = $contact->field_95_raw->street;
        $this->street2 = $contact->field_95_raw->street2;
        $this->city = $contact->field_95_raw->city;
        $this->state = $contact->field_95_raw->state;
        $this->zip = $contact->field_95_raw->zip;
        $this->type = $contact->field_92_raw[0]->identifier;
        $this->typeId = $contact->field_92_raw[0]->id;
    }
}
