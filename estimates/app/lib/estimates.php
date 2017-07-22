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
    
    private $internalCount;
    private $internalId;
    private $validationCode;

    
    
    public function __construct($object) {
        $this->id = $object->id;
        $this->jobName = $object->field_1_raw;
        $this->status = $object->field_79_raw;
        
        $this->street1 = $object->field_32_raw->street;
        $this->street2 = $object->field_32_raw->street2;
        $this->city = $object->field_32_raw->city;
        $this->state = $object->field_32_raw->state;
        $this->zip = $object->field_32_raw->zip;
        
        $this->roofType = $object->field_34_raw[0]->identifier;
        $this->roofTypeId = $object->field_34_raw[0]->id;
        $this->roofAge = $object->field_35_raw;
        $this->overallNote = $object->field_88_raw;
        $this->estimatedCost = $object->field_87_raw;
        $this->estimator = $object->field_41_raw[0]->identifier;
        $this->estimatorId = $object->field_41_raw[0]->id;
        
        $this->generalConditions['debris'] = $object->field_42_raw;
        $this->generalConditions['drainage'] = $object->field_43_raw;
        $this->generalConditions['structural'] = $object->field_48_raw;
        $this->generalConditions['physical'] = $object->field_49_raw;
        $this->generalConditions['alterations'] = $object->field_50_raw;
        $this->generalConditionNotes  = $object->field_51_raw;
        
        $this->surfaceConditions['missingMaterial'] = $object->field_44_raw;
        $this->surfaceConditions['buckledMaterial'] = $object->field_45_raw;
        $this->surfaceConditions['deformedEdges'] = $object->field_52_raw;
        $this->surfaceConditions['surfaceStaining'] = $object->field_53_raw;
        $this->surfaceConditions['granularLoss'] = $object->field_54_raw;
        $this->surfaceConditions['crackedTile'] = $object->field_55_raw;
        $this->surfaceConditions['exposedUnderlayment'] = $object->field_56_raw;
        $this->surfaceConditions['missingMortar'] = $object->field_57_raw;
        $this->surfaceConditions['denting'] = $object->field_58_raw;
        $this->surfaceConditions['blistering'] = $object->field_59_raw;
        $this->surfaceConditions['ponding'] = $object->field_60_raw;
        $this->surfaceConditions['corrosion'] = $object->field_61_raw;
        $this->surfaceConditions['missingFasteners'] = $object->field_62_raw;
        $this->surfaceConditions['missingCaulking'] = $object->field_65_raw;
        $this->surfaceConditions['deteriorationDecking'] = $object->field_63_raw;
        $this->surfaceConditionNotes = $object->field_64_raw;
        
        $this->roofingFeatures['fascia'] = $object->field_46_raw;
        $this->roofingFeatures['soffit'] = $object->field_47_raw;
        $this->roofingFeatures['flashing'] = $object->field_66_raw;
        $this->roofingFeatures['gutters'] = $object->field_67_raw;
        $this->roofingFeatures['chimney'] = $object->field_68_raw;
        $this->roofingFeatures['skylights'] = $object->field_69_raw;
        $this->roofingFeatures['vents'] = $object->field_70_raw;
        $this->roofingFeatures['jacks'] = $object->field_71_raw;
        $this->roofingFeatures['satellite'] = $object->field_72_raw;
        $this->roofingFeatures['solarPanels'] = $object->field_73_raw;
        $this->roofingFeatures['valley'] = $object->field_74_raw;
        $this->roofingFeatures['crickets'] = $object->field_75_raw;
        $this->roofingFeatureNotes = $object->field_76_raw;
        
        $this->exteriorSurfaces['finish'] = $object->field_80_raw;
        $this->exteriorSurfaces['surface'] = $object->field_81_raw;
        $this->exteriorSurfaceNotes = $object->field_82_raw;
    
        $this->interiorConditions['cracks'] = $object->field_83_raw;
        $this->interiorConditions['leaks'] = $object->field_84_raw;
        $this->interiorConditions['interiorStaining'] = $object->field_85_raw;
        $this->interiorConditionNotes = $object->field_86_raw;
        
//40 and 93 images, contacts
        
        $this->internalCount = $object->field_99_raw;
        $this->dateCreated['full'] = $object->field_105;
        $this->dateCreated['date'] = $object->field_105_raw->date;
        $this->dateCreated['hour'] = $object->field_105_raw->hours;
        $this->dateCreated['min'] = $object->field_105_raw->minutes;
        $this->dateCreated['ampm'] = $object->field_105_raw->am_pm;
        
        $this->internalId = $object->field_110_raw;
        $this->validationCode = $object->field_109_raw;
        
    }
}
