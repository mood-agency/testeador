<?php

/*

	Modified by: Argenis Leon @argenisleon
	January 20 2013 
	W3C not accept soap12 param. Now only accepts json.
	fopen not seems to works now using curl in function makeValidationCall

   Author:	Jamie Telin (jamie.telin@gmail.com), currently at employed Zebramedia.se	
   Scriptname: W3C Validation Api v1.0 (W3C Markup Validation Service)

 */
class W3cValidateApi{

	var $BaseUrl = 'http://validator.w3.org/check';
	var $Output = 'json';
	var $Uri = '';
	var $Feedback;
	var $CallUrl = '';
	var $ValidResult = false;
	var $ValidErrors = 0;
	var $Sleep = 1;
	var $SilentUi = false;
	var $Ui = '';

	function W3cValidateApi(){
		//Nothing...
	}

	function makeCallUrl(){
		$this->CallUrl = $this->BaseUrl . "?output=" . $this->Output . "&uri=" . $this->Uri;
		//echo $this->CallUrl
	}
	
	function setUri($uri){
		$this->Uri = $uri;
		$this->makeCallUrl();
	}


	function urlLink() {
		return $this->BaseUrl . "?uri=" . $this->Uri;
	}

	function makeValidationCall(){
		if($this->CallUrl != '' && $this->Uri != '' && $this->Output != ''){
			
			$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

			$ch = curl_init();
		
			curl_setopt($ch, CURLOPT_URL, $this->CallUrl);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Fix - SSL certificate problem: unable to get local issuer certificate

			curl_setopt($ch, CURLOPT_RETURNTRANSFER ,true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			
			$contents = curl_exec($ch);
			if(curl_exec($ch) === false) {
				echo 'Curl error: ' . curl_error($ch);
			} else {
				//echo 'Operation completed without any errors';
			}
			
			//TODO in case of error we should handle it
			$this->Feedback = $contents;
			sleep($this->Sleep);
			
			return $contents;
		} else {
			return false;
		}
	}
	
	function validate($uri){
		if($uri != ''){
			$this->setUri($uri);
		} else {
			$this->makeCallUrl();
		}
		
		$this->makeValidationCall();
				
		$result = json_decode($this->Feedback, true);
					
		$info=0;
		$warnings =0;
		$error = 0;
		
		//print_r($result);
		foreach ($result['messages'] as $message ) {
			if ($message['type']=='info')
			$info++;
			else if ($message['type']=='error')
			$error++;
		}
		
		$this->ValidErrors = $error;

	}

	function ui_validate($uri){
		$this->validate($uri);
		if($this->ValidResult){
			$msg1 = 'This document was successfully checked';
			$color1 = '#00CC00';
		} else {
			$msg1 = 'Errors found while checking this document';
			$color1 = '#FF3300';
		}
		$ui = '<div style="background:#FFFFFF; border:1px solid #CCCCCC; padding:2px;">

					<h1 style="color:#FFFFFF; border-bottom:1px solid #CCCCCC; margin:0; padding:5px; background:'.$color1.'; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold;">

					 '.$msg1.'

					</h1>

					<div>

						<strong>Errors:</strong><br>
						'.$this->ValidErrors.'

					</div>

				</div>';

		$this->Ui = $ui;

		if($this->SilentUi == false){

			echo $ui;

		}
		return $ui;
	}
}

?>