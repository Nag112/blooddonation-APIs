<?php
require(APPPATH.'libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_server extends REST_Controller 
{

	public function __construct()
		{
			parent::_construct();
			$this->load->library('session');
			$this->load->helper('lms_helper');
			$this->load->helper('utils_helper');
		}
 function otp_post()
	{
		            $mobile = array('mob' => $this->post('mob'));
                $otp=rand(100000,999999);
                $msg = "Your otp for blood donation is ".$otp;
                print_r($mobile['mob']);
                print_r($msg);
     			$this->response($mobile, 200);
				$this->send_sms($msg, $mobile['mob']);
        
	}
	 public function send_sms($msg, $mbl)
	{
    $msg = urlencode($msg);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://103.247.98.91/API/SendMsg.aspx?uname=20181090&pass=9Q1Jp9oa&send=SKILLL&dest=$mbl&msg=$msg&priority=1");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);
}
}?>

public function resend_otp()
    {
        $this->db->where('id', $insert_id);
        $this->db->select('*');
        $query = $this->db->get('student')->row();
        
        send_sms($msg, $query->phone);
    }

    public function otp()
    {   
        $tempID=$this->session->flashdata('temp_id');

        if (!empty($tempID)) {

            $mobileUser=$this->db->get_where('student',array('id' => $tempID))->row_array();

            $data['mobile']=$mobileUser['phone'];
            $this->load->view('signup_2', $data);

        } else {

            redirect(base_url());
        }
    }