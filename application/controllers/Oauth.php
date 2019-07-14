<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Oauth extends CI_Controller 
{
	public function __construct()
		{
			parent::__construct();
			$this->load->library('session');
			$this->load->model('Crud_model');
			$this->load->database();
		}
	public function otp()
	{					
		        $mobile = $this->input->post('mobile');
                $otp=rand(100000,999999);
                $this->session->set_tempdata('otp', $otp, 500);
                $this->session->set_tempdata('mobile',$mobile,500);
                $msg = "<#> Your otp for blood for need is ".$otp."\nWuDbIC42NsD";   
                print_r($otp);
			$res=$this->send_sms($msg,$mobile);     
				$this->output
        			->set_content_type('application/json')
       				 ->set_output(json_encode(array('message' => $res.$otp)));   
	}
	public function verifyotp()
	{
		if($this->input->post('mobile')==$this->session->tempdata('mobile'))
		{
			if($this->input->post('otp')==$this->session->tempdata('otp'))
			{	
				$this->output
        				->set_content_type('application/json')
       					 ->set_output(json_encode(array('message' => "otp verified successfully")));   
       					   $this->session->unset_tempdata('otp');
                $this->session->unset_tempdata('mobile');
       		}
       		else
       		{
       		$this->output
        				->set_content_type('application/json')
       					 ->set_output(json_encode(array('message' => "otp entered is incorrect")));   	
       		}
		}
		else
		{
			$this->output
        				->set_content_type('application/json')
       					 ->set_output(json_encode(array('message' => "an error occured please try again")));  
		}
	}
	public function resend()
	{	
		if($this->session->tempdata('otp')!=NULL)
		{
			$mobile = $this->input->post('mobile');
			 $this->session->set_tempdata('mobile',$mobile,500);
			$otp = $this->session->tempdata('otp');
			$msg = "<#> Your otp for blood donation is ".$otp."\n+Xd6DjZawYL";
			$res=$this->send_sms($msg,$mobile);    
				$this->output
        			->set_content_type('application/json')
       				 ->set_output(json_encode(array('message' => $res)));
		}
		else
		{
			$this->otp();
		}
	}
	 private function send_sms($msg, $mbl)
		{
   			 $msg = urlencode($msg);
   			 $ch = curl_init();
   			 curl_setopt($ch, CURLOPT_URL,"http://103.247.98.91/API/SendMsg.aspx?uname=20181090&pass=9Q1Jp9oa&send=SKILLL&dest=$mbl&msg=$msg&priority=1");
 			  curl_setopt($ch, CURLOPT_HEADER, 0);
 			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 			 if(curl_exec($ch))
 			 {
 			 	$res="sms sent successfully";
 			 }
 			 else
 			 {
 			 	$res ="error occured while sending sms";
 			 }
  	 		 curl_close($ch);
  	 		 return $res;
		}
		public function accepted($name,$mbl)
		{		
					$msg = $name." has accepted your request.";
				$res=$this->send_sms($msg,$mbl);    
				$this->output
        			->set_content_type('application/json')
       				 ->set_output(json_encode(array('message' => $res)));
		}
		public function rejected($name,$mbl)
		{
		$msg = $name." has rejected your request.";
				$res=$this->send_sms($msg,$mbl);    
				$this->output
        			->set_content_type('application/json')
       				 ->set_output(json_encode(array('message' => $res)));	
		}
		public function resendhelpsms()
		{
			$mbl = $this->input->post('mobile');
			$msg = $this->input->post('msg');
			$res=$this->send_sms($msg,$mbl);    
				$this->output
        			->set_content_type('application/json')
       				 ->set_output(json_encode(array('message' => $res)));	
		}
		public function askhelp()
		{			
			$mbl = $this->input->post('mobile');
			$msg = $this->input->post('msg');
$data=array('request_id'=>$this->input->post('request_id'),'donorid'=>$this->input->post('donorid'),'requester_id'=>$this->input->post('requester_id')
						);
			if($this->Crud_model->raisereq($data))
			{
				$res=$this->send_sms($msg,$mbl);    
				$this->output
        			->set_content_type('application/json')
       				 ->set_output(json_encode(array('message' => $res)));	
			}
			else 
			{
				$this->output
        			->set_content_type('application/json')
       				 ->set_output(json_encode(array('message' => "We couldn't connect you with the donor.")));
			}
  	 		 
		}
		private function addmyraisedreq($data)
		{
			if($this->Crud_model->raisereq($data))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
}