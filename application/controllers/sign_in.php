<?php

class Sign_in extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('faculty_model','faculty');
	}

	public function index(){
		$data['title'] = 'Sign in';
		$data['main_content'] = 'sign_in/index';
		$data['notification'] = $this->session->flashdata('notification');	
		$this->load->view('main_layout', $data);
	}

	public function validate(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if($this->user_model->is_valid_user($username, $password)){
			$this->user_model->set_session_data($username);
			$roles = $this->session->userdata('roles');
			$active_role = $this->session->userdata('active_role');
			$active_id = $roles[$active_role];

			if($active_role == 'faculty'){
				if($this->faculty->is_confirmed($active_id) == 't'){
					redirect('faculty');
				}
				else{
					$new_session['logged_in'] = FALSE;
					$this->session->set_userdata($new_session);
					redirect('errors/faculty/waiting');
				}
			}
			else if($active_role != 'faculty'){
				redirect($active_role);
			}
		}
		$msg = 'Invalid username or password. Please try again.';
		$this->session->set_flashdata('notification', $msg);
		redirect('sign_in');
	}

	public function waiting(){
		$data['title'] = 'Error';
		$data['main_content'] = 'sign_in/faculty_waiting';
		$data['notification'] = $this->session->flashdata('notification');	
		$this->load->view('main_layout', $data);
	}
}
