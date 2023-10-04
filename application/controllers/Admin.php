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

			if ($this->form_validation->run() === TRUE) {
				$data_pass = compact("title");
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

			if ($this->form_validation->run() === TRUE) {
				$data_pass = compact("title");
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

			$data_pass = $this->input->post(); //echo "<pre>"; print_r($data_pass);exit;
			$data_pass['slug'] = uniqid(uniqid());

			$this->db->insert(TBL_JOB, $data_pass);
			if ($this->db->trans_status()) {
				$data['result'] = array('type' => 'success', 'msg' => 'Opportunity has been added successfully.');
			} else {
				$data['result'] = array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!');
			}
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

	public function edit_opprotunity($id)
	{
		$this->is_login();
		if ($this->input->post()) {
			extract($this->input->post());

			$data_pass = $this->input->post();
			$check_req_id = $this->common->getWhere(TBL_JOB, ['id' => $id], true);
			$check_temp_req_id = $this->common->getWhere(TBL_JOB_TEMP, ['requisition_id' => $data_pass['requisition_id']], true);
			$data_pass['slug'] = $check_temp_req_id->slug;
			// echo "<pre>"; print_r($data_pass);exit;
			$this->db->update(TBL_JOB, $data_pass, array('id' => $id));
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
						'category' => $worksheet[22],
						'college' => $worksheet[23],
						'slug' => uniqid(uniqid()),
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
		// _e($_FILES);
		if (isset($_FILES["file"]["name"])) { //_e($_FILES["file"]["name"]);exit;
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
				if ($row >= 2) {
					$checkid = $this->common->getWhere(TBL_JOB, ['requisition_id' => $worksheet[0]], true);
					if ($checkid) {
						$insertData = [
							'descriptions' => $worksheet[3], //$worksheet[2].' '.$worksheet[3].' '.$worksheet[4].' '.$worksheet[5],
							'qualifications' => $worksheet[4] //$worksheet[6].' '.$worksheet[7].' '.$worksheet[8].' '.$worksheet[9]
						];
						// _e($insertData);
						$inserted = $this->common->updateQuery(TBL_JOB, ['requisition_id' => $worksheet[0]], $insertData);
					}
				}
				$row++;
			}
			// exit;
			if (isset($inserted)) {
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

	// public function publish_post() {
	// 	if ($this->input->post()) {
	// 		$formData = $this->input->post();
	// 		$updateQuery = $this->common->updateQuery(TBL_JOB, array('id' => $formData['dataid']), array('publish' => 'published'));
	// 		echo json_encode(['success' => true]);
	// 	}
	// }

	public function publish_post()
	{
		if ($this->input->post()) {
			$formData = $this->input->post();
			$check_req_id = $this->common->getWhere(TBL_JOB, ['requisition_id' => $formData['dataid']], true);
			$get_job_data = $this->common->getWhere(TBL_JOB_TEMP, ['requisition_id' => $formData['dataid']], true);
			unset($get_job_data->id);
			$get_job_data->publish = 'published';
			// _e($get_job_data);exit;
			if ($check_req_id) {
				$updateQuery = $this->common->updateQuery(TBL_JOB, array('requisition_id' => $formData['dataid']), $get_job_data);
				$updateQuery = $this->common->updateQuery(TBL_JOB_TEMP, array('requisition_id' => $formData['dataid']), array('publish' => 'published'));
			} else {
				$inserted = $this->db->insert(TBL_JOB, $get_job_data);
				$updateQuery = $this->common->updateQuery(TBL_JOB_TEMP, array('requisition_id' => $formData['dataid']), array('publish' => 'published'));
			}
			echo json_encode(['success' => true]);
		}
	}

	public function data_import()
	{
		// echo $_SERVER['DOCUMENT_ROOT'].'/wordpress-test/career-opportunities/excel-dump/jobs_file.csv';exit;
		$path = $_SERVER['DOCUMENT_ROOT'] . '/career-opportunities/excel-dump/Requisitions.csv'; //$_SERVER['DOCUMENT_ROOT'].'/wordpress-test/career-opportunities/excel-dump/jobs_file.xlsx';
		$arr_file = explode('.', $path);
		$extension = end($arr_file);
		if ('csv' == $extension) {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} elseif ('xls' == $extension) {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}
		$spreadsheet = $reader->load($path);
		$sheetData = $spreadsheet->getActiveSheet()->toArray();
		$row = 1;
		$highestRow = count($sheetData); //_e($sheetData);exit;
		foreach ($sheetData as $worksheet) {
			if ($row > 1) {
				if (strtolower($worksheet[4]) == 'hourly') {
					$worksheet[4] = 'Staff';
				} else if (strtolower($worksheet[4]) == 'professional') {
					$worksheet[4] = 'Faculty';
				} else if (strtolower($worksheet[4]) == 'executives') {
					$worksheet[4] = 'Research';
				}
				// if(strtolower($worksheet[31]) != 'temp researcher internal fund' && strtolower($worksheet[31]) != 'temp researcher external fund') {
				$apply_link = 'https://careers.ku.ac.ae/careersection/application.jss?lang=en&type=1&csNo=10060&portal=8116755942&reqNo=' . $worksheet[0] . '&isOnLogoutPage=true';
				$checkid = $this->common->getWhere(TBL_JOB_TEMP, ['requisition_id' => $worksheet[0]], true);
				if ($checkid && $checkid->slug) {
					$slug = $checkid->slug;
				} else {
					$slug = uniqid(uniqid());
				}
				if ($worksheet[0] == strip_tags($worksheet[0])) {

					// HasBeenApproved => $worksheet[5]
					$insertData = [
						'requisition_id' => $worksheet[0], //RequisitionNumber
						'requisition_title' => $worksheet[2], //RequisitionTitle
						'description_value' => $worksheet[1], //RequisitionDescription
						'date_posted' => $worksheet[6], //TargetStartDate
						'status_details' => $worksheet[8], //StatusDetails
						'project_code' => $worksheet[9], //PROJECTCODE
						'project_auth_name' => $worksheet[10], //PROJECTAUTHORIZER
						'project_auth_email' => $worksheet[11], //PROJECTAUTHORIZEREMAIL
						'project_manager_name' => $worksheet[13], //PROJECTMANAGER
						'project_manager_email' => $worksheet[14], //PROJECTMANAGEREMAIL
						'descriptions' => $worksheet[16], //DescriptionExternalHTML
						'closing_date' => $worksheet[18], //COMPLETION_DATE
						'hiring_manager_name' => $worksheet[19] . ' ' . $worksheet[20], //HiringManagerFirstName + HiringManagerLastName
						'hiring_manager_email' => $worksheet[22], //HiringManagerEmail
						'recruiter_name' => $worksheet[23] . ' ' . $worksheet[24], //RecruiterFirstName + RecruiterLastName
						'recruiter_email' => $worksheet[25], //RecruiterEmail
						'org_name' => $worksheet[28], //Organization
						'sector_name' => $worksheet[29], //Sector
						'division_name' => $worksheet[30], //Division
						'dept_name' => $worksheet[31], //Department
						'apply_link' => $apply_link,
						'publish' => '',
						'slug' => $slug,
						'category' => $worksheet[4], //Category
						'college' => (strpos(strtolower($worksheet[31]), 'college') !== false) ? $worksheet[31] : '',
						'datetime' => date('Y-m-d H:i:s')
					];
					if ($checkid) {
						$inserted = $this->common->updateQuery(TBL_JOB_TEMP, ['requisition_id' => $worksheet[0]], $insertData);
					} else {
						$inserted = $this->db->insert(TBL_JOB_TEMP, $insertData);
					}
				}
				// _e($insertData);
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

	public function opportunity_temp()
	{
		$this->is_login();
		$data['page'] = 'all-opportunities-temp';
		$data['opportunities'] = $this->common->getWhere(TBL_JOB_TEMP, ['publish' => '']); //_e($data['opportunities']);exit;
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('opportunities_temp', $data);
		$this->load->view('elements/footer', $data);
	}

	public function edit_opprotunity_temp($id)
	{
		$this->is_login();
		if ($this->input->post()) {
			extract($this->input->post());

			$data_pass = $this->input->post();
			$data_pass['publish'] = 'published';
			$check_req_id = $this->common->getWhere(TBL_JOB, ['requisition_id' => $data_pass['requisition_id']], true);
			$check_temp_req_id = $this->common->getWhere(TBL_JOB_TEMP, ['requisition_id' => $data_pass['requisition_id']], true);
			$data_pass['slug'] = $check_temp_req_id->slug;
			// echo "<pre>"; print_r($data_pass);exit;
			if($check_req_id) {
				$updated = $this->db->update(TBL_JOB_TEMP, $data_pass, array('id' => $id));
				$inserted = $this->common->updateQuery(TBL_JOB, array('requisition_id' => $data_pass['requisition_id']), $data_pass);
			} else {
				$updated = $this->db->update(TBL_JOB_TEMP, $data_pass, array('id' => $id));
				$inserted = $this->db->insert(TBL_JOB, $data_pass);
			}
			if ($inserted) {
				$data['result'] = array('type' => 'success', 'msg' => 'Opportunity has been updated successfully.');
			} else {
				$data['result'] = array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!');
			}
		}
		$data['page'] = 'edit-opportunity-temp';
		$data['category'] = $this->common->getAll(TBL_CATEGORY, 'id', 'ASC');
		$data['opportunity'] = $this->common->getRowBy(TBL_JOB_TEMP, 'id', $id);
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('edit-opportunity-new', $data);
		$this->load->view('elements/footer', $data);
	}
}