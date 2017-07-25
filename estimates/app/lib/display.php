<?php

class Display {
    
    public static function estimate(Estimate $estimate) {
        $html = '
            <!doctype html>

            <html lang="en">
            <head>
              <meta charset="utf-8">

              <title>Aladdin Roofing Estimate for ' . $estimate->jobName . '</title>
              <meta name="description" content="Aladdin Estimating App">
              <meta name="author" content="Todd Tamcsin Photography">

              <!--<link rel="stylesheet" href="css/styles.css?v=1.0">-->

              <!--[if lt IE 9]>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
              <![endif]-->

            </head>
            <body>
            <h1>' . $estimate->jobName . '</h1>
            <h2>Display this record</h2>
            </body>
            </html>
        
        ';
        
        echo '<pre>' . var_export($estimate, true) . '</pre>';
        
        
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