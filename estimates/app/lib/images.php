<?php

class Image {
    
    public $id;
    public $description;
    
    public $imageName;
    public $imageUrl;
    public $imageUrl_480;
    public $imageUrl_1280;
    
    public $category;
    public $catId;
    
    
    public function __construct($image) {
       
        //$image = Knack::getObject(T_IMAGES, $id);
        
        $this->id = $image->id;
        $this->description = $image->field_36_raw;
        
        $this->imageName = $image->field_37_raw->filename;
        $this->imageUrl = $image->field_37_raw->url;

        $this->imageUrl_480 = $this->stripAmazonImage($image->{'field_37:thumb_3'});
        $this->imageUrl_1280 = $this->stripAmazonImage($image->{'field_37:thumb_5'});

        $this->category = $image->field_161_raw[0]->identifier;
        $this->catId = $image->field_161_raw[0]->id;
        
    }
    
    private function stripAmazonImage($value) {
        $value = substr($value,10,strlen($value)-10);
        $value = substr($value,0,strlen($value)-4);
        return $value;
    }
    
}