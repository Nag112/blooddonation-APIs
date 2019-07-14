<?php
class Crud_model extends CI_Model 
{
	
	function saverecords($data)
	{
	if($this->db->insert('users',$data))
	{
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('message' => 'Successfully added')));
	}
	else
	{
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('message' => 'User addition failed')));
	}
	}          
	public function searchall($filter)
	{	
		if($filter==NULL)
		 {
		 	$query=$this->db->select('ID,name,city,area,visiblity,mobile,bloodgroup,last_donated')->get_where('users',array('donor'=>'yes'));
 			if($query->result()>0)	
 			{
 				return $query->result();
 			}
 			else{return "No donors found in your city";}
 		}
 		else
 		{
 			$query=$this->db->select('ID,name,city,area,mobile,bloodgroup,last_donated')->get_where('users',array('donor'=>'yes','city'=>$filter));
 			return $query->result();
 		}
	}
	public function allrequests()
	{	
		 $query=$this->db->query("select name,city,area,req_type,date,platelets,units,contact_no,blood_group,status,google_loc from bloodrequest where status='OPEN'");
 	return $query->result();
	}
	function d_count()
	{
		 $query=$this->db->query("select count(*) from users where donor='YES'");
 		return $query->result();
	}
	function req_count()
	{
		$query=$this->db->query("select count(*) from bloodrequest where status='OPEN'");
 		return $query->result();
	}
	function profile($email)
	{
		$query=$this->db->get_where('users',array('email'=>$email));
 		return $query->result();
	}
	function becomedonor($email,$data)
	{
		$this->db->where('email',$email);
		if($this->db->update('users',$data))
		{
			return "You are a hero now.";
		}
		else
		{
			return "An error occured please try again later..";
		}
	}
	function profileupdate($email,$data)
	{
		$this->db->where('email',$email);
		 if($this->db->update('users',$data))
		 {
		 	return "Your profile updated Successfully";
		 }
		 else
		 {
		 return "Your profile couldnot be updated this time please try again later";	
		 }		
	}
	function lastdonationupdate($email,$lastdonated)
	{
		$data = array('last_donated' => $lastdonated);
		$this->db->where('email',$email);
		return $this->db->update('users',$data);
	}
	function updateuserstatus($email,$status)
	{
		$data = array('userstatus' => $status);
		$this->db->where('email',$email);
		return $this->db->update('users',$data);
	}
	function feedback($data)
	{
		if($this->db->insert('feedback',$data))
		{
			return "Your feedback is Successfully sent";
		}
		else
		{
			return "Your feedback is not sent,please try again later";
		}
	}
	function raisereq($data)
	{
		if($this->db->insert('myraisedreq',$data))
		{
			return true;
		}
		else
		{	
			echo "database error";
			return false;
		}
	}
	function updatereqstatus($id,$status)
	{
		$data = array('STATUS' => $status);
		$this->db->where('request_id',$id);
		return $this->db->update('bloodrequest',$data);
	}
	function updatedate($id,$date)
	{
		$data = array('date' => $date);
		$this->db->where('request_id',$id);
		return $this->db->update('bloodrequest',$data);
	}
	function fetchraisedreq($id)
	{	
		$query=$this->db->get_where('myraisedreq',array('requester_id'=>$id));
		  if($query->num_rows()>0)
				 {$i=0;
				 	foreach ( $query->result_array() as $row) 
				 	{				$query= $this->db->query("select users.name as donorname,users.bloodgroup,users.google_loc,bloodrequest.name as patientname,bloodrequest.STATUS as req_status ,bloodrequest.date,bloodrequest.hospital,bloodrequest.units,bloodrequest.contact_no,bloodrequest.request_id from users,bloodrequest where users.ID=".$row['donorid']." and bloodrequest.request_id=".$row['request_id']);	
				 		$data[$i]=$query->result();
				 		$i++;
				 	}
				 }
				 else
				 {
				 	$data[0] = "You have no requests";
				 }
				return $data;
	}
	function request($data)
	{	
		if($this->db->insert('bloodrequest',$data))
			{
				  $query=$this->db->query("select ID,name,city,area,mobile,visiblity,bloodgroup,last_donated from users where city='".$data['city']."' AND bloodgroup='".$data['blood_group']."'");
				 if(count($query->result())>0)
				 {
				 	$msg = $query->result();
				 }
				 else
				 {
				 	$msg = "No donors found with your preferences";
				 }
				return $msg;
			}
			else
			{
				return "request cannot be added";
			}
	
	}  


}