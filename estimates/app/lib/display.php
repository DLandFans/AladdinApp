<?php

class Display {
    
    public static function estimate(Estimate $estimate) {
        $html = '
        
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Aladdin Roofing Estimate for ' . $estimate->jobName . '</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Aladdin Roofing Estimate" />
        <meta name="robots" content="noindex, nofollow" />
        <link rel="stylesheet" type="text/css" href="' . BASE_URL . 'css/ar-style.css" />
        <link rel="stylesheet" type="text/css" media="print" href="' . BASE_URL . 'css/ar-style-print.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="' . BASE_URL . 'css/ar-style-screen.css" />
    </head>
    <body>
        <div id="instructions" class="screen">Printing instructions:  Aladdin Estimates are set up to print on 8.5" x 11" paper.</div>
        <div class="print"></div>
        <div id="page">

            <header>
                <div class="bgfilled fh100">
                    <img class="fh100" src="' . BASE_URL . 'images/bgcolor1.png" />
                    <div class="title">
                        <img src="' . BASE_URL . 'images/AladdinRoofingLogo.jpg" height=100px />
                        <div>
                            <h1>Estimate for ' . $estimate->jobName . '</h1>
                        </div>
                    </div>
                </div>
            </header>

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
            <footer>
                <div class="bgfilled fh100">
                    <img class="fh100" src="images/bgcolor1.png" />
                    <div class="address">
                        <div class="name">Aladdin Roofing</div>
                        <div class="physical">15806 W. Prickly Pear Trail     Surprise, AZ  85387</div>
                        <div class="phone">(602) 296-7354</div>
                        <div class="ROC">AZ ROC# 195596</div>
                        <div class="copyright">&copy; 2017 Aladdin Roofing.  All rights reserved.</div>
                    </div>
                </div>
            </footer> 
        </div>
    </body>
</html> 
';
        
        return $html;
    }

    public static function emailChoose(Estimate $estimate, $emails) {
        $_SESSION['emails'] = $emails;
        $_SESSION['estimateArray'] = self::buildEstimateArray($estimate); 
        $html = '
            <!doctype html>

            <html lang="en">
            <head>
              <meta charset="utf-8">

              <title>Aladdin Roofing Estimate - ' . $estimate->jobName . '</title>
              <meta name="description" content="Aladdin Estimating App">
              <meta name="author" content="Todd Tamcsin Photography">
              <meta name="robots" content="noindex, nofollow" />
              <!--<link rel="stylesheet" href="css/styles.css?v=1.0">-->

              <!--[if lt IE 9]>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
              <![endif]-->

            </head>
            <body>
            <h1>' . $estimate->jobName . '</h1>
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
            <form>

            </body>
            </html>
        
        ';
        return $html;
    }
    
    public static function emailSent($results, $estimateArray) {
        $html = '
            <!doctype html>

            <html lang="en">
            <head>
              <meta charset="utf-8">

              <title>Aladdin Roofing Estimate - ' . $estimateArray['jobname'] . '</title>
              <meta name="description" content="Aladdin Estimating App">
              <meta name="author" content="Todd Tamcsin Photography">
              <meta name="robots" content="noindex, nofollow" />

              <!--<link rel="stylesheet" href="css/styles.css?v=1.0">-->

              <!--[if lt IE 9]>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
              <![endif]-->

            </head>
            <body>
            <h1>Job - ' . $estimateArray['jobName'] . '</h1>
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

        
        
        $html .= '</body>
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
        
        if($inner_html) { return '<div><div class="inspection-point labels">Inspection Point</div><div class="inspected labels">Inspected</div><div class="deficiency labels">Deficiency</div></div>' . $inner_html; }
        return;
    }
    
    private static function buildImageDisplay($images,$labels) {
        
        $display_test = false;
        foreach($images as $image) { 
            foreach($labels as $id=>$label) {
                if($image->classCode == $id ){
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
                if(array_key_exists($image->classCode, $labels)) {
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
 
}