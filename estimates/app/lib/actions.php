<?php

class Action {
    
    public static function displayEstimate(Estimate $estimate) {
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
            <h2>Display this record</h2>
            </body>
            </html>
        
        ';
        
        return $html;
    }


    public static function displayEmail(Estimate $estimate, $emails) {
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
            </body>
            </html>
        
        ';
        
        return $html;
    }
    
    
    
}