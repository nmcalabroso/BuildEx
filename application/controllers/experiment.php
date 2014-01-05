<?php

class Experiment extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('experiments_model');
	}
	
	public function index() {
		$data['title'] = 'Experiment';
		$data['main_content'] = 'experiment/add_experiment_form';
		$this->load->view('_main_layout', $data);
	}

	public function add_experiment(){
		$info['title'] = $this->input->post('title');
		$info['category'] = $this->input->post('category');
		$info['description'] = $this->input->post('description');
		$info['target_count'] = $this->input->post('target_count');
		$uid = $this->session->userdata('id');
		$this->experiments_model->add_experiment($uid,$info);

		$role = $this->session->userdata('role')[0];
		redirect($role);
	}

	public function update_experiment($eid = NULL){
		$uid = $this->session->userdata('id');

		#setsession(eid)
		$this->session->set_userdata('eid', $eid);
		#endsession

		$data['experiment'] = $this->experiments_model->get_experiment($uid, $eid);
		$data['title'] = 'Experiment';
		$data['main_content'] = 'experiment/update_experiment_form';
		$this->load->view('_main_layout', $data);
	}

	public function insert_update(){
		$info['title'] = $this->input->post('title');
		$info['category'] = $this->input->post('category');
		$info['description'] = $this->input->post('description');
		$info['target_count'] = $this->input->post('target_count');

		$eid = $this->session->userdata('eid');

		#unsetsession(eid)
		$this->session->unset_userdata('eid');
		#endsession

		$this->experiments_model->update_experiment($eid, $info);

		$role = $this->session->userdata('role')[0];
		redirect($role);
	}
}