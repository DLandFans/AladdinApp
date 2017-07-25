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
    public $estimatorEmail;
    public $dateEstimated;
    public $estimatorId;
    public $dateCreated;

    public $contacts;
    
    public $generalConditions;
    public $generalConditionsChecklist;
    public $generalConditionNotes;
    public $surfaceConditions;
    public $surfaceConditionsChecklist;
    public $surfaceConditionNotes;
    public $roofingFeatures;
    public $roofingFeaturesChecklist;
    public $roofingFeatureNotes;
    public $exteriorSurfaces;
    public $exteriorSurfacesChecklist;
    public $exteriorSurfaceNotes;
    public $interiorConditions;
    public $interiorConditionsChecklist;
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
        $this->estimatorEmail = Knack::getObject(T_ESTIMATORS, $this->estimatorId)->field_28_raw->email;
        
        $this->generalConditions['debris'] = $estimate->field_42_raw;
        $this->generalConditions['drainage'] = $estimate->field_43_raw;
        $this->generalConditions['structural'] = $estimate->field_48_raw;
        $this->generalConditions['physical'] = $estimate->field_49_raw;
        $this->generalConditions['alterations'] = $estimate->field_50_raw;

        $this->generalConditionsChecklist['debris'] = $estimate->field_115_raw;
        $this->generalConditionsChecklist['drainage'] = $estimate->field_116_raw;
        $this->generalConditionsChecklist['structural'] = $estimate->field_117_raw;
        $this->generalConditionsChecklist['physical'] = $estimate->field_118_raw;
        $this->generalConditionsChecklist['alterations'] = $estimate->field_119_raw;

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

        $this->surfaceConditionsChecklist['missingMaterial'] = $estimate->field_120_raw;
        $this->surfaceConditionsChecklist['buckledMaterial'] = $estimate->field_121_raw;
        $this->surfaceConditionsChecklist['deformedEdges'] = $estimate->field_122_raw;
        $this->surfaceConditionsChecklist['surfaceStaining'] = $estimate->field_123_raw;
        $this->surfaceConditionsChecklist['granularLoss'] = $estimate->field_124_raw;
        $this->surfaceConditionsChecklist['crackedTile'] = $estimate->field_125_raw;
        $this->surfaceConditionsChecklist['exposedUnderlayment'] = $estimate->field_126_raw;
        $this->surfaceConditionsChecklist['missingMortar'] = $estimate->field_127_raw;
        $this->surfaceConditionsChecklist['denting'] = $estimate->field_128_raw;
        $this->surfaceConditionsChecklist['blistering'] = $estimate->field_129_raw;
        $this->surfaceConditionsChecklist['ponding'] = $estimate->field_130_raw;
        $this->surfaceConditionsChecklist['corrosion'] = $estimate->field_131_raw;
        $this->surfaceConditionsChecklist['missingFasteners'] = $estimate->field_132_raw;
        $this->surfaceConditionsChecklist['missingCaulking'] = $estimate->field_133_raw;
        $this->surfaceConditionsChecklist['deteriorationDecking'] = $estimate->field_134_raw;

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

        $this->roofingFeaturesChecklist['fascia'] = $estimate->field_135_raw;
        $this->roofingFeaturesChecklist['soffit'] = $estimate->field_136_raw;
        $this->roofingFeaturesChecklist['flashing'] = $estimate->field_137_raw;
        $this->roofingFeaturesChecklist['gutters'] = $estimate->field_138_raw;
        $this->roofingFeaturesChecklist['chimney'] = $estimate->field_139_raw;
        $this->roofingFeaturesChecklist['skylights'] = $estimate->field_140_raw;
        $this->roofingFeaturesChecklist['vents'] = $estimate->field_141_raw;
        $this->roofingFeaturesChecklist['jacks'] = $estimate->field_142_raw;
        $this->roofingFeaturesChecklist['satellite'] = $estimate->field_143_raw;
        $this->roofingFeaturesChecklist['solarPanels'] = $estimate->field_144_raw;
        $this->roofingFeaturesChecklist['valley'] = $estimate->field_145_raw;
        $this->roofingFeaturesChecklist['crickets'] = $estimate->field_146_raw;

        $this->roofingFeatureNotes = $estimate->field_76_raw;

        
        $this->exteriorSurfaces['finish'] = $estimate->field_80_raw;
        $this->exteriorSurfaces['surface'] = $estimate->field_81_raw;

        $this->exteriorSurfacesChecklist['finish'] = $estimate->field_147_raw;
        $this->exteriorSurfacesChecklist['surface'] = $estimate->field_148_raw;

        $this->exteriorSurfaceNotes = $estimate->field_82_raw;

        
        $this->interiorConditions['cracks'] = $estimate->field_83_raw;
        $this->interiorConditions['leaks'] = $estimate->field_84_raw;
        $this->interiorConditions['interiorStaining'] = $estimate->field_85_raw;

        $this->interiorConditionsChecklist['cracks'] = $estimate->field_149_raw;
        $this->interiorConditionsChecklist['leaks'] = $estimate->field_150_raw;
        $this->interiorConditionsChecklist['interiorStaining'] = $estimate->field_151_raw;

        $this->interiorConditionNotes = $estimate->field_86_raw;
       
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

        
        $this->internalId = $estimate->field_110_raw;
        $this->validationCode = $estimate->field_109_raw;

        // Get Contacts (field_93)
        if(isset($estimate->field_93_raw)){
            foreach($estimate->field_93_raw as $contact) {
                $this->contacts[] = new Contact($contact->id);
            }
        }

        // Get Images (field_40)
        if(isset($estimate->field_40_raw)){
            foreach($estimate->field_40_raw as $image) {
                $this->images[] = new Image($image->id);
            }
        }
    }
}
