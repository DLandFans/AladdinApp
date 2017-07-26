<?php

class Display {
    
    public static function estimate(Estimate $estimate) {
        $html = '
        


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Aladdin Roofing Estimate for ' . $estimate->jobName . '</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Aladdin Roofing Estimate">
        <link rel="stylesheet" type="text/css" href="' . BASE_URL . 'css/ar-style.css">
        <link rel="stylesheet" type="text/css" media="print" href="' . BASE_URL . 'css/ar-style-print.css">
        <link rel="stylesheet" type="text/css" media="screen" href="' . BASE_URL . 'css/ar-style-screen.css">
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
        if (isset($estimate->street2) && $estimate->street2 != NULL and $estimate->street2 !="" ) $html .= '<br />' . $estimate->street2;
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

        if (isset($estimate->overallNote) && $estimate->overallNote != NULL and $estimate->overallNote != "" ) 
            $html .= $estimate->overallNote;
        else
            $html .= 'No general notes for this job.';
        
        $html .= '</div>';

        $display_test = false;
        foreach($estimate->images as $image) { if($image->classCode == 'general') $display_test = true; }

        if($display_test) {
            $html .= '<div class="references">';
            $count = 0;
            foreach($estimate->images as $image) {
                if($image->classCode == 'general') {
                    //For odds and evens, works great
                    if(!($count&1) && $count > 0) {
                        $html .= '</div><div class="references">';
                    }
                    $count++;
                    $html .= '
                            <div class="ref-image">
                                <img src="' . $image->imageUrl_1280 . '" />
                                <div class="img-desc">' . $image->description . '</div>
                                <div class="img-class">' . $image->classification . '</div>
                            </div>
                    ';      
                }    
            }
            $html .= '</div>';
        }
        
        $html .= '
                    </div>
                </div>
            </section>

<h1>FAKED DATA BELOW THIS POINT</h1>

            <section id="contacts">
                <div class="bgfilled fh40">
                    <img  class="fh40" src="images/bgcolor3.png">
                    <div class="title">Contacts</div>
                </div>
                <div class="content">
                    <div class="contact">
                        <div><div class="label">Name</div><div class="data">Persons Name</div></div>
                        <div><div class="label">Roll</div><div class="data">Owner</div></div>
                        <div><div class="label">Email</div><div class="data">myname@anydomain.com</div></div>
                        <div><div class="label">Phone</div><div class="data">(123) 456-7890</div></div>
                        <div><div class="label">Address</div><div class="data">1234 E. Any Street Name St<br>34647 N Another Named Ln<br>Phoenix, AZ  85000-1234</div></div>
                    </div>
                    <div class="contact">
                        <div><div class="label">Name</div><div class="data">Persons Name</div></div>
                        <div><div class="label">Roll</div><div class="data">Owner</div></div>
                        <div><div class="label">Email</div><div class="data">myname@anydomain.com</div></div>
                        <div><div class="label">Phone</div><div class="data">(123) 456-7890</div></div>
                        <div><div class="label">Address</div><div class="data">1234 E. Any Street Name St<br>34647 N Another Named Ln<br>Phoenix, AZ  85000-1234</div></div>
                    </div>
                    <div class="contact">
                        <div><div class="label">Name</div><div class="data">Persons Name</div></div>
                        <div><div class="label">Roll</div><div class="data">Owner</div></div>
                        <div><div class="label">Email</div><div class="data">myname@anydomain.com</div></div>
                        <div><div class="label">Phone</div><div class="data">(123) 456-7890</div></div>
                        <div><div class="label">Address</div><div class="data">1234 E. Any Street Name St<br>34647 N Another Named Ln<br>Phoenix, AZ  85000-1234</div></div>
                    </div>
                </div>
            </section>
            <section id="general-conditions">
                <div class="bgfilled fh40">
                    <img  class="fh40" src="images/bgcolor3.png">
                    <div class="title">General Conditions</div>
                </div>
                <div class="content">

                    
                    <div class="inspection-list">
                        <div><div class="inspection-point labels">Inspection Point</div><div class="inspected labels">Inspected</div><div class="deficiency labels">Deficiency</div></div>
                        <div><div class="inspection-point">Debris</div><div class="inspected"><img src="images/checkbox-checked.png" /></div><div class="deficiency"><img src="images/checkbox.png" /></div></div>
                        <div><div class="inspection-point">Drainage</div><div class="inspected"><img src="images/checkbox-checked.png" /></div><div class="deficiency"><img src="images/checkbox-checked.png" /></div></div>
                        <div><div class="inspection-point">Structural</div><div class="inspected"><img src="images/checkbox-checked.png" /></div><div class="deficiency"><img src="images/checkbox.png" /></div></div>
                        <div><div class="inspection-point">Physical</div><div class="inspected"><img src="images/checkbox-checked.png" /></div><div class="deficiency"><img src="images/checkbox-checked.png" /></div></div>
                        <div><div class="inspection-point">Alterations</div><div class="inspected"><img src="images/checkbox-checked.png" /></div><div class="deficiency"><img src="images/checkbox.png" /></div></div>
                    </div>
                    <div class="notes">
                        <div class="label">General Notes</div>
                        <div class="data">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt laoreet vulputate. Vivamus orci nisi, dapibus quis tellus sed, commodo euismod ante. Duis tincidunt nulla ut massa feugiat, non interdum libero sollicitudin. Cras felis felis, euismod eu porttitor sit amet, hendrerit ut odio. Donec nec tellus non massa facilisis molestie ut ut dolor. Ut dictum lorem ut justo condimentum facilisis. Ut commodo ex sed purus posuere eleifend. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum tempor accumsan mattis. Praesent eu bibendum turpis, eget maximus lorem.
                            Proin dapibus id ante vitae elementum. Aliquam aliquet at metus eu rutrum. Quisque finibus orci eu nunc dictum sagittis sit amet a eros. In lacus mi, consequat et ante in, commodo lacinia ante. In ultricies euismod commodo. Nullam eu arcu et tellus posuere vulputate eget at urna. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam rutrum venenatis velit. Cras convallis tellus feugiat quam dignissim mollis.
                        </div>
                        <div class="references">
                            <div class="ref-image">
                                <img src="images/testuploadimage.jpg" />
                                <div class="img-desc">Lorem ipsum dolor sit amet</div>
                                <div class="img-class">General</div>
                            </div>
                            <div class="ref-image">
                                <img src="images/testuploadimage.jpg" />
                                <div class="img-desc">Lorem ipsum dolor sit amet</div>
                                <div class="img-class">General</div>
                            </div>
                        </div>
                        <div class="references">
                            <div class="ref-image">
                                <img src="images/testuploadimage.jpg" />
                                <div class="img-desc">Lorem ipsum dolor sit amet</div>
                                <div class="img-class">General</div>
                            </div>
                        </div>
                    </div>
                    




                    
                </div>
            </section>
            <section id="surface-conditions">
                <div class="bgfilled fh40">
                    <img  class="fh40" src="images/bgcolor3.png">
                    <div class="title">Surface Conditions</div>
                </div>
                <div class="content">





                    
                </div>
            </section>
            <section id="roofing-features">
                <div class="bgfilled fh40">
                    <img  class="fh40" src="images/bgcolor3.png">
                    <div class="title">Roofing Features</div>
                </div>
                <div class="content">
                    
                </div>
            </section>
            <section id="exterior-conditions">
                <div class="bgfilled fh40">
                    <img  class="fh40" src="images/bgcolor3.png">
                    <div class="title">Exterior Conditions</div>
                </div>
                <div class="content">
                    
                </div>
            </section>
            <section id="interior-conditions">
                <div class="bgfilled fh40">
                    <img  class="fh40" src="images/bgcolor3.png">
                    <div class="title">Interior Conditions</div>
                </div>
                <div class="content">
                    
                </div>
            </section>













            ';

//END OF PAGE//

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
    
    
    
}