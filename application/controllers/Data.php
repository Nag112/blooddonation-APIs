<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class data extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Crud_model');
		$this->load->database();
	}
	public function save()
	{	
		$this->load->model('Crud_model');		
			$data = array('ID' =>random_int(1000000, 9999999),
			'name'=>$this->input->post('name'),
			'mobile'=>$this->input->post('mobile'),
			'email'=>$this->input->post('email'),
			'gender'=>$this->input->post('gender'),
			'city'=>$this->input->post('city'),
			'area'=>$this->input->post('area'), 
			'last_donated'=>$this->input->post('lastdonated'));
			$this->Crud_model->saverecords($data);
	}
		public function reciever()
		{		$id=random_int(1000000, 9999999);
			$data = array('request_id' =>$id,
				'requester_id'=>$this->input->post('id'),
			'name'=>$this->input->post('name'),
			'units'=>$this->input->post('units'),
			'city'=>$this->input->post('city'),
			'area'=>$this->input->post('area'),
			'hospital'=>$this->input->post('hospital'),
			'blood_group'=>$this->input->post('bloodgrp'),
			'contact_no'=>$this->input->post('mobile'),
			'google_loc'=>$this->input->post('google_loc'),
			'status'=>$this->input->post('status'),
			'date'=>$this->input->post('date'),
			'req_type'=>$this->input->post('req_type'),
			'platelets'=>$this->input->post('platelets')
			);
			$msg['donors']=$this->Crud_model->request($data);
			$msg['request_id']=$id;
			$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($msg));
	}
	public function donorcount()
	{	
		$result=$this->Crud_model->d_count();
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));
	}
	public function reqcount()
	{	
		$result=$this->Crud_model->req_count();
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));
	}
	public function searchall()
	{
		$filter = $this->input->post('filter');
		$result = $this->Crud_model->searchall($filter);
			$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));	
	}
	public function allrequests()
	{
		$result = $this->Crud_model->allrequests();
			$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));		
	}
	public function profile()
	{
		$email = $this->input->post('email');
		$result = $this->Crud_model->profile($email);
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));		
	}
	public function becomedonor()
	{		
		$email = $this->input->post('email');
		$data = array('gender' => $this->input->post('gender'),
						'donor'=>'YES',
						'name'=>$this->input->post('name'),
						'mobile'=>$this->input->post('mobile'),
						'area'=>$this->input->post('area'), 
						'city'=>$this->input->post('city'),
						'bloodgroup'=>$this->input->post('bloodgrp'),
						'last_donated'=>$this->input->post('lastdonated'),
						'visiblity'=>$this->input->post('visibility'),
						'dob'=>$this->input->post('dob'),
						'google_loc'=>$this->input->post('google_loc')
					);
		$result['message'] = $this->Crud_model->becomedonor($email,$data);
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));			
	}
	public function profileupdate()
	{		
		$email = $this->input->post('email');
		$data = array('gender' => $this->input->post('gender'),
						'name'=>$this->input->post('name'),
						'mobile'=>$this->input->post('mobile'),
						'city'=>$this->input->post('city'),
						'area'=>$this->input->post('area')
					 );
		$result['message'] = $this->Crud_model->profileupdate($email,$data);
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));			
	}
	public function lastdonatedupdate()
	{
		$email = $this->input->post('email');
		$lastdonated = $this->input->post('lastdonated');
			$result = $this->Crud_model->lastdonationupdate($email,$lastdonated);
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));	
	}
	public function updatestatus()
	{
		$email = $this->input->post('email');
		$status = $this->input->post('status');
			$result = $this->Crud_model->updateuserstatus($email,$status);
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));	
	}
	public function feedback()
	{	
		$data['name'] = $this->input->post('name');
		$data['phone'] = $this->input->post('phone');
		$data['email'] = $this->input->post('email');
		$data['message'] = $this->input->post('message');
			$result['message'] = $this->Crud_model->feedback($data);
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));	
	}
	function getraisedreq()
	{
		$id=$this->input->post("id");
		$result = $this->Crud_model->fetchraisedreq($id);
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));	
	}
	function updatereqstatus()
	{
		$id=$this->input->post("id");
		$status=$this->input->post("status");
		$result = $this->Crud_model->updatereqstatus($id,$status);
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));	
	}
	function updatereqdate()
	{
		$id=$this->input->post("id");
		$date=$this->input->post("date");
		$result = $this->Crud_model->updatedate($id,$date);
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($result));	
	}
	function getuserstatus()
	{
		$email = $this->input->post('email');
		$this->db->select('userstatus');
		$res=$this->db->get_where('users',array('email'=>$email));
		$this->output
        		->set_content_type('application/json')
        		->set_output(json_encode($res->result()));	
	}
}?>