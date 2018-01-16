<?php

abstract class Estimate {
    
    //Knack ID, Label, Show, Notes
    public $sections = array(
        'overview' => array('5a58efcbbc11bc604d56a1e7','Overview Images',true,'',''),
        'generalConditions' => 
            array('5a58efde78281560a59a9332','General Conditions',true,'',
            '<p>Our inspection of the general roofing conditions includes the following inspection points when applicable:</p>
                <ul>
                    <li>Presence of Debris</li>
                    <li>Physical Damage to the Overall Roofing System</li>
                    <li>Structural Integrity of Roofing System</li>
                    <li>Integrity of Alterations to the Original Roofing System</li>
                    <li>Evidence or Presence of Drainage Problems</li>
                </ul>'
        ),
        'exteriorSurfaces' => 
            array('5a58eff0fc8cea6116f78a39','Exterior Surfaces',true,'',
            '<p>Our inspection of the exterior roofing surfaces includes the following inspection points when applicable:</p>
                <ul>
                    <li>Missing Material Including Tile, Underlayment, Caulk, Mortar and Other Materials</li>
                    <li>Damaged Material Including Tile, Tile, Underlayment, Caulk, Mortar and Other Materials</li>
                    <li>Damage or Deterioration of the Finish</li>
                    <li>Presence of Buckled or Deformed Material</li>
                    <li>Presence of Staining</li>
                    <li>Granular Loss to Tiles</li>
                    <li>Presence of Cracked Tiles</li>
                    <li>Presence of Exposed Underlayment</li>
                    <li>Missing or Loss of Mortar</li>
                    <li>Presence of Dents or Marks to Roofing Material</li>
                    <li>Presence of Blistering</li>
                    <li>Evidence of Ponding</li>
                    <li>Presence of Corrosion</li>
                    <li>Missing or Exposed Fasteners</li>
                    <li>Missing or Loss of Caulking</li>
                    <li>Evidence or Presence of Deteriorated Decking</li>
                </ul>'
        ),
        'roofingFeatures' => 
            array('5a58effe93171661026e1541','Roofing Features',true,'',
            '<p>Our inspection of the roofing features includes the following inspection points when applicable:</p>
                <ul>
                    <li>Damaged or Deteriorated Fascia</li>
                    <li>Damaged or Deteriorated Soffit</li>
                    <li>Damaged or Missing Flashing</li>
                    <li>Damaged or Missing Gutters</li>
                    <li>Damage or Deterioration of Valleys</li>
                    <li>Damaged Chimney</li>
                    <li>Damaged Skylights</li>
                    <li>Damaged or Missing Vents</li>
                    <li>Damaged or Missing Roof Pipe Jacks</li>
                    <li>Damaged or Missing Crickets</li>
                    <li>Damage or Problems Associated with Satellite TV Installation</li>
                    <li>Damage or Problems Associated with Solar Panel Installation</li>
                </ul>'
        ),
        'interiorConditions' => 
            array('5a58f00428582b5f294cb66c','Interior Conditions',true,'',
            '<p>Our inspection of the property interior for roofing associated problems includes the following inspection points when applicable:</p>
                <ul>
                    <li>Presence of Cracks</li>
                    <li>Evidence or Presence of Leaks</li>
                    <li>Evidence or Presence of Staining</li>
                    <li>Evidence or Presence of Damaged Drywall</li>
                    <li>Damage to Textured Finish</li>
                    <li>Evidence or Presence of Damaged Insulation Material (If Accessible)</li>
                </ul>'
        )
    );
    
    public $id;
    public $jobName;
    public $status;

    public $street1;
    public $street2;
    public $city;
    public $state;
    public $zip;
    
    public $stories;
    public $roofType;
    public $roofTypeId;
    public $roofAge;
    public $overviewNote;
    public $estimator;
    public $dateEstimated;
    public $estimatorId;
    public $dateCreated;

    public $repairCost;
    public $repairNote;
    public $reroofCost;
    public $reroofNote;
    
    public $contacts;
    
//    public $generalConditionNote;
//    public $exteriorSurfaceNote;
//    public $roofingFeatureNote;
//    public $interiorFeatureNote;
    
    public $showRepair;
    public $showReroof;
//    public $showGeneral;
//    public $showExterior;
//    public $showRoofing;
//    public $showInterior;
    
    public $internalCount;
    public $internalId;
    public $validationCode;
    
    
    
    
//    public function __construct($id) {
    public function __construct($id, $code=NULL) {
//        $estimate = Knack::getObject(T_ESTIMATES, $id);
        
        if(!$estimate = Knack::getEstimateByFilter($id,$code)) { return false; }
        
        $this->id = $estimate->id;
        $this->jobName = $estimate->field_1_raw;
        $this->status = $estimate->field_79_raw;
        
        $this->street1 = $estimate->field_32_raw->street;
        $this->street2 = $estimate->field_32_raw->street2;
        $this->city = $estimate->field_32_raw->city;
        $this->state = $estimate->field_32_raw->state;
        $this->zip = $estimate->field_32_raw->zip;
        
        $this->stories = $estimate->field_153_raw;
        $this->roofType = $estimate->field_34_raw[0]->identifier;
        $this->roofTypeId = $estimate->field_34_raw[0]->id;
        $this->roofAge = $estimate->field_35_raw;
        $this->estimator = $estimate->field_41_raw[0]->identifier;
        $this->estimatorId = $estimate->field_41_raw[0]->id;

        $this->repairCost = $estimate->field_87_raw;
        $this->repairNote = $estimate->field_163_raw;
        $this->reroofCost = $estimate->field_158_raw;
        $this->reroofNote = $estimate->field_159_raw;
        
        $this->overviewNote = $estimate->field_88_raw;  //Overall Notes
 
  
//        $this->generalConditionNote = $estimate->field_51_raw;
//        $this->exteriorSurfaceNote = $estimate->field_64_raw;
//        $this->roofingFeatureNote = $estimate->field_76_raw;
//        $this->interiorFeatureNote = $estimate->field_86_raw;
        
        $this->sections['generalConditions'][3] = $estimate->field_51_raw;
        $this->sections['exteriorSurfaces'][3] = $estimate->field_64_raw;
        $this->sections['roofingFeatures'][3] = $estimate->field_76_raw;
        $this->sections['interiorConditions'][3] = $estimate->field_86_raw;
        
        
        
        $this->internalCount = $estimate->field_99_raw;
        $this->dateCreated['full'] = $estimate->field_105;
        $this->dateCreated['date'] = $estimate->field_105_raw->date;
        $this->dateCreated['hour'] = $estimate->field_105_raw->hours;
        $this->dateCreated['min'] = $estimate->field_105_raw->minutes;
        $this->dateCreated['ampm'] = $estimate->field_105_raw->am_pm;

        $this->dateEstimated['full'] = $estimate->field_152;
        $this->dateEstimated['date'] = $estimate->field_152_raw->date;
        $this->dateEstimated['hour'] = $estimate->field_152_raw->hours;
        $this->dateEstimated['min'] = $estimate->field_152_raw->minutes;
        $this->dateEstimated['ampm'] = $estimate->field_152_raw->am_pm;
        
        
        $this->showRepair = $estimate->field_164_raw;
        $this->showReroof = $estimate->field_165_raw;
        
//        $this->showGeneral = $estimate->field_166_raw;
//        $this->showExterior = $estimate->field_167_raw;
//        $this->showRoofing = $estimate->field_168_raw;
//        $this->showInterior = $estimate->field_169_raw;

        $this->sections['generalConditions'][2] = $estimate->field_166_raw;
        $this->sections['exteriorSurfaces'][2] = $estimate->field_167_raw;
        $this->sections['roofingFeatures'][2] = $estimate->field_168_raw;
        $this->sections['interiorConditions'][2] = $estimate->field_169_raw;

        $this->internalId = $estimate->field_110_raw;
        $this->validationCode = $estimate->field_109_raw;

        // Get Contacts (field_93)
        if(isset($estimate->field_93_raw)){
            foreach(Knack::getRecordsByIds($estimate->field_93_raw, T_CONTACTS) as $contact) {
                $this->contacts[] = new Contact($contact);
            }
        }
        
        return $estimate;
        
    }
}

//The view doesn't need the estimators email so don't need to include (or call the API)
class EstimateView extends Estimate {
 
    public $images;
    
    public function __construct($id, $code=NULL) {
//    public function __construct($id) {
        if(!$estimate = parent::__construct($id,$code)) { return false; }
        
        // Get Images (field_40)
        if(isset($estimate->field_40_raw)){
            foreach(Knack::getRecordsByIds($estimate->field_40_raw,T_IMAGES) as $image) {
                $this->images[] = new Image($image);
            }
        } 
        
        return true;
    }
}

//The email doesn't need the images so is doesn't call or use an API usage charge
class EstimateMail extends Estimate {

    public $estimatorEmail;

    public function __construct($id, $code=NULL) {
//    public function __construct($id) {
        if(!$estimate = parent::__construct($id,$code)) { return false; }
        
        $this->estimatorEmail = Knack::getObject(T_ESTIMATORS, $this->estimatorId)->field_28_raw->email;
        
        return true;
    }
    
}

