<?php


    /*
    Copyright (c) 2010-2011 Ozonetel Pvt Ltd.

    Permission is hereby granted, free of charge, to any person
    obtaining a copy of this software and associated documentation
    files (the "Software"), to deal in the Software without
    restriction, including without limitation the rights to use,
    copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the
    Software is furnished to do so, subject to the following
    conditions:

    The above copyright notice and this permission notice shall be
    included in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
    OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
    HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
    WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
    OTHER DEALINGS IN THE SOFTWARE.
    */    
    
    // VERSION: 1.0
    
    // KooKoo Php Libraries
    // ========================================================================
    class Response
    {
		private $doc;
		private $response;
		//constructor to have multiple constructors
		function __construct()
		{
			$a = func_get_args();
			$i = func_num_args();
			if (method_exists($this,$f='__construct'.$i)) {
				call_user_func_array(array($this,$f),$a);
			}
		}
	   
		function __construct0()
		{
			$this->doc= new DOMDocument("1.0", "UTF-8");
           
            $this->response= $this->doc->createElement("response");
            
			$this->doc->appendChild( $this->response);

			
		}
	   
		function __construct1($sid)
		{
			$this->doc= new DOMDocument("1.0", "UTF-8");
           
            $this->response= $this->doc->createElement("response");
            
			$this->response->setAttribute( "sid", $sid);
			
			$this->doc->appendChild( $this->response);


		}
		public function setSid($sid)
		{
			$this->response->setAttribute( "sid", $sid);
		}
		
		public function addPlayText($text)
		{
			$play_text =$this->doc->createElement("playtext",$text);
			$this->response->appendChild($play_text);
			
		}
		
		public function addHangup(){
			$hangup =$this->doc->createElement("hangup");
			$this->response->appendChild($hangup);
		}
     //conference
       	public function addDial($no)
         {
          	$dial= $this->doc->createElement("dial",$no);
          	$this->response->appendChild($dial);
         }
      
       //conference
       	public function addConference($confno)
         {
          	$conf= $this->doc->createElement("conference",$confno);
          	$this->response->appendChild($conf);
         }
    
		//send sms
		public function sendSms($text,$no)
		 {
		
		$sendsms = $this->doc->createElement( "sendsms",$text);
		$sendsms ->setAttribute( "to", $no );
		$this->response->appendChild($sendsms);
		}
		
		
		public function addPlayAudio($text){
			$play_audio =$this->doc->createElement("playaudio",$text);
			$this->response->appendChild($play_audio);
		}
		public function playdtmf(){
			$playdtmf =$this->doc->createElement("playtdtmf-i");
			$this->response->appendChild($playdtmf);
		}
		
		public function addCollectDtmf($cd){
			$collect_dtmf=$this->doc->importNode($cd->getRoot(),true);
			$this->response->appendChild($collect_dtmf);
		}
		//recordtag
		public function addRecord($filename,$format="wav",$silence="2",$maxduration="30",$option="k")
		{
			$record = $this->doc->createElement( "record",$filename);
			$record->setAttribute( "format", $format );
			$record->setAttribute( "silence", $silence);
			$record->setAttribute( "maxduration",$maxduration);
			$record->setAttribute( "option",$option);
			$this->response->appendChild($record );
		}

		// Parse the XML.and Deconstruct

		public function getXML()
		{
			return $this->doc->saveXML();
		}
		
		public function send()
		{
			print $this->doc->saveXML();

		}


	}
	
	
	class CollectDtmf
    {
		private $doc;
		private $collect_dtmf;
		//constructor to have multiple constructors
		function __construct()
		{


			$a = func_get_args();
			$i = func_num_args();
			if (method_exists($this,$f='__construct'.$i)) {
				call_user_func_array(array($this,$f),$a);
			}
		}
	   
		function __construct0()
		{
			$this->doc= new DOMDocument("1.0", "UTF-8");
           
            $this->collect_dtmf= $this->doc->createElement("collectdtmf");
            
			$this->doc->appendChild( $this->collect_dtmf);

			
		}
	   
		function __construct3($max_digits,$term_char,$time_out)
		{
			$this->doc= new DOMDocument("1.0", "UTF-8");
           
            $this->collect_dtmf= $this->doc->createElement("response");
            
			$this->collect_dtmf->setAttribute( "l", $max_digits);
			$this->collect_dtmf->setAttribute( "t", $term_char);
			$this->collect_dtmf->setAttribute( "o", $time_out);
			
			$this->doc->appendChild( $this->collect_dtmf);


		}
		
		
		public function setMaxDigits($maxDigits)
		{
			$this->collect_dtmf->setAttribute("l", $maxDigits);
		}
		
		public function setTermChar($termChar){
			$this->collect_dtmf->setAttribute("t", $termChar);
			
		}
		public function setTimeOut($timeOut){
			$this->collect_dtmf->setAttribute("o", $timeOut);
		}
		
		public function addPlayText($text)
		{
			$play_text =$this->doc->createElement("playtext",$text);
			$this->collect_dtmf->appendChild($play_text);
		}
		
		public function addPlayAudio($text){
			$play_audio =$this->doc->createElement("playaudio",$text);
			$this->collect_dtmf->appendChild($play_audio);
		}
		
		public function getRoot()
		{
			return $this->collect_dtmf;
		}
	
	}
?>
