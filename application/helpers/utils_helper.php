<?php 



function isUserLoggedIn(){

	$ci=& get_instance();

	return $ci->session->has_userdata('user_id');
}

function sendEmail($mailData){
	$ci=& get_instance();
	$ci->email->subject($mailData['subject']);
	$ci->email->from($mailData['fromMail'],$mailData['fromName']);
	$ci->email->to($mailData['toMail']);
	$ci->email->message($mailData['message']);
	if($ci->email->send()){
		echo "tekja";
	}else{
		echo "fgs";
	}
	print_r($ci->email->print_debugger());
	$ci->email->clear(TRUE);

}

function maskMobile($mobile,$chars=7){

	$mobile="xxxxxxx".substr($mobile,$chars);

	return $mobile;
}

 ?>