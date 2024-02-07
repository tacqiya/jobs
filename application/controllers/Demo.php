<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Demo extends CI_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->site_config = $this->config->item('site_config');
	}

    public function index() {
        $this->is_login();
		$data['page'] = 'demo-temp-opportunities';
		$data['opportunities'] = $this->common->getWhere(TBL_JOB_TEMP, ['publish !=' => 'published'], false, 'id DESC');

        $this->load->view('demo/header', $data);
		$this->load->view('demo/sidebar', $data);
		$this->load->view('demo/opportunities_temp', $data);
		$this->load->view('demo/footer', $data);
    }

    public function published() {
        $this->is_login();
		$data['page'] = 'demo-opportunities';
		$data['opportunities'] = $this->common->getWhere(TBL_JOB, ['publish' => 'published'], false, 'id DESC');

        $this->load->view('demo/header', $data);
		$this->load->view('demo/sidebar', $data);
		$this->load->view('demo/opportunities_new', $data);
		$this->load->view('demo/footer', $data);
    }

    public function is_login()
	{
		$this->session->unset_userdata('stored_redirect_url');
		if ($this->session->userdata('admin-login') !== TRUE) {
			$this->session->set_userdata('stored_redirect_url', current_url());
			redirect(LOGIN_URL, 'refresh');
		}
	}

	public function add_foreign_key() {
		// echo "Unavailable";exit;
		$opportunities = $this->common->getWhere(TBL_JOB, ['publish' => 'published'], false, 'id DESC');
		foreach($opportunities as $oppr) {
			$check_temp_job = $this->common->getWhere(TBL_JOB_TEMP, ['position_code' => $oppr->position_code], true);
			if($check_temp_job) {
				// echo "<pre>"; print_r($check_temp_job);
				$this->common->updateQuery(TBL_JOB, ['id' => $oppr->id], ['temp_key_id' => $check_temp_job->id]);
			}
		}
	}
}