<?php

$rootDirectory = "https://take2tech.ca/TTT/AllowanceTracker/";
$accountActivationKey = "3cb81cc6-a940-452d-bb65-bacfd5a288f3";
$defaultDemoAccountId = '45';

//declare session variables
if(!isset($_SESSION['id'])) {
    $_SESSION['id'] = "";
}
if(!isset($_SESSION['piggyBankId'])) {
    $_SESSION['piggyBankId'] = "";
}
if(!isset($_SESSION['piggyBankName'])) {
    $_SESSION['piggyBankName'] = "";
}
if(!isset($_SESSION['piggyBankOwner'])) {
    $_SESSION['piggyBankOwner'] = "";
}


return [
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost:3306',
        'dbname' => 'tmurvvvv_piggyb',
        'username' => 'tmurvvvv_me',
        'password' => '!Tm427712*'
    ],
    'reCaptcha' => [
        'key' => '6Ld8yWwUAAAAACRp7MQSRNjFAyrdUQOjnIoDcFO9',
        'secret' => '6Ld8yWwUAAAAACtWRHV1VudOTBarP5SUgPn7SeA2'
    ]
];

?>
