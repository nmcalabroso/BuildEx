<?php

class Faculty_model extends MY_Model{

	/* CRUD Methods */
	public function create($user_info = NULL, $faculty_id = 0){
		$faculty_info['uid'] = $this->user_model->create($user_info);
		$faculty_info['faculty_num'] = $faculty_id;
		$this->db->insert('Faculty', $faculty_info);
		return $this->db->insert_id();
	}

	public function get($fid = 0, $username = NULL){
		$this->db->join('Users','Users.uid = Faculty.uid');

		if($fid > 0){
			$this->db->where('Faculty.fid', $fid);
		}
		else if(!is_null($username)){
			$this->db->where('Users.username', $username);
		}
		
		$q = $this->db->get('Faculty');
		return $this->query_row_conversion($q);
	}

	public function all(){
		$this->db->where('Faculty.account_status','t');
		$this->db->join('Users','Users.uid = Faculty.uid');
		$q = $this->db->get('Faculty');
		return $this->query_conversion($q);
	}

	public function update($fid = 0, $faculty_info = NULL){
		$this->db->where('fid', $fid);
		$this->db->update('Faculty', $faculty_info);
		return $this->is_rows_affected();
	}

	public function destroy($fid = 0, $username = NULL){
		
		if($fid > 0){
			$this->db->where('fid',$fid);
			$this->db->delete('Faculty');
		}
		else{
			$q = "DELETE FROM \"Faculty\" AS f
				  USING \"Users\" AS u
				  WHERE f.uid = u.uid AND
				  u.username = ?";
			$this->db->query($q,array($username));
		}
		
		return $this->is_rows_affected();
	}
	/* End of CRUD */

	public function get_rules(){
		//put form validation here
		return 0;
	}

	public function get_experiments($fid = 0, $category = NULL){
		$this->db->join('faculty_conduct', 'faculty_conduct.eid = Experiments.eid');
		$this->db->join('Faculty', 'Faculty.fid = faculty_conduct.fid');
		$this->db->where('Faculty.fid', $fid);
		$q = $this->db->get('Experiments');
		return $this->query_conversion($q);
	}

	public function get_advisory_experiments($fid = 0, $is_confirmed = 't', $category = NULL){
		$this->db->join('advise', 'advise.eid = Experiments.eid');
		$this->db->join('Faculty', 'Faculty.fid = advise.fid');
		$this->db->join('graduates_conduct', 'graduates_conduct.eid = Experiments.eid');
		$this->db->join('Graduates', 'Graduates.gid = graduates_conduct.gid');
		$this->db->join('Users', 'Users.uid = Graduates.uid');
		$this->db->where('Faculty.fid', $fid);
		$this->db->where('advise.status', $is_confirmed);
		$q = $this->db->get('Experiments');

		return $this->query_conversion($q);
	}

	public function get_experiment($fid = 0, $eid = 0){
		$this->db->join('faculty_conduct', 'faculty_conduct.eid = Experiments.eid');
		$this->db->join('Faculty', 'Faculty.fid = faculty_conduct.fid');
		$this->db->where('Experiments.eid', $eid);
		$this->db->where('Faculty.fid', $fid);
		$q = $this->db->get('Experiments');
		return $this->query_row_conversion($q);
	}

	public function get_laboratory($fid, $cond = 't'){
		$this->db->select('Laboratories.*');
		$this->db->join('faculty_member_of', 'faculty_member_of.labid = Laboratories.labid');
		$this->db->where('faculty_member_of.fid', $fid);
		$this->db->where('faculty_member_of.status', $cond);
		$q = $this->db->get('Laboratories');
		return $this->query_row_conversion($q);
	}

	public function confirm($fid = 0){
		$faculty_info['account_status'] = 'true';
		return $this->update($fid, $faculty_info);
	}

	public function reject($fid = 0){
		return $this->destroy($fid);
	}

	public function is_confirmed($fid = 0){
		$faculty = $this->faculty->get($fid, NULL);
		return $faculty->account_status == 't';
	}

	public function advise_experiment($fid = 0, $eid = 0){
		$this->load->model('experiment_model', 'experiment');
		$info['status'] = 't';
		$this->db->where('fid', $fid);
		$this->db->where('eid', $eid);
		$this->db->update('advise', $info);
		$experiment_info['is_published'] = 't';
		$this->experiment->update($eid, $experiment_info);
		return $this->is_rows_affected();
	}

	public function reject_experiment($fid,$eid){
		$this->db->where('fid', $fid);
		$this->db->where('eid', $eid);
		$this->db->delete('advise');
		return $this->is_rows_affected();
	}

	public function request_advise($fid = 0, $eid = 0){
		$info = array('fid'=>$fid,'eid'=>$eid);
		return $this->db->insert('advise', $info);
	}

	public function get_all_account_requests(){
		$this->db->join('Users','Users.uid = Faculty.uid');
		$this->db->where('Faculty.account_status', 'f');
		$q = $this->db->get('Faculty');
		return $this->query_conversion($q);
	}

	public function get_by_experiment($eid = 0){
		$this->db->join('Users', 'Users.uid = Faculty.uid');
		$this->db->join('faculty_conduct', 'faculty_conduct.fid = Faculty.fid');
		$this->db->where('faculty_conduct.eid', $eid);
		$q = $this->db->get('Faculty');
		return $this->query_row_conversion($q);
	}
}
