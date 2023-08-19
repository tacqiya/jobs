<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->site_config = $this->config->item('site_config');
	}

	public function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->input->post()) {
			if ($this->form_validation->run() === TRUE) {
				$name = $this->input->post('username');
				$pass = md5(md5(md5($this->input->post('password'))));
				$query = $this->common->getRowByMulty(TBL_LOGIN, array('username' => $name, 'password' => $pass));
				if (!empty($query->id)) {
					$this->session->set_userdata('admin-login', TRUE);
					redirect(ADMIN_URL . '/dashboard', 'refresh');
				} else {
					$data['results'] = '<div class="error">Login Failed! Username or Password does not match.</div>';
				}
			} else {
				echo "non";
			}
		}
		$data['page'] = 'login';
		$this->load->view('login', $data);
	}

	public function is_login()
	{
		if ($this->session->userdata('admin-login') !== TRUE) {
			redirect(LOGIN_URL, 'refresh');
		}
	}

	public function index()
	{
		$this->is_login();
		if ($this->session->userdata('admin-login') === TRUE) {
			redirect(ADMIN_URL . '/all-categories', 'refresh');
		}
		$data['page'] = 'index';
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('elements/footer', $data);
	}

	public function add_category()
	{
		$this->is_login();
		$data['page'] = 'add-category';

		if ($this->input->post()) {
			extract($this->input->post());
			$this->form_validation->set_rules('title', 'Category Name', 'required');
			$this->form_validation->set_rules('slug', 'Slug', 'required');

			if ($this->form_validation->run() === TRUE) {
				$data_pass = compact("title", "slug", "parent", "description");
				// echo "<pre>"; print_r($data_pass);exit;
				$this->db->insert(TBL_CATEGORY, $data_pass);
				if ($this->db->trans_status()) {
					$data['result'] = array('type' => 'success', 'msg' => 'Category has been added successfully.');
				} else {
					$data['result'] = array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!');
				}
			} else {
				$data['result'] = array('type' => 'error', 'msg' => 'Please fill all the fields!');
			}
		}
		$data['parent'] = $this->common->getAll(TBL_CATEGORY, 'id', 'ASC');
		$data['page'] = 'add-category';
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('add-category', $data);
		$this->load->view('elements/footer', $data);
	}

	public function category()
	{
		$this->is_login();
		$data['page'] = 'all-categories';
		$data['categories'] = $this->common->getAll(TBL_CATEGORY, 'id', 'ASC');
		if ($data['categories']) {
			foreach ($data['categories'] as $cat) {
				if ($cat->parent != 0) {
					$get_parent = $this->common->getRowBy(TBL_CATEGORY, 'parent', $cat->parent);
					$cat->parent = $get_parent->title;
				} else {
					$cat->parent = '';
				}
			}
		}
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('categories', $data);
		$this->load->view('elements/footer', $data);
	}

	public function edit_category($id)
	{
		$this->is_login();
		if ($this->input->post()) {
			extract($this->input->post());
			$this->form_validation->set_rules('title', 'Category Name', 'required');
			$this->form_validation->set_rules('slug', 'Slug', 'required');

			if ($this->form_validation->run() === TRUE) {
				$data_pass = compact("title", "slug", "parent", "description");
				// echo "<pre>"; print_r($data_pass);exit;
				$this->db->update(TBL_CATEGORY, $data_pass, array('id' => $id));
				if ($this->db->trans_status()) {
					$data['result'] = array('type' => 'success', 'msg' => 'Category has been updated successfully.');
				} else {
					$data['result'] = array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!');
				}
			} else {
				$data['result'] = array('type' => 'error', 'msg' => 'Please fill all the fields!');
			}
		}
		$data['page'] = 'edit-category';
		$data['parent'] = $this->common->getAll(TBL_CATEGORY, 'id', 'ASC');
		$data['category'] = $this->common->getRowBy(TBL_CATEGORY, 'id', $id);

		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('edit-category', $data);
		$this->load->view('elements/footer', $data);
	}

	public function add_opportunity()
	{
		$this->is_login();
		if ($this->input->post()) {
			extract($this->input->post());
			//$this->form_validation->set_rules('position_title', 'Position Title', 'required');
			//$this->form_validation->set_rules('position_code', 'Position Code', 'required');
			//$this->form_validation->set_rules('position_type', 'Position Type', 'required');
			//$this->form_validation->set_rules('position_duration', 'Position Duration', 'required');
			//$this->form_validation->set_rules('project_title', 'Project Title', 'required');
			//$this->form_validation->set_rules('project_supervisor', 'Project Supervisor', 'required');
			//$this->form_validation->set_rules('academic_department', 'Academic Department', 'required');
			//$this->form_validation->set_rules('relevant_research_center', 'Relevent Research Center', 'required');
			//$this->form_validation->set_rules('technical_keywords', 'Technical Keywords', 'required');
			//$this->form_validation->set_rules('schedule', 'Schedule', 'required');
			//$this->form_validation->set_rules('closing_date_time', 'Closing Date & Time', 'required');
			//$this->form_validation->set_rules('salary', 'Salary', 'required');
			//$this->form_validation->set_rules('apply_link', 'Apply Link', 'required');
			//$this->form_validation->set_rules('editor_heading[]', 'Heading', 'required');
			//$this->form_validation->set_rules('editor_details[]', 'Descriptions', 'required');
			//$this->form_validation->set_rules('job_description', 'Brief Description', 'required');

			//if ($this->form_validation->run() === TRUE) {
			$data_pass = $this->input->post();
			if (!empty($_FILES)) {
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['encrypt_name'] = TRUE;
				$config['overwrite'] = FALSE;
				$config['max_size'] = '500000';

				$this->upload->initialize($config);
				if ($this->upload->do_upload('image')) {
					$fileData = $this->upload->data();
					$data_pass['image'] = $fileData['file_name'];
				}
			}
			$data_pass['slug'] = uniqid(uniqid());
			$count_editor = count($data_pass['editor_heading']);
			$editor_array = [];
			for ($i = 0; $i < $count_editor; $i++) {
				$editor_array[$data_pass['editor_heading'][$i]] = $data_pass['editor_details'][$i];
			}
			$data_pass['all_descriptions'] = json_encode($editor_array);
			unset($data_pass['editor_heading']);
			unset($data_pass['editor_details']);
			//echo "<pre>"; print_r($editor_array); exit;
			$this->db->insert(TBL_CAREER, $data_pass);
			if ($this->db->trans_status()) {
				$data['result'] = array('type' => 'success', 'msg' => 'Opportunity has been added successfully.');
			} else {
				$data['result'] = array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!');
			}
			//} else {
			//$data['result'] = array('type' => 'error', 'msg' => 'Please fill all the fields!');
			//}
		}

		$data['page'] = 'add-opportunity';
		$data['category'] = $this->common->getAll(TBL_CATEGORY, 'id', 'ASC');
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('add-opportunity-new', $data);
		$this->load->view('elements/footer', $data);
	}

	public function opportunity()
	{
		$this->is_login();
		$data['page'] = 'all-opportunities';
		$data['opportunities'] = $this->common->getAll(TBL_CAREER, 'id', 'ASC');
		if ($data['opportunities']) {
			foreach ($data['opportunities'] as $cat) {
				if ($cat->category != 0) {
					$get_category = $this->common->getRowBy(TBL_CATEGORY, 'id', $cat->category);
					if ($get_category) {
						$cat->category = $get_category->title;
					} else {
						$cat->category = '';
					}
				} else {
					$cat->parent = '';
				}
			}
		}
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('opportunities', $data);
		$this->load->view('elements/footer', $data);
	}

	public function opportunity_new()
	{
		$this->is_login();
		$data['page'] = 'all-opportunities';
		$data['opportunities'] = $this->common->getAll(TBL_JOB, 'id', 'ASC');
		// _e($data['opportunities']);exit;
		// if ($data['opportunities']) {
		// 	foreach ($data['opportunities'] as $cat) {
		// 		if ($cat->category != 0) {
		// 			$get_category = $this->common->getRowBy(TBL_CATEGORY, 'id', $cat->category);
		// 			if ($get_category) {
		// 				$cat->category = $get_category->title;
		// 			} else {
		// 				$cat->category = '';
		// 			}
		// 		} else {
		// 			$cat->parent = '';
		// 		}
		// 	}
		// }
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('opportunities_new', $data);
		$this->load->view('elements/footer', $data);
	}

	// public function edit_opprotunity($id)
	// {
	// 	$this->is_login();
	// 	if ($this->input->post()) {
	// 		extract($this->input->post());

	// 		$data_pass = $this->input->post();
	// 		// echo "<pre>"; print_r($data_pass);exit;
	// 		if (!empty($_FILES)) {
	// 			$config['upload_path'] = './uploads/';
	// 			$config['allowed_types'] = 'gif|jpg|png';
	// 			$config['encrypt_name'] = TRUE;
	// 			$config['overwrite'] = FALSE;
	// 			$config['max_size'] = '500000';

	// 			$this->upload->initialize($config);
	// 			if ($this->upload->do_upload('image')) {
	// 				$fileData = $this->upload->data();
	// 				$data_pass['image'] = $fileData['file_name'];
	// 			}
	// 		}
	// 		$count_editor = count($data_pass['editor_heading']);
	// 		$editor_array = [];
	// 		for ($i = 0; $i < $count_editor; $i++) {
	// 			$editor_array[$data_pass['editor_heading'][$i]] = $data_pass['editor_details'][$i];
	// 		}
	// 		$data_pass['all_descriptions'] = json_encode($editor_array);
	// 		unset($data_pass['editor_heading']);
	// 		unset($data_pass['editor_details']);
	// 		$this->db->update(TBL_CAREER, $data_pass, array('id' => $id));
	// 		if ($this->db->trans_status()) {
	// 			$data['result'] = array('type' => 'success', 'msg' => 'Opportunity has been updated successfully.');
	// 		} else {
	// 			$data['result'] = array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!');
	// 		}
	// 	}
	// 	$data['page'] = 'edit-opportunity';
	// 	$data['category'] = $this->common->getAll(TBL_CATEGORY, 'id', 'ASC');
	// 	$data['opportunity'] = $this->common->getRowBy(TBL_CAREER, 'id', $id);
	// 	$this->load->view('elements/header', $data);
	// 	$this->load->view('elements/sidebar', $data);
	// 	$this->load->view('edit-opportunity', $data);
	// 	$this->load->view('elements/footer', $data);
	// }

	public function edit_opprotunity($id)
	{
		$this->is_login();
		if ($this->input->post()) {
			extract($this->input->post());

			$data_pass = $this->input->post();
			// echo "<pre>"; print_r($data_pass);exit;
			if (!empty($_FILES)) {
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['encrypt_name'] = TRUE;
				$config['overwrite'] = FALSE;
				$config['max_size'] = '500000';

				$this->upload->initialize($config);
				if ($this->upload->do_upload('image')) {
					$fileData = $this->upload->data();
					$data_pass['image'] = $fileData['file_name'];
				}
			}
			$count_editor = count($data_pass['editor_heading']);
			$editor_array = [];
			for ($i = 0; $i < $count_editor; $i++) {
				$editor_array[$data_pass['editor_heading'][$i]] = $data_pass['editor_details'][$i];
			}
			$data_pass['all_descriptions'] = json_encode($editor_array);
			unset($data_pass['editor_heading']);
			unset($data_pass['editor_details']);
			$this->db->update(TBL_CAREER, $data_pass, array('id' => $id));
			if ($this->db->trans_status()) {
				$data['result'] = array('type' => 'success', 'msg' => 'Opportunity has been updated successfully.');
			} else {
				$data['result'] = array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!');
			}
		}
		$data['page'] = 'edit-opportunity';
		$data['category'] = $this->common->getAll(TBL_CATEGORY, 'id', 'ASC');
		$data['opportunity'] = $this->common->getRowBy(TBL_JOB, 'id', $id);
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('edit-opportunity-new', $data);
		$this->load->view('elements/footer', $data);
	}

	public function dlt()
	{
		$this->is_login();
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				$id = $this->input->post('id');
				$table = $this->input->post('cat');
				$data = $this->db->delete($table, array('id' => $id));
				// $data = $this->admin->dlt($table, $id);
			}
		}
		$this->output->set_content_type('application/json');
	}

	public function logout()
	{
		$this->session->unset_userdata('admin-login');
		redirect(LOGIN_URL, 'refresh');
	}

	public function page404()
	{
		$this->output->set_status_header('404');
		$this->load->view('404');
	}

	public function import()
	{
		$this->is_login();
		$data['page'] = 'import';
		$all_data = [];

		if (isset($_FILES["file"]["name"])) {
			$path = $_FILES["file"]["tmp_name"];
			$arr_file = explode('.', $_FILES['file']['name']);
			$extension = end($arr_file);
			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} elseif ('xls' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet = $reader->load($_FILES['file']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$row = 1;
			$highestRow = count($sheetData);
			foreach ($sheetData as $worksheet) {
				if ($row >= 4) {
					$checkid = $this->common->getWhere(TBL_JOB, ['requisition_id' => $worksheet[0]], true);
					$insertData = [
						'requisition_id' => $worksheet[0],
						'requisition_title' => $worksheet[1],
						'description_value' => $worksheet[2],
						'justification' => $worksheet[3],
						'org_name' => $worksheet[4],
						'sector_name' => $worksheet[5],
						'division_name' => $worksheet[6],
						'dept_name' => $worksheet[7],
						'recruiter_name' => $worksheet[8],
						'recruiter_email' => $worksheet[9],
						'hiring_manager_name' => $worksheet[10],
						'hiring_manager_email' => $worksheet[11],
						'apply_link' => $worksheet[12],
						'project_title' => $worksheet[13],
						'project_manager_name' => $worksheet[14],
						'project_manager_email' => $worksheet[15],
						'emp_end_date' => $worksheet[16],
						'project_code' => $worksheet[17],
						'project_auth_name' => $worksheet[18],
						'project_auth_email' => $worksheet[19],
						'date_posted' => $worksheet[20],
						'closing_date' => $worksheet[21],
						'datetime' => date('Y-m-d H:i:s')
					];
					if ($checkid) {
						$inserted = $this->common->updateQuery(TBL_JOB, ['requisition_id' => $worksheet[0]], $insertData);
					} else {
						$inserted = $this->db->insert(TBL_JOB, $insertData);
					}
				}
				$row++;
			}
			if ($inserted) {
				echo json_encode(array('error' => false, 'message' => 'Data successfully imported'));
				exit;
			} else {
				echo json_encode(array('error' => true, 'message' => 'Unable to import data. Please try again..!'));
				exit;
			}
		}

		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('import_page', $all_data);
		$this->load->view('elements/footer', $data);
	}

	public function jd_import()
	{
		$this->is_login();
		$data['page'] = 'jd-import';
		$all_data = [];

		if (isset($_FILES["file"]["name"])) {
			$path = $_FILES["file"]["tmp_name"];
			$arr_file = explode('.', $_FILES['file']['name']);
			$extension = end($arr_file);
			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} elseif ('xls' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet = $reader->load($_FILES['file']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$row = 1;
			$highestRow = count($sheetData);
			foreach ($sheetData as $worksheet) {
				if ($row >= 4) {
					$checkid = $this->common->getWhere(TBL_JOB, ['requisition_id' => $worksheet[0]], true);
					if ($checkid) {
						$insertData = [
							'descriptions' => $worksheet[2] . ' ' . $worksheet[3] . ' ' . $worksheet[4] . ' ' . $worksheet[5],
							'qualifications' => $worksheet[6] . ' ' . $worksheet[7] . ' ' . $worksheet[8]
						];
						// _e($insertData);
						$inserted = $this->common->updateQuery(TBL_JOB, ['requisition_id' => $worksheet[0]], $insertData);
					}
				}
				$row++;
			}
			// exit;
			if ($inserted) {
				echo json_encode(array('error' => false, 'message' => 'Data successfully imported'));
				exit;
			} else {
				echo json_encode(array('error' => true, 'message' => 'Unable to import data. Please try again..!'));
				exit;
			}
		}

		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('import_job_desc', $all_data);
		$this->load->view('elements/footer', $data);
	}
}
