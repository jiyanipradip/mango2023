<?php

// Copyright 2008, FedEx Corporation. All rights reserved.
// Version 1.0.0

chdir('..'); 

require_once('library/fedex-common.php5'); 

$newline = "<br />";
ini_set("soap.wsdl_cache_enabled", "0");
 
$client = new SoapClient('path to wsdl', array('trace' => 1)); // replace with valid path to WSDL

$request['WebAuthenticationDetail'] = array('UserCredential' =>
                                                      array('Key' => 'xxxxxxxxxxxxxxxx', 'Password' => 'xxxxxxxxxxxxxxxxxxxxxxxxx')); // Replace 'XXX' with FedEx provided credentials
$request['Version'] = array('ServiceId' => 'opol', 'Major' => '1', 'Intermediate' => '0', 'Minor' => '0');
$request['ClientDetail'] = array('ClientProductId' => 'xxxx', 'ClientProductVersion' => 'xxxx', 'IntegratorId' => 'xxxxx');// Replace 'XXX' with your product ID, produc version, and integrator ID
$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Testing OPOL using PHP ***');                                                      

try 
{
    $response = $client -> getUploadLocation($request);  
        
    if ($response -> HighestSeverity == 'SUCCESS')
    {
    	printRequestResponse($client);
    }
    else
    {
    	echo 'Error in processing transaction.'. $newline. $newline; 
        foreach ($response -> Notifications as $notification)
        {
            if(is_array($response -> Notifications))
            {              
               echo $notification -> Severity;
               echo ': ';           
               echo $notification -> Message . $newline;
            }
            else
            {
                echo $notification . $newline;
            }
        } 
    } 
        
    writeToLog($client);    // Write to log file   

} catch (SoapFault $exception) {
   printFault($exception, $client);        
}

?>
