<?php

class Admin extends MY_Controller{
	
	public function index() {
		$data['title'] = 'Admin';
		$data['main_content'] = 'contents/admin_body';
		$this->load->view('_main_layout', $data);
	}
}