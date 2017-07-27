<?php

class Estimate {
    
    public $sections = array('generalCondition','surfaceCondition','roofingFeature','exteriorSurface','interiorCondition');
    
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
    
    public $generalCondition;
    public $generalConditionChecklist;
    public $generalConditionDeficiency;
    public $generalConditionLabel;
    public $generalConditionNotes;
    
    public $surfaceCondition;
    public $surfaceConditionChecklist;
    public $surfaceConditionDeficiency;
    public $surfaceConditionLabel;
    public $surfaceConditionNotes;
    
    public $roofingFeature;
    public $roofingFeatureChecklist;
    public $roofingFeatureDeficiency;
    public $roofingFeatureLabel;
    public $roofingFeatureNotes;
    
    public $exteriorSurface;
    public $exteriorSurfaceChecklist;
    public $exteriorSurfaceDeficiency;
    public $exteriorSurfaceLabel;
    public $exteriorSurfaceNotes;
    
    public $interiorCondition;
    public $interiorConditionChecklist;
    public $interiorDeficiency;
    public $interiorConditionLabel;
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
        $this->estimatedCost = $estimate->field_87_raw;
        $this->estimator = $estimate->field_41_raw[0]->identifier;
        $this->estimatorId = $estimate->field_41_raw[0]->id;
        $this->estimatorEmail = Knack::getObject(T_ESTIMATORS, $this->estimatorId)->field_28_raw->email;

        $this->generalNotes = $estimate->field_88_raw;
        $this->generalImageLabel['general'] = 'General';

        
        $this->generalConditionDeficiency['debris'] = $estimate->field_42_raw;
        $this->generalConditionDeficiency['drainage'] = $estimate->field_43_raw;
        $this->generalConditionDeficiency['structural'] = $estimate->field_48_raw;
        $this->generalConditionDeficiency['physical'] = $estimate->field_49_raw;
        $this->generalConditionDeficiency['alterations'] = $estimate->field_50_raw;

        $this->generalConditionChecklist['debris'] = $estimate->field_115_raw;
        $this->generalConditionChecklist['drainage'] = $estimate->field_116_raw;
        $this->generalConditionChecklist['structural'] = $estimate->field_117_raw;
        $this->generalConditionChecklist['physical'] = $estimate->field_118_raw;
        $this->generalConditionChecklist['alterations'] = $estimate->field_119_raw;

        $this->generalConditionLabel['debris'] = 'Debris';
        $this->generalConditionLabel['drainage'] = 'Drainage';
        $this->generalConditionLabel['structural'] = 'Structural'; 
        $this->generalConditionLabel['physical'] = 'Physical Damage';
        $this->generalConditionLabel['alterations'] = 'Alterations';

        $this->generalCondition['label']  = 'General Condition';
        $this->generalCondition['note']  = $estimate->field_51_raw;
        $this->generalCondition['id'] = 'general-conditions';

       
        $this->surfaceConditionDeficiency['missingMaterial'] = $estimate->field_44_raw;
        $this->surfaceConditionDeficiency['buckledMaterial'] = $estimate->field_45_raw;
        $this->surfaceConditionDeficiency['deformedEdges'] = $estimate->field_52_raw;
        $this->surfaceConditionDeficiency['surfaceStaining'] = $estimate->field_53_raw;
        $this->surfaceConditionDeficiency['granularLoss'] = $estimate->field_54_raw;
        $this->surfaceConditionDeficiency['crackedTile'] = $estimate->field_55_raw;
        $this->surfaceConditionDeficiency['exposedUnderlayment'] = $estimate->field_56_raw;
        $this->surfaceConditionDeficiency['missingMortar'] = $estimate->field_57_raw;
        $this->surfaceConditionDeficiency['denting'] = $estimate->field_58_raw;
        $this->surfaceConditionDeficiency['blistering'] = $estimate->field_59_raw;
        $this->surfaceConditionDeficiency['ponding'] = $estimate->field_60_raw;
        $this->surfaceConditionDeficiency['corrosion'] = $estimate->field_61_raw;
        $this->surfaceConditionDeficiency['missingFasteners'] = $estimate->field_62_raw;
        $this->surfaceConditionDeficiency['missingCaulking'] = $estimate->field_65_raw;
        $this->surfaceConditionDeficiency['deteriorationDecking'] = $estimate->field_63_raw;
        
        $this->surfaceConditionChecklist['missingMaterial'] = $estimate->field_120_raw;
        $this->surfaceConditionChecklist['buckledMaterial'] = $estimate->field_121_raw;
        $this->surfaceConditionChecklist['deformedEdges'] = $estimate->field_122_raw;
        $this->surfaceConditionChecklist['surfaceStaining'] = $estimate->field_123_raw;
        $this->surfaceConditionChecklist['granularLoss'] = $estimate->field_124_raw;
        $this->surfaceConditionChecklist['crackedTile'] = $estimate->field_125_raw;
        $this->surfaceConditionChecklist['exposedUnderlayment'] = $estimate->field_126_raw;
        $this->surfaceConditionChecklist['missingMortar'] = $estimate->field_127_raw;
        $this->surfaceConditionChecklist['denting'] = $estimate->field_128_raw;
        $this->surfaceConditionChecklist['blistering'] = $estimate->field_129_raw;
        $this->surfaceConditionChecklist['ponding'] = $estimate->field_130_raw;
        $this->surfaceConditionChecklist['corrosion'] = $estimate->field_131_raw;
        $this->surfaceConditionChecklist['missingFasteners'] = $estimate->field_132_raw;
        $this->surfaceConditionChecklist['missingCaulking'] = $estimate->field_133_raw;
        $this->surfaceConditionChecklist['deteriorationDecking'] = $estimate->field_134_raw;
        
        $this->surfaceConditionLabel['missingMaterial'] = 'Missing Material';
        $this->surfaceConditionLabel['buckledMaterial'] = 'Buckled Material';
        $this->surfaceConditionLabel['deformedEdges'] = 'Deformed Edges';
        $this->surfaceConditionLabel['surfaceStaining'] = 'Staining';
        $this->surfaceConditionLabel['granularLoss'] = 'Granular Loss';
        $this->surfaceConditionLabel['crackedTile'] = 'Cracked Tile';
        $this->surfaceConditionLabel['exposedUnderlayment'] = 'Exposed Underlayment';
        $this->surfaceConditionLabel['missingMortar'] = 'Missing/Loss of Mortat';
        $this->surfaceConditionLabel['denting'] = 'Denting or Impact Marks/Dents';
        $this->surfaceConditionLabel['blistering'] = 'Blistering';
        $this->surfaceConditionLabel['ponding'] = 'Ponding';
        $this->surfaceConditionLabel['corrosion'] = 'Corrosion';
        $this->surfaceConditionLabel['missingFasteners'] = 'Missing/Exposed Fasteners';
        $this->surfaceConditionLabel['missingCaulking'] = 'Missing/Damaged Caulking';
        $this->surfaceConditionLabel['deteriorationDecking'] = 'Deterioration of Decking';

        $this->surfaceCondition['label']  = 'Surface Condition';
        $this->surfaceCondition['note']  = $estimate->field_64_raw;
        $this->surfaceCondition['id'] = 'surface-conditions';

        
        $this->roofingFeatureDeficiency['fascia'] = $estimate->field_46_raw;
        $this->roofingFeatureDeficiency['soffit'] = $estimate->field_47_raw;
        $this->roofingFeatureDeficiency['flashing'] = $estimate->field_66_raw;
        $this->roofingFeatureDeficiency['gutters'] = $estimate->field_67_raw;
        $this->roofingFeatureDeficiency['chimney'] = $estimate->field_68_raw;
        $this->roofingFeatureDeficiency['skylights'] = $estimate->field_69_raw;
        $this->roofingFeatureDeficiency['vents'] = $estimate->field_70_raw;
        $this->roofingFeatureDeficiency['jacks'] = $estimate->field_71_raw;
        $this->roofingFeatureDeficiency['satellite'] = $estimate->field_72_raw;
        $this->roofingFeatureDeficiency['solarPanels'] = $estimate->field_73_raw;
        $this->roofingFeatureDeficiency['valley'] = $estimate->field_74_raw;
        $this->roofingFeatureDeficiency['crickets'] = $estimate->field_75_raw;

        $this->roofingFeatureChecklist['fascia'] = $estimate->field_135_raw;
        $this->roofingFeatureChecklist['soffit'] = $estimate->field_136_raw;
        $this->roofingFeatureChecklist['flashing'] = $estimate->field_137_raw;
        $this->roofingFeatureChecklist['gutters'] = $estimate->field_138_raw;
        $this->roofingFeatureChecklist['chimney'] = $estimate->field_139_raw;
        $this->roofingFeatureChecklist['skylights'] = $estimate->field_140_raw;
        $this->roofingFeatureChecklist['vents'] = $estimate->field_141_raw;
        $this->roofingFeatureChecklist['jacks'] = $estimate->field_142_raw;
        $this->roofingFeatureChecklist['satellite'] = $estimate->field_143_raw;
        $this->roofingFeatureChecklist['solarPanels'] = $estimate->field_144_raw;
        $this->roofingFeatureChecklist['valley'] = $estimate->field_145_raw;
        $this->roofingFeatureChecklist['crickets'] = $estimate->field_146_raw;

        $this->roofingFeatureLabel['fascia'] = 'Fascia';
        $this->roofingFeatureLabel['soffit'] = 'Soffit';
        $this->roofingFeatureLabel['flashing'] = 'Flashing';
        $this->roofingFeatureLabel['gutters'] = 'Gutters';
        $this->roofingFeatureLabel['chimney'] = 'Chimney';
        $this->roofingFeatureLabel['skylights'] = 'Skylights';
        $this->roofingFeatureLabel['vents'] = 'Vents';
        $this->roofingFeatureLabel['jacks'] = 'Jacks';
        $this->roofingFeatureLabel['satellite'] = 'Satellite TV';
        $this->roofingFeatureLabel['solarPanels'] = 'Solar Panels';
        $this->roofingFeatureLabel['valley'] = 'Valley';
        $this->roofingFeatureLabel['crickets'] = 'Crickets';

        $this->roofingFeature['label']  = 'Roofing Feature';
        $this->roofingFeature['note']  = $estimate->field_76_raw;
        $this->roofingFeature['id'] = 'roofing-features';

        
        $this->exteriorSurfaceDeficiency['finish'] = $estimate->field_80_raw;
        $this->exteriorSurfaceDeficiency['surface'] = $estimate->field_81_raw;

        $this->exteriorSurfaceChecklist['finish'] = $estimate->field_147_raw;
        $this->exteriorSurfaceChecklist['surface'] = $estimate->field_148_raw;

        $this->exteriorSurfaceLabel['finish'] = 'Finsish';
        $this->exteriorSurfaceLabel['surface'] = 'Surface';

        $this->exteriorSurface['label']  = 'Exterior Surface';
        $this->exteriorSurface['note']  = $estimate->field_82_raw;
        $this->exteriorSurface['id'] = 'exterior-surfaces';

        
        $this->interiorConditionDeficiency['cracks'] = $estimate->field_83_raw;
        $this->interiorConditionDeficiency['leaks'] = $estimate->field_84_raw;
        $this->interiorConditionDeficiency['interiorStaining'] = $estimate->field_85_raw;

        $this->interiorConditionChecklist['cracks'] = $estimate->field_149_raw;
        $this->interiorConditionChecklist['leaks'] = $estimate->field_150_raw;
        $this->interiorConditionChecklist['interiorStaining'] = $estimate->field_151_raw;

        $this->interiorConditionLabel['cracks'] = 'Cracks';
        $this->interiorConditionLabel['leaks'] = 'Leaks';
        $this->interiorConditionLabel['interiorStaining'] = 'Staining';

        $this->interiorCondition['label']  = 'Interior Condition';
        $this->interiorCondition['note']  = $estimate->field_86_raw;
        $this->interiorCondition['id'] = 'interior-conditions';
       
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
