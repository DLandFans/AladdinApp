<?php

class Display {
    
    public static function estimate(EstimateView $estimate) {
        
        //<span class="desktoponly">Estimate for </span>' . $estimate->jobName . '
        $html = '<!DOCTYPE html>';

        $html .= self::buildHead($estimate->jobName);
        
        $html .='
    <body>
        <div id="instructions" class="screen">
            Printing instructions:  Aladdin Estimates are set up to print on 8.5" x 11" paper.<br />
            <input type="button" onClick="window.print()" value="Print This Estimate" />
        </div>
        <div class="print"></div>
        <div id="page">';

        $html .= self::builderHeader('Estimate');
        
        $html .= '
            <section id="job-details"> 
                <div class="bgfilled fh40">
                    <img  class="fh40" src="' . BASE_URL . 'images/bgcolor3.png">
                    <div class="title">Job and Roof Information</div>
                </div>
                <div class="content">
                    <div class="job-information">
                        <div><div class="label">Job Name</div><div class="data">' . $estimate->jobName . '</div></div>
                        <div><div class="label">Address</div><div class="data">';

        $html .= $estimate->street1; 
        if (isset($estimate->street2) && $estimate->street2 != NULL && $estimate->street2 !="" ) { $html .= '<br />' . $estimate->street2; }
        $html .= '<br />' . $estimate->city . ', ' . $estimate->state . '  ' . $estimate->zip;
        
        $html .= '</div></div>

                        <div><div class="label">Estimator</div><div class="data">' . $estimate->estimator . '</div></div>
                        <div><div class="label">Estimate Date</div><div class="data">' . $estimate->dateEstimated['date'] . '</div></div>
                    </div>
                    <div class="roof-type">
                        <div><div class="label">Roof Type</div><div class="data">' . $estimate->roofType . '</div></div>
                        <div><div class="label">Roof Age</div><div class="data">' . $estimate->roofAge . ' Years</div></div>
                        <div><div class="label"># of Stories</div><div class="data">' . $estimate->stories . '</div></div>
                        <div class="cost"><div class="label important">Cost</div><div class="data important">$' . $estimate->estimatedCost . '</div></div>
                    </div>
                    <div class="notes">
                        <div class="label">General Notes</div>
                        <div class="data">';

        if (!empty($estimate->generalNotes)) {
            $html .= $estimate->generalNotes;
        } else {
            $html .= 'No General notes for this job.';
        }
        
        $html .= '</div></div>';
        
        $html .= self::buildImageDisplay($estimate->images, $estimate->generalImageLabel);
        
        $html .= '
                    
                </div>
            </section>

            <section id="contacts">
                <div class="bgfilled fh40">
                    <img  class="fh40" src="images/bgcolor3.png">
                    <div class="title">Contacts</div>
                </div> ';
        
        if (!empty($estimate->contacts)) {
            $html .= '<div class="content">';
            foreach($estimate->contacts as $contact) {
                $html .= '
                    <div class="contact">
                        <div><div class="label">Name</div><div class="data">' .$contact->fullName . '</div></div>
                        <div><div class="label">Roll</div><div class="data">' .$contact->type . '</div></div>
                        <div><div class="label">Email</div><div class="data">' .$contact->email . '</div></div>
                        <div><div class="label">Phone</div><div class="data">' .$contact->phone . '</div></div>
                        <div><div class="label">Address</div><div class="data">'; 
                        
                $html .= $contact->street1; 
                if (isset($contact->street2) && $contact->street2 != NULL && $contact->street2 !="" ) { $html .= '<br />' . $contact->street2; }
                $html .= '<br />' . $contact->city . ', ' . $contact->state . '  ' . $contact->zip;
                        
                $html .= '</div></div>
                    </div>
                ';
            }
            
            $html .= '</div>';
            
        } else {
            $html .= '<div class="content">No contacts for this job</div>';
        }
        
        $html .= '
            </section>';

        foreach($estimate->sections as $sectionName) {
            
            $section = array( 
                'name' => $estimate->{$sectionName},
                'labels' => $estimate->{$sectionName . 'Label'},
                'checklist' => $estimate->{$sectionName . 'Checklist'},
                'deficiencies' => $estimate->{$sectionName . 'Deficiency'}
            );
            
            if($val = self::buildSection($section, $estimate->images)) { $html .= $val; }
        }

        
        $html .= '
            
        <section id="legal-notice">
        <div class="bgunfilled">
            <h3>Legal Disclaimer:</h3>
        </div>
        <div class="content">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla urna ex, blandit eget finibus et, porta quis ligula. Nunc egestas sed mi eu sollicitudin. Integer rutrum lacinia ultricies. Etiam suscipit luctus massa, ac convallis diam aliquet ut. Donec sed neque accumsan, malesuada nisl pretium, ullamcorper nibh. Aenean finibus ultricies aliquam. Nulla vel arcu urna. Mauris vestibulum aliquam condimentum. Cras sagittis eros eget enim finibus, eget volutpat urna accumsan. Ut eu lobortis eros.</p>
            <p>In sit amet velit lacus. Phasellus luctus, mi sit amet vulputate hendrerit, sem arcu laoreet turpis, eu dapibus nulla diam non libero. Cras ac gravida ligula. Donec ac tristique urna. Donec nec feugiat tortor. Sed lacinia purus quam, non rutrum nibh sagittis eget. Etiam blandit, est id bibendum tincidunt, erat ante pharetra dolor, eget volutpat tellus odio nec sapien. In vitae turpis accumsan, vestibulum urna ac, aliquet lectus. Phasellus lobortis sapien vitae tellus fermentum, at blandit leo sollicitudin. Aenean posuere vehicula eros id tincidunt.</p>
        </div>
        </section>
                ';



        
        $html .= self::buildFooter();
        
        $html .= '
        </div>
    </body>
</html> 
';
        
        return $html;
    }

    public static function emailChoose(Estimate $estimate, $emails) {
        $_SESSION['emails'] = $emails;
        $_SESSION['estimateArray'] = self::buildEstimateArray($estimate); 
        
        $html = '<!DOCTYPE html>';

        $html .= self::buildHead($estimate->jobName);
        
        $html .='
    <body>
        <div id="page">';

        $html .= self::builderHeader('Email Estimate');

        
        
        $html .= '
            <section><div class="content">
            <h2>Send Emails</h2>

            <form action="' . BASE_URL . $estimate->internalId . '/' . $estimate->validationCode . '" method="POST" id="form1">
        ';

        $count = 0;
        foreach($emails as $email) {
            $html .= $email['name'] . ' ('. $email['type'] .') ' . ' <input type="checkbox" name="emailList[' . $count . ']" value="true" checked><br>';
            $count++;
        }
                
        $html .= '
            <input type="submit" form="form1" value="Submit">
            </form>
            </div></section>';

        $html .= self::buildFooter();
        
        $html .= '
        </div>
    </body>
</html> 
';
        
        
        
        return $html;
    }
    
    public static function emailSent($results, $estimateArray) {
        $html = '<!DOCTYPE html>';

        $html .= self::buildHead($estimate->jobName);
        
        $html .='
    <body>
        <div id="page">';

        $html .= self::builderHeader('Email Estimate');

        
        $html .= '
            <section><div class="content">

            <h2>Emails Sent</h2>
            To view the estimate now <a href="'. BASE_URL . $estimateArray['id'] . '">click here</a> 
                <br>
        ';

        
        if($results) {
            $html .= "<br>Emails sent to:<br>";
            foreach($results as $result)
            {
                $html .= $result['name'] . " (" . $result['type'] . ") at " . $result['email'] . "<br>"; 
            }
        } else {
            $html .= "No emails sent since no emails were selected.";
        }

        
        
        $html .= '</div></section>';

        $html .= self::buildFooter();
        
        $html .= '
        </div>
    </body>
</html> 
';
        return $html;
    }
    
    private static function buildEstimateArray(Estimate $estimate)
    {
        return array(
            'jobName' => $estimate->jobName,
            'street1' => $estimate->street1,
            'street2' => $estimate->street2,
            'city' => $estimate->city,
            'state' => $estimate->state,
            'zip' => $estimate->zip,
            'id' => $estimate->internalId,
            'code' => $estimate->validationCode
        );
    }

    private static function buildChecklist($labels,$checklist,$deficiency){
        
        unset($inner_html);
        foreach($labels as $id=>$label)
        {
            if($checklist[$id]){
                $inner_html .= '<div><div class="inspection-point">' . $label . '</div><div class="inspected"><img src="images/checkbox-checked.png" /></div><div class="deficiency"><img src="';
                if($deficiency[$id]) {
                    $inner_html .= 'images/checkbox-checked.png';
                } else {
                    $inner_html .= 'images/checkbox.png';
                }
                $inner_html .= '" /></div></div>';
            }
        }
        
        if($inner_html) { return '<div><div class="inspection-point labels">Inspection Point</div><div class="inspected labels">Checked For:</div><div class="deficiency labels">Deficiency:</div></div>' . $inner_html; }
        return;
    }
    
    private static function buildImageDisplay($images,$labels) {
        
        $display_test = false;
        foreach($images as $image) { 
            foreach($labels as $id=>$label) {
//                if($image->classCode == $id ){
                if($image->classification == $label){
                    $display_test=true;
                    break;
                }
            }
            if ($display_test) { break; }
        }

        
        if($display_test) {
            
            $inner_html .= '<div class="references">';
            $count = 0;
            foreach($images as $image) {
//                if(array_key_exists($image->classCode, $labels)) {
                if(in_array($image->classification, $labels)) {
                    //For odds and evens, works great
                    if(!($count&1) && $count > 0) {
                        $inner_html .= '</div><div class="references">';
                    }
                    $count++;
                    $inner_html .= '
                            <div class="ref-image">
                                <img src="' . $image->imageUrl_1280 . '" />
                                <div class="img-desc">' . $image->description . '</div>
                                <div class="img-class">' . $labels[$image->classCode] . '</div>
                            </div>
                    ';      
                }    
            }
            $inner_html .= '</div>';
            return $inner_html;
        }
        return;
   }
    
   public static function buildSection($section, $images) {
       
       $inner_html_1 = '
            <section id="' . $section['name']['id'] . '">
                <div class="bgfilled fh40">
                    <img  class="fh40" src="images/bgcolor3.png">
                    <div class="title">' . $section['name']['label'] . 's</div>
                </div>
                <div class="content">
                    <div class="inspection-list">';
        
        $inner_html_2 = self::buildChecklist($section['labels'], $section['checklist'], $section['deficiencies']);
        $inner_html_3 = '</div>';
        $inner_html_4 = '
                    <div class="notes">
                        <div class="label">' . $section['name']['label'] . ' Notes</div>
                        <div class="data">';
        
        if (!empty($section['name']['note'])) {
            $inner_html_4 .= $section['name']['note'];
        } else {
            $inner_html_4 .= 'No ' . $section['name']['label'] . ' notes for this job.';
        }
        $inner_html_4 .= '
                        </div>
                    </div>';

        $inner_html_5 = self::buildImageDisplay($images, $section['labels']);
        $inner_html_6 = '
                </div>
            </section>';
        
        if(empty($inner_html_2) && empty($inner_html_5) && empty($section['name']['note'])) { return; }
        return $inner_html_1 . $inner_html_2 . $inner_html_3 . $inner_html_4 . $inner_html_5 . $inner_html_6;
   }
 
   private static function buildHead($title) {
       
       $inner_html = '
       <html lang="en">
            <head>
                <title>Aladdin Roofing Estimate for ' . $title . '</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <meta name="description" content="Aladdin Roofing Estimate" />
                <meta name="robots" content="noindex, nofollow" />
                <link rel="stylesheet" type="text/css" href="' . BASE_URL . 'css/ar-style.css" />
                <link rel="stylesheet" type="text/css" media="print" href="' . BASE_URL . 'css/ar-style-print.css" />
                <link rel="stylesheet" type="text/css" media="screen" href="' . BASE_URL . 'css/ar-style-screen.css" />
            </head>

               ';
       return $inner_html;

   }
   
   private static function builderHeader($type) {
       $inner_html = '
            <header>
                <div class="bgfilled fh100">
                    <img class="fh100" src="' . BASE_URL . 'images/bgcolor1.png" />
                    <div class="title">
                        <img src="' . BASE_URL . 'images/AladdinRoofingLogo.jpg" />
                        <div>
                            <h1 class="desktoponly">' . $type . '</h1>
                        </div>
                    </div>
                </div>
            </header>';
       
       return $inner_html;
   }
 
   
   public static function buildFooter() {
        $inner_html .= '
            <footer>
                <div class="bgfilled fh100">
                    <img class="fh100" src="' . BASE_URL . 'images/bgcolor1.png" />
                    <div class="address">
                        <div class="name">Aladdin Roofing</div>
                        <div class="physical">15806 W. Prickly Pear Trail     Surprise, AZ  85387</div>
                        <div class="phone">(602) 296-7354</div>
                        <div class="ROC">AZ ROC# 195596</div>
                        <div class="copyright">&copy; 2017 Aladdin Roofing.  All rights reserved.</div>
                    </div>
                </div>
            </footer>';
        
        return $inner_html;

   }
}