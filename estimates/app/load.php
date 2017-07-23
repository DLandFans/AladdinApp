<?php

//Load modules and components
if(!require_once(__DIR__ . '/vendor/autoload.php')) die("Component load failed.");
if(!require_once(__DIR__ . '/config/defaults.php')) die ("System defaults couldn't be loaded.");

//Load Classes
if(!require_once(__DIR__ . '/lib/knack.php')) die("Database system couldn't be loaded.");
if(!require_once(__DIR__ . '/lib/estimates.php')) die("Estimates class couldn't be loaded.");
if(!require_once(__DIR__ . '/lib/contacts.php')) die("Contacts class couldn't be loaded.");
if(!require_once(__DIR__ . '/lib/images.php')) die("Images class couldn't be loaded.");

if(!require_once(__DIR__ . "/lib/main.php")) die("Main library couldn't be loaded");
if(!require_once(__DIR__ . "/lib/actions.php")) die("Actions couldn't be loaded");
if(!require_once(__DIR__ . '/lib/emails.php')) die("Email class couldn't be loaded.");



