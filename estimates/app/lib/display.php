<?php

class Display {
    
    public static function estimate(EstimateView $estimate) {
        
//        echo "<pre>";
//        var_dump($estimate);
//        exit;
        
        //<span class="desktoponly">Estimate for </span>' . $estimate->jobName . '
        $html = '<!DOCTYPE html>';

        $html .= self::buildHead($estimate->jobName);
        
        $html .='
    <body>
        <script type="text/javascript" src="js/ar-estimate-approve.js"></script>
        <div id="debug"></div>
        <div id="instructions" class="screen">
            <div id="printForm">
                <div class="info">
                    <div><span class="label">Printing instructions:  Aladdin Estimates are set up to print on 8.5" x 11" paper.</span></div>
                </div>
                <div class="buttons"><img src="images/print_button.png" onClick="window.print()" id="print_button" /></div>
            </div>
        ';
        
        if (($estimate->status == 'Active') || ($estimate->status == 'Pending')) {
            $html .= '
            <div class="clear"></div>
            <div id="approveForm">
                <input type="hidden" value="' . $estimate->id . '" name="estId" />
                <div class="info">
                    <div><span class="label">Approver Name:</span><span class="data"><input type="text" name="approvedName" /></span></div>
                    <div><span class="label">I authorize this estimate:</span><span class="data"><input type="checkbox" name="approvedCheck" /></span></div>
                </div>
                <div class="buttons">
                    <div><img src="images/approve_button.png" onClick="makeApproval()" id="approve_button" /></div>
                    <div id="approve_status"></div>
                </div>
            </div>';
        }
 
        $html .= '
            <div class="clear"></div>
        
        </div>
        <div class="print"></div>
        <div id="page">';

        $html .= self::builderHeader('Estimate');


        // Job and Roof Information
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
                        <!--<div class="cost"><div class="label important">Cost</div><div class="data important">$' . $estimate->estimatedCost . '</div></div>-->
                    </div>
                </div>
            </section>';

        
                //Contacts
        $html .= '
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
                        <div><div class="label">Phone</div><div class="data">' .$contact->phone . '</div></div>';
                
                if (isset($contact->phoneAlt) && $contact->phoneAlt != NULL && $contact->phoneAlt !="" ) { $html .= '<div><div class="label">Phone Alt</div><div class="data">' .$contact->phoneAlt . '</div></div>'; }
                        
                $html .= '<div><div class="label">Address</div><div class="data">'; 
                        
                $html .= $contact->street1; 
                if (isset($contact->street2) && $contact->street2 != NULL && $contact->street2 !="" ) { $html .= '<br />' . $contact->street2; }
                $html .= '<br />' . $contact->city . ', ' . $contact->state . '  ' . $contact->zip;
                        
                $html .= '</div></div>';

                if (isset($contact->phoneAlt) && $contact->phoneAlt != NULL && $contact->phoneAlt !="" ) { $html .= '<div><div class="label">Additional Info</div><div class="data">' .$contact->notes . '</div></div>'; }

                $html .= '</div>';
            }
            
            $html .= '</div>';
            
        } else {
            $html .= '<div class="content">No contacts for this job</div>';
        }
        
        $html .= '
            </section>';
        
        //Project Information 
        $html .= '
            <section id="job-details"> 
                <div class="bgfilled fh40">
                    <img  class="fh40" src="' . BASE_URL . 'images/bgcolor3.png">
                    <div class="title">Project Information</div>
                </div>
                <div class="content">
                    <div class="notes">
                        <div class="label">Overiew Notes</div>
                        <div class="data">';

        if (!empty($estimate->overviewNote)) {
            $html .= $estimate->overviewNote;
        } else {
            $html .= 'No Overview notes for this job.';
        }
        
        $html .= '</div></div>';
        
//       $html .= self::buildImageDisplay($estimate->images, $estimate->generalImageLabel);
        $html .= self::buildImageDisplay($estimate, 'overview');

        if ($estimate->showRepair) {
            $html .= '

                    <div class="estimate">
                        <div class="cost"><div class="label important">Repair Cost</div><div class="data important">$' . $estimate->repairCost . '</div></div>
                        <div class="data">' . $estimate->repairNote . '</div>
                    </div>';
        }
    
        if ($estimate->showReroof) {
           $html .= '
                    <div class="estimate">
                        <div class="cost"><div class="label important">Re-Roof Cost</div><div class="data important">$' . $estimate->reroofCost . '</div></div>
                        <div class="data">' . $estimate->reroofNote . '</div>
                    </div>';
        }
 
        $html .= '
                </div>
            </section>';
        
        
        
        
        
        foreach($estimate->sections as $sectionName=>$sectionInfo) {
            
//            $section = array( 
//                'name' => $estimate->{$sectionName},
//                'labels' => $estimate->{$sectionName . 'Label'},
//                'checklist' => $estimate->{$sectionName . 'Checklist'},
//                'deficiencies' => $estimate->{$sectionName . 'Deficiency'}
//            );
            
            if ($skip_first) {
                if ($sectionInfo[2]) {
                    $html .= '
                        
            <section id="' . $sectionName . '">
                <div class="bgfilled fh40">
                    <img  class="fh40" src="images/bgcolor3.png">
                    <div class="title">' . $sectionInfo[1] . '</div>
                </div>
                <div class="content">
                ';

                    if (!empty($sectionInfo[3])) {
                        $html .= '
                    <div class="notes">
                        <div class="label">Estimator Notes</div>
                        <div class="data">' . $sectionInfo[3] . '</div>
                    </div>';
                    }

                $html .= self::buildImageDisplay($estimate, $sectionName);

                    $html .= '
                    <div class="inspection">
                        <div class="label">Inspection Notes</div>
                        <div class="data">' . $sectionInfo[4] . '</div>
                    </div>';
                        
                
                    
                    $html .= '
                </div>
            </section>';            
                    
                }



                
//
//                 $inner_html_5 = self::buildImageDisplay($images, $section['labels']);
//                 $inner_html_6 = '
//                         </div>
//                     </section>';
                
                
                
                
                
                
            }
            $skip_first = true;
            
            
//            if($val = self::buildSection($section, $estimate->images)) { $html .= $val; }
        }
        
        
        
        $html .= '
            
        <section id="legal-notice">
        <div class="bgunfilled">
            <h3>Legal Disclaimer:</h3>
        </div>
        <div class="content">
            <p>This inspection report details the condition of the roof and related structure at the time of the inspection. Roofing conditions can change at any time due to weather and other circumstances. The estimated repair costs are contingent upon the roof conditions not changing since the time of the inspection. Therefore the estimate is valid for 60 days from the date of the inspection, provided conditions of the roof and related satructures have not changed since the inspection. If upon initiation of your repair we determine that conditions have changed since the inspection, we will document these changes, notify you of the changes, and request a new approval.</p>            
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
            <h2>Send estimate reports to the following people:</h2>
            <form action="' . BASE_URL . $estimate->internalId . '/' . $estimate->validationCode . '" method="POST" id="estimateForm">
        ';

        $count = 0;
        foreach($emails as $email) {
            $html .= '<div class="emailList"><div class="emailname">' . $email['name'] . '<br><span class="smallemail">' . $email['email']  . '</span></div><div class="type">' . $email['type'] . '</div><div class="check"><input type="checkbox" name="emailList[' . $count . ']" value="true" checked></div></div>';
            
            $count++;
        }
                
        $html .= '
            <div class="emailList"><div class="button"><button type="submit" form="estimateForm" value="Send Email Reports">Email Reports</button></div></div>
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

        $html .= self::buildHead($estimateArray['jobName']);
        
        $html .='
    <body>
        <div id="page">';

        $html .= self::builderHeader('Email Estimate');

        
        $html .= '
            <section><div class="content">
            <h2>Emails have been sent to the following people:</h2>

            <div class="emailssent">
            
        ';

        
            if($results) {
            foreach($results as $result)
            {
                $html .= '<div>' . $result['name'] . " (" . $result['type'] . ") at " . $result['email'] . "</div>"; 
            }
        } else {
            $html .= "<div>No emails sent since no emails were selected.</div>";
        }

        
        
        $html .= '
            
            <div class="viewnow">
                <div>View the estimate for:</div>
                <div><a href="'. BASE_URL . $estimateArray['id'] . '">' . $estimateArray['jobName'] . '</a></div>
                <div><a href="'. BASE_URL . $estimateArray['id'] . '">' . $estimateArray['street1'] . '</a></div>';

        if ($estimateArray['street2'] != "") {
                $html .= '<div><a href="'. BASE_URL . $estimateArray['id'] . '">' . $estimateArray['street2'] . '</a></div>';
        }
        
        $html .= '
                <div><a href="'. BASE_URL . $estimateArray['id'] . '">' . $estimateArray['city'] . ', ' . $estimateArray['state'] . '  ' . $estimateArray['zip'] . '</a></div>
            </div> 

            </div></div></section>';

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
            'code' => $estimate->validationCode,
            'date' => $estimate->dateEstimated['date']
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


    private static function buildImageDisplay($estimate,$imgCat) {

        $images = $estimate->images;
        $sections = $estimate->sections;
        
//        echo "<pre>";
//        var_dump($sections);
//        exit;
        
        $inner_html .= '<div class="references">';
        $count = 0;
        foreach($images as $image) {
//                if(array_key_exists($image->classCode, $labels)) {
            if ($image->catId == $sections[$imgCat][0]) {
                //For odds and evens, works great
                if(!($count&1) && $count > 0) {
                    $inner_html .= '</div><div class="references">';
                }
                $count++;
                $inner_html .= '
                        <div class="ref-image">
                            <img src="' . $image->imageUrl_1280 . '" />
                            <div class="img-desc">' . $image->description . '</div>
                        </div>
                ';      
            }    
        }
        $inner_html .= '</div>';
        
        if ($count > 0) {
            return $inner_html;
        }
        
        return false;
        
   }






    
//    private static function buildImageDisplay($images,$labels) {
//        
//        $display_test = false;
//        foreach($images as $image) { 
//            foreach($labels as $id=>$label) {
////                if($image->classCode == $id ){
//                if($image->classification == $label){
//                    $display_test=true;
//                    break;
//                }
//            }
//            if ($display_test) { break; }
//        }
//
//        
//        if($display_test) {
//            
//            $inner_html .= '<div class="references">';
//            $count = 0;
//            foreach($images as $image) {
////                if(array_key_exists($image->classCode, $labels)) {
//                if(in_array($image->classification, $labels)) {
//                    //For odds and evens, works great
//                    if(!($count&1) && $count > 0) {
//                        $inner_html .= '</div><div class="references">';
//                    }
//                    $count++;
//                    $inner_html .= '
//                            <div class="ref-image">
//                                <img src="' . $image->imageUrl_1280 . '" />
//                                <div class="img-desc">' . $image->description . '</div>';
//                    
//                    if($image->classification != 'General') {
//                        $inner_html .= '<div class="img-class">' . $image->classification . '</div>';
//                    }
//                    
//                    $inner_html .= '
//                                
//                            </div>
//                    ';      
//                }    
//            }
//            $inner_html .= '</div>';
//            return $inner_html;
//        }
//        return;
//   }
    
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

//   public static function buildSection($section, $images) {
//       
//       $inner_html_1 = '
//            <section id="' . $section['name']['id'] . '">
//                <div class="bgfilled fh40">
//                    <img  class="fh40" src="images/bgcolor3.png">
//                    <div class="title">' . $section['name']['label'] . 's</div>
//                </div>
//                <div class="content">
//                    <div class="inspection-list">';
//        
//        $inner_html_2 = self::buildChecklist($section['labels'], $section['checklist'], $section['deficiencies']);
//        $inner_html_3 = '</div>';
//        $inner_html_4 = '
//                    <div class="notes">
//                        <div class="label">' . $section['name']['label'] . ' Notes</div>
//                        <div class="data">';
//        
//        if (!empty($section['name']['note'])) {
//            $inner_html_4 .= $section['name']['note'];
//        } else {
//            $inner_html_4 .= 'No ' . $section['name']['label'] . ' notes for this job.';
//        }
//        $inner_html_4 .= '
//                        </div>
//                    </div>';
//
//        $inner_html_5 = self::buildImageDisplay($images, $section['labels']);
//        $inner_html_6 = '
//                </div>
//            </section>';
//        
//        if(empty($inner_html_2) && empty($inner_html_5) && empty($section['name']['note'])) { return; }
//        return $inner_html_1 . $inner_html_2 . $inner_html_3 . $inner_html_4 . $inner_html_5 . $inner_html_6;
//   }
   
   
   
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
                <script tpye="text/javascript" src="js/jquery-3.2.1.min.js"></script>
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
                        <div class="copyright">&copy; ' . date("Y") . ' Aladdin Roofing.  All rights reserved.</div>
                    </div>
                </div>
            </footer>';
        return $inner_html;

   }
}