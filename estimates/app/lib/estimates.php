<?php

class Estimate {
    
    public $id;
    public $jobName;
    public $status;

    public $street1;
    public $street2;
    public $city;
    public $state;
    public $zip;
    
    public $roofType;
    public $roofTypeId;
    public $roofAge;
    public $overallNote;
    public $estimatedCost;
    public $estimator;
    private $estimatorId;
    public $dateCreated;

    public $contacts;
    
    public $generalConditions;
    public $generalConditionNotes;
    public $surfaceConditions;
    public $surfaceConditionNotes;
    public $roofingFeatures;
    public $roofingFeatureNotes;
    public $exteriorSurfaces;
    public $exteriorSurfaceNotes;
    public $interiorConditions;
    public $interiorConditionNotes;
    
    public $images;
    
    public $internalCount;
    public $internalId;
    public $validationCode;
    
    public function __construct($id) {
        $estimate = Knack::getObject(T_ESTIMATES, $id);
        
        $this->id = $estimate->id;
        $this->jobName = $estimate->field_1_raw;
        $this->status = $estimate->field_79_raw;
        
        $this->street1 = $estimate->field_32_raw->street;
        $this->street2 = $estimate->field_32_raw->street2;
        $this->city = $estimate->field_32_raw->city;
        $this->state = $estimate->field_32_raw->state;
        $this->zip = $estimate->field_32_raw->zip;
        
        $this->roofType = $estimate->field_34_raw[0]->identifier;
        $this->roofTypeId = $estimate->field_34_raw[0]->id;
        $this->roofAge = $estimate->field_35_raw;
        $this->overallNote = $estimate->field_88_raw;
        $this->estimatedCost = $estimate->field_87_raw;
        $this->estimator = $estimate->field_41_raw[0]->identifier;
        $this->estimatorId = $estimate->field_41_raw[0]->id;
        
        $this->generalConditions['debris'] = $estimate->field_42_raw;
        $this->generalConditions['drainage'] = $estimate->field_43_raw;
        $this->generalConditions['structural'] = $estimate->field_48_raw;
        $this->generalConditions['physical'] = $estimate->field_49_raw;
        $this->generalConditions['alterations'] = $estimate->field_50_raw;
        $this->generalConditionNotes  = $estimate->field_51_raw;
        
        $this->surfaceConditions['missingMaterial'] = $estimate->field_44_raw;
        $this->surfaceConditions['buckledMaterial'] = $estimate->field_45_raw;
        $this->surfaceConditions['deformedEdges'] = $estimate->field_52_raw;
        $this->surfaceConditions['surfaceStaining'] = $estimate->field_53_raw;
        $this->surfaceConditions['granularLoss'] = $estimate->field_54_raw;
        $this->surfaceConditions['crackedTile'] = $estimate->field_55_raw;
        $this->surfaceConditions['exposedUnderlayment'] = $estimate->field_56_raw;
        $this->surfaceConditions['missingMortar'] = $estimate->field_57_raw;
        $this->surfaceConditions['denting'] = $estimate->field_58_raw;
        $this->surfaceConditions['blistering'] = $estimate->field_59_raw;
        $this->surfaceConditions['ponding'] = $estimate->field_60_raw;
        $this->surfaceConditions['corrosion'] = $estimate->field_61_raw;
        $this->surfaceConditions['missingFasteners'] = $estimate->field_62_raw;
        $this->surfaceConditions['missingCaulking'] = $estimate->field_65_raw;
        $this->surfaceConditions['deteriorationDecking'] = $estimate->field_63_raw;
        $this->surfaceConditionNotes = $estimate->field_64_raw;
        
        $this->roofingFeatures['fascia'] = $estimate->field_46_raw;
        $this->roofingFeatures['soffit'] = $estimate->field_47_raw;
        $this->roofingFeatures['flashing'] = $estimate->field_66_raw;
        $this->roofingFeatures['gutters'] = $estimate->field_67_raw;
        $this->roofingFeatures['chimney'] = $estimate->field_68_raw;
        $this->roofingFeatures['skylights'] = $estimate->field_69_raw;
        $this->roofingFeatures['vents'] = $estimate->field_70_raw;
        $this->roofingFeatures['jacks'] = $estimate->field_71_raw;
        $this->roofingFeatures['satellite'] = $estimate->field_72_raw;
        $this->roofingFeatures['solarPanels'] = $estimate->field_73_raw;
        $this->roofingFeatures['valley'] = $estimate->field_74_raw;
        $this->roofingFeatures['crickets'] = $estimate->field_75_raw;
        $this->roofingFeatureNotes = $estimate->field_76_raw;
        
        $this->exteriorSurfaces['finish'] = $estimate->field_80_raw;
        $this->exteriorSurfaces['surface'] = $estimate->field_81_raw;
        $this->exteriorSurfaceNotes = $estimate->field_82_raw;
    
        $this->interiorConditions['cracks'] = $estimate->field_83_raw;
        $this->interiorConditions['leaks'] = $estimate->field_84_raw;
        $this->interiorConditions['interiorStaining'] = $estimate->field_85_raw;
        $this->interiorConditionNotes = $estimate->field_86_raw;
        
//40 and 93 images, contacts
        
        $this->internalCount = $estimate->field_99_raw;
        $this->dateCreated['full'] = $estimate->field_105;
        $this->dateCreated['date'] = $estimate->field_105_raw->date;
        $this->dateCreated['hour'] = $estimate->field_105_raw->hours;
        $this->dateCreated['min'] = $estimate->field_105_raw->minutes;
        $this->dateCreated['ampm'] = $estimate->field_105_raw->am_pm;
        
        $this->internalId = $estimate->field_110_raw;
        $this->validationCode = $estimate->field_109_raw;

        // Get Contacts (field_93)
        foreach($estimate->field_93_raw as $contact) {
            $this->contacts[] = new Contact($contact->id);
        }

        // Get Images (field_40)
        foreach($estimate->field_40_raw as $image) {
            $this->images[] = new Image($image->id);
        }
    }
}
