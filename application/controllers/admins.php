<?php

class Admins extends User_Controller{

	public function __construct(){
		parent::__construct();
		$this->role = 'admin';
		$this->load->model('admin_model','admin');
	}

	/* Admin Pages */
	public function administrators(){
		$data['admins'] = $this->get_admins_list();
		$data['title'] = 'Admin';
		$data['main_content'] = 'users/index';
		$data['page'] = 'administrators';
		$data['notification'] = $this->session->flashdata('notification');
		$this->load->view('main_layout',$data);
	}

	public function laboratories(){
		$data['laboratories'] = $this->get_laboratories_list();
		$data['title'] = 'Admin';
		$data['main_content'] = 'users/index';
		$data['page'] = "laboratories";
		$data['notification'] = $this->session->flashdata('notification');
		$this->load->view('main_layout',$data);
	}

	public function faculty(){
		$data['faculty'] = $this->get_faculty_list();
		$data['requests'] = $this->get_faculty_account_requests();
		$data['title'] = 'Admin';
		$data['main_content'] = 'users/index';
		$data['page'] = 'faculty';
		$data['notification'] = $this->session->flashdata('notification');
		$this->load->view('main_layout',$data);
	}

	public function graduates(){
		$data['graduates'] = $this->get_graduates_list();
		$data['title'] = 'Admin';
		$data['main_content'] = 'users/index';
		$data['page'] = 'graduates';
		$data['notification'] = $this->session->flashdata('notification');
		$this->load->view('main_layout',$data);
	}

	public function experiments(){
		$data['experiments'] = $this->get_experiments_list();
		$data['title'] = 'Admin';
		$data['main_content'] = 'users/index';
		$data['page'] = 'experiments';
		$data['notification'] = $this->session->flashdata('notification');
		$this->load->view('main_layout',$data);
	}

	public function respondents(){
		return 0;
	}
	/* End of Admin Pages */
	
	/* REST Methods */
	public function create(){
		$username = $this->input->post('username');
		if($this->admin->create($username)){
			$msg = 'Success!';
		}
		else{
			$msg = 'Invalid input. Please try again.';
		}
		$this->session->set_flashdata('notification',$msg);
		redirect('admin/administrators');
	}

	public function destroy(){
		$admin_id = $this->input->post('admin_id');
		if($this->admin->destroy($admin_id, NULL)){
			$msg = "Deletion successful!";
		}
		else{
			$msg = "Deletion failed!";
		}
		$this->session->set_flashdata('notification',$msg);
		redirect('admin/administrators');
	}

	public function view($username = NULL){
		$user = $this->user_model->get(0,$username);
		$data['user'] = $user;
		$data['title'] = $user->username;
		$data['main_content'] = 'users/index';
		$data['page'] = 'view';
		$this->load->view('main_layout',$data);
	}
	/* End of REST Methods */

	/* Faculty */
	public function confirm_faculty(){
		$this->load->model('faculty_model','faculty');
		$fid = $this->input->post('faculty_id');
		if($this->faculty->confirm($fid,$faculty_info)){
			$msg = 'Confirmation successful!';
		}
		else{
			$msg = 'Confirmation failed!';
		}
		$this->session->set_flashdata('notification',$msg);
		redirect('admin/faculty');
	}

	public function reject_faculty(){
		$this->load->model('faculty_model','faculty');
		$fid = $this->input->post('faculty_id');
		if($this->faculty->reject($fid)){
			$msg = 'Rejection complete!';
		}
		else{
			$msg = 'Rejection failed!';
		}
		$this->session->set_flashdata('notification',$msg);
		redirect('admin/faculty');
	}
	/* End of Faculty */

	/* Private functions */
	private function get_admins_list(){
		return $this->admin->all();
	}

	private function get_laboratories_list(){
		$this->load->model('laboratory_model', 'laboratory');
		return $this->laboratory->get_all_laboratories();
	}

	private function get_faculty_list(){
		$this->load->model('faculty_model', 'faculty');
		return $this->faculty->get_all_faculty();
	}

	private function get_faculty_account_requests(){
		$this->load->model('faculty_model', 'faculty');
		return $this->faculty->get_all_account_requests();
	}

	private function get_graduates_list(){
		$this->load->model('graduate_model', 'graduate');
		return $this->graduate->get_all_graduates();
	}

	private function get_experiments_list(){
		$this->load->model('experiment_model', 'experiment');
		return $this->experiment->all();
	}

	private function get_respondents_list(){
		$this->load->model('respondent_model','respondent');
		return $this->respondent->get_all_respondents();
	}
	/* End of private functions */
}
