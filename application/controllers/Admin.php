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
					if ($this->session->userdata('stored_redirect_url')) {
						redirect($this->session->userdata('stored_redirect_url'), 'refresh');
					} else {
						redirect(ADMIN_URL . '/dashboard', 'refresh');
					}
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
		$this->session->unset_userdata('stored_redirect_url');
		if ($this->session->userdata('admin-login') !== TRUE) {
			$this->session->set_userdata('stored_redirect_url', current_url());
			redirect(LOGIN_URL, 'refresh');
		}
	}

	public function index()
	{
		$this->is_login();
		if ($this->session->userdata('admin-login') === TRUE) {
			redirect(ADMIN_URL . '/opportunities-temp', 'refresh');
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
			$checkReqID = $this->common->getWhere(TBL_JOB_TEMP, ['requisition_id' => $data_pass['requisition_id'],], true);
			if($checkReqID) {
				if($checkReqID->publish != 'deleted') {
					echo json_encode(array('type' => 'error', 'msg' => 'Requisition ID you have entered is already existing'));
					exit;
				} else {
					$data_pass['publish'] = 'edited';
					$data_pass['datetime'] = date('Y-m-d H:i:s');
					$inserted = $this->common->updateQuery(TBL_JOB_TEMP, array('id' => $checkReqID->id), $data_pass);
					$url = $checkReqID->id;
				}
			} else {
				$data_pass['slug'] = uniqid(uniqid());
				$data_pass['publish'] = 'edited';
				$data_pass['datetime'] = date('Y-m-d H:i:s');
				$inserted = $this->common->insert(TBL_JOB_TEMP, $data_pass);
				$url = $inserted;
			}
			
			$taleoData = [
				'updated_batch' => 'no',
				'updated_method' => 'New post',
				'update_status' => 'New post added with position code '.$data_pass['position_code'],
				'updated_table' => TBL_JOB_TEMP,
				'datetime' => date('Y-m-d H:i:s')
			];
			$this->taleo_updates($taleoData);

			if ($inserted) {
				echo json_encode(array('type' => 'success', 'msg' => 'Opportunity has been added successfully.', 'url' => base_url() . ADMIN_URL . '/edit-opportunity-temp/' . $url));
				exit;
			} else {
				echo json_encode(array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!'));
				exit;
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
		$data['opportunities'] = $this->common->getWhere(TBL_JOB, ['publish' => 'published'], false, 'id DESC');//$this->common->getAll(TBL_JOB, 'id', 'ASC');
		// _e($data['opportunities']);exit;
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
			// $data_pass['position_code'] = $check_req_id->position_code;
			$check_temp_req_id = $this->common->getWhere(TBL_JOB_TEMP, ['id' => $check_req_id->temp_key_id], true);
			$data_pass['slug'] = $check_temp_req_id->slug;
			// _e($check_temp_req_id);exit;

			if($data_pass['status_details'] == 'Posted') {
				$data_pass['publish'] = 'published';
				$this->db->update(TBL_JOB, $data_pass, array('id' => $id));
			} else {
				$data_pass['publish'] = 'edited';
				$this->db->update(TBL_JOB_TEMP, $data_pass, array('id' => $check_temp_req_id->id));
				$this->db->update(TBL_JOB, ['publish' => ''], array('id' => $id));
			}

			if ($this->db->trans_status()) {
				$data['result'] = array('type' => 'success', 'msg' => 'Opportunity has been updated successfully.');
				if($data_pass['status_details'] != 'Posted') {
					$data['url'] = base_url() . ADMIN_URL . '/edit-opportunity-temp/' . $check_temp_req_id->id;
				}
			} else {
				$data['result'] = array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!');
			}

			/*Record Update START*/
			$array1 = (array) $check_temp_req_id; 
			$removedKeyValuePairs = array_diff_assoc($data_pass, $array1);
			if($removedKeyValuePairs) {
				$taleoData = [
					'updated_batch' => 'no',
					'updated_method' => 'Published post edited',
					'update_status' => $data_pass['position_code'].' -> '.implode(", ", array_keys($removedKeyValuePairs)).' has been changed',
					'updated_table' => TBL_JOB_TEMP.', '.TBL_JOB,
					'datetime' => date('Y-m-d H:i:s')
				];
				$this->taleo_updates($taleoData);
			}
			/*Record Update END*/
		}
		$data['page'] = 'edit-opportunity';
		$data['category'] = $this->common->getAll(TBL_CATEGORY, 'id', 'ASC');
		$data['opportunity'] = $this->common->getRowBy(TBL_JOB, 'id', $id);
		$data['temp_opportunity'] = $this->common->getRowBy(TBL_JOB_TEMP, 'id', $id);
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('edit-opportunity-new', $data);
		$this->load->view('elements/footer', $data);
	}

	public function opportunity_temp()
	{
		$this->is_login();
		$data['page'] = 'all-opportunities-temp';
		// $data['opportunities'] = $this->common->getAll(TBL_JOB_TEMP, 'id', 'DESC');
		$data['opportunities'] = $this->common->getWhere(TBL_JOB_TEMP, ['publish !=' => 'published'], false, 'id DESC'); //_e($data['opportunities']);exit;
		foreach($data['opportunities'] as $key => $opo) {
			if($opo->publish == 'deleted') {
				unset($data['opportunities'][$key]);
			}
		}
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
			$data_pass['publish'] = 'edited';
			// $check_req_id = $this->common->getWhere(TBL_JOB, ['requisition_id' => $data_pass['requisition_id']], true);
			$check_temp_req_id = $this->common->getWhere(TBL_JOB_TEMP, ['id' => $id], true);
			$data_pass['slug'] = $check_temp_req_id->slug;
			// $data_pass['position_code'] = $check_temp_req_id->position_code;
			// echo "<pre>"; print_r($data_pass);exit;
			if ($check_temp_req_id) {
				$updated = $this->db->update(TBL_JOB_TEMP, $data_pass, array('id' => $id));
			} else {
				$updated = $this->db->update(TBL_JOB_TEMP, $data_pass, array('id' => $id));
			}
			if ($updated) {
				$array1 = (array) $check_temp_req_id; 
				$removedKeyValuePairs = array_diff_assoc($data_pass, $array1);
				if($removedKeyValuePairs) {
					$taleoData = [
						'updated_batch' => 'no',
						'updated_method' => 'Unpublished post edited',
						'update_status' => $data_pass['position_code'].' -> '.implode(", ", array_keys($removedKeyValuePairs)).' has been changed',
						'updated_table' => TBL_JOB_TEMP,
						'datetime' => date('Y-m-d H:i:s')
					];
					$this->taleo_updates($taleoData);
				}

				if ($data_pass['category'] == "Staff") {
					$email_send = TRUE;
					$user_send_data = [
						['name' => $this->site_config->staff_1, 'email' => $this->site_config->staff_email_1],
						['name' => $this->site_config->staff_2, 'email' => $this->site_config->staff_email_2]
					];
				} else if ($data_pass['category'] == "Faculty") {
					$email_send = TRUE;
					$user_send_data = [
						['name' => $this->site_config->faculty_1, 'email' => $this->site_config->faculty_email_1],
						['name' => $this->site_config->faculty_2, 'email' => $this->site_config->faculty_email_2]
					];
				} else if ($data_pass['category'] == "Research") {
					$email_send = TRUE;
					$user_send_data = [
						['name' => $this->site_config->research_1, 'email' => $this->site_config->research_email_1],
						['name' => $this->site_config->research_2, 'email' => $this->site_config->research_email_2]
					];
				} else {
					$email_send = FALSE;
				}
				// echo "<pre>"; print_r($user_send_data);exit;
				if ($email_send) {
					$create_link = base_url() . 'admin-career/edit-opportunity-temp/'.$id;
					foreach ($user_send_data as $user) {
						$message_data = $this->load->view('email_template', ['url' => $create_link, 'user' => $user], true);
						$result_message = htmlspecialchars_decode(htmlspecialchars($message_data));
						$message = $result_message;
						$to_email = $user['email'];
						$this->load->library('email');
						$this->email->set_newline("\r\n");
						$this->email->from('no-reply@ku.ac.ae'); // change it to yours
						$this->email->to($to_email);
						$this->email->subject('Job Review Session');
						$this->email->message($message);
						$this->email->set_mailtype("html");
						$this->email->send();
					}

					$data['result'] = array('type' => 'success', 'msg' => 'Job has been updated & send for review.');
				} else {
					$data['result'] = array('type' => 'success', 'msg' => 'Job has been updated');
				}
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

	public function publish_opportunity()
	{
		$this->is_login();
		if ($this->input->post()) {
			extract($this->input->post());
			$data_pass = $this->input->post();
			// _e($data_pass);exit;
			$id = $data_pass['id'];
			$req_id = $data_pass['req_id'];
			$pos_code = $data_pass['pos_code'];
			unset($data_pass['id']);
			unset($data_pass['req_id']);
			unset($data_pass['pos_code']);
			$check_req_id = $this->common->getWhere(TBL_JOB, ['temp_key_id' => $id], true);
			$check_temp_req_id = $this->common->getWhere(TBL_JOB_TEMP, ['id' => $id], true);
			$data_pass['slug'] = $check_temp_req_id->slug;
			$data_pass['status_details'] = 'Posted';
			$data_pass['publish'] = 'published';
			
			// echo "<pre>"; print_r($data_pass); exit;
			if ($check_req_id) {
				$updated = $this->db->update(TBL_JOB_TEMP, $data_pass, array('id' => $id));
				$inserted = $this->common->updateQuery(TBL_JOB, array('temp_key_id' => $id), $data_pass);
			} else {
				$check_requisition = $this->common->getWhere(TBL_JOB, ['requisition_id' => $check_temp_req_id->requisition_id], true);
				if($check_requisition) {
					$inserted = $this->common->updateQuery(TBL_JOB, array('id' => $check_requisition->id), array('publish' => $data_pass['publish']));
				} else {
					$data_pass['datetime'] = $check_temp_req_id->datetime;
					$data_pass['temp_key_id'] = $id;
					$inserted = $this->db->insert(TBL_JOB, $data_pass);
				}
				unset($data_pass['temp_key_id']);
				$updated = $this->db->update(TBL_JOB_TEMP, $data_pass, array('id' => $id));
			}

			/*Record Update START*/
			$array1 = (array) $check_req_id; 
			$removedKeyValuePairs = array_diff_assoc($data_pass, $array1);
			if($removedKeyValuePairs) {
				$taleoData = [
					'updated_batch' => 'no',
					'updated_method' => 'Post Published',
					'update_status' => $pos_code.' -> '.implode(", ", array_keys($removedKeyValuePairs)).' has been changed',
					'updated_table' => TBL_JOB_TEMP.', '.TBL_JOB ,
					'datetime' => date('Y-m-d H:i:s')
				];
				$this->taleo_updates($taleoData);
			}
			/*Record Update END*/
			
			if ($inserted) {
				echo json_encode(array('type' => 'success', 'msg' => 'Opportunity has been updated successfully.'));
			} else {
				echo json_encode(array('type' => 'error', 'msg' => 'There is something wrong. Please try again..!'));
			}
		}
	}

	public function dlt()
	{
		$this->is_login();
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				$id = $this->input->post('id');
				$table = $this->input->post('cat');
				$get_data = $this->common->getWhere($table, ['id' => $id], true);
				// _e($table); exit;
				if($table == TBL_JOB) {
					$data = $this->db->delete($table, array('id' => $id));
					$data_temp = $this->db->delete(TBL_JOB_TEMP, array('id' => $get_data->temp_key_id));
				} else if($table == TBL_JOB_TEMP)  {
					// $data = $this->db->delete($table, array('id' => $id));
					$updateQuery = $this->common->updateQuery(TBL_JOB_TEMP, array('id' => $id), array('publish' => 'deleted'));
					// $data_main = $this->db->delete(TBL_JOB, array('temp_key_id' => $get_data->id));
				}
				
				// $data = $this->db->delete($table, array('id' => $id));
				// $data = $this->admin->dlt($table, $id);
				$taleoData = [
					'updated_batch' => 'no',
					'updated_method' => 'Removed post',
					'update_status' => $get_data->position_code.' is removed',
					'updated_table' => $table,
					'datetime' => date('Y-m-d H:i:s')
				];
				$this->taleo_updates($taleoData);
			}
		}
		$this->output->set_content_type('application/json');
	}

	public function publish_post()
	{
		if ($this->input->post()) {
			$formData = $this->input->post();
			$id = $formData['dataid'];
			$check_req_id = $this->common->getWhere(TBL_JOB, ['temp_key_id' => $id], true);
			$get_job_data = $this->common->getWhere(TBL_JOB_TEMP, ['id' => $id], true);
			unset($get_job_data->id);
			// echo "<pre>"; print_r($check_req_id);exit;

			$get_job_data->status_details = 'Posted';
			$get_job_data->publish = 'published';
			$publish_ = 'published';
			if ($check_req_id) {
				$updateQuery = $this->common->updateQuery(TBL_JOB, array('temp_key_id' => $id), $get_job_data);
				$updateQuery = $this->common->updateQuery(TBL_JOB_TEMP, array('id' => $id), array('publish' => $publish_));
			} else {
				$check_requisition = $this->common->getWhere(TBL_JOB, ['requisition_id' => $get_job_data->requisition_id], true);
				if($check_requisition) {
					$updateQuery = $this->common->updateQuery(TBL_JOB, array('id' => $check_requisition->id), array('publish' => $publish_));
				} else {
					$get_job_data->temp_key_id = $id;
					$inserted = $this->db->insert(TBL_JOB, $get_job_data);
				}
				$updateQuery = $this->common->updateQuery(TBL_JOB_TEMP, array('id' => $id), array('publish' => $publish_));
			}
			$taleoData = [
				'updated_batch' => 'no',
				'updated_method' => 'Post Published in temporary updated jobs',
				'update_status' => $get_job_data->position_code.' is published from ALL TEMPORARY UPDATED JOBS table.',
				'updated_table' => TBL_JOB.', '.TBL_JOB_TEMP,
				'datetime' => date('Y-m-d H:i:s')
			];
			$this->taleo_updates($taleoData);
			echo json_encode(['success' => true]);
		}
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
		echo json_encode(array('error' => true, 'message' => 'Not available'));
		exit;
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
		echo json_encode(array('error' => true, 'message' => 'Not available'));
		exit;
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

	public function data_import()
	{
		/* Temporarily terminating this functionality */
		echo "Temporarily Unavailable"; exit;
		$check_import_data_exist = $this->common->getAll(TBL_JOB_TEMP, 'id', 'ASC');
		if($check_import_data_exist) {
			$path = $_SERVER['DOCUMENT_ROOT'] . '/career-opportunities/excel-dump/New_Requisitions.csv';
			$taleoDatainit = [
				'updated_batch' => 'no',
				'updated_method' => 'Cronjob Run',
				'update_status' => 'initial run',
				'updated_table' => 'no table',
				'datetime' => date('Y-m-d H:i:s')
			];
			$this->taleo_updates($taleoDatainit);
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
			$taleoTempArray = [];
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
						$insertData = [
							'position_code' => $worksheet[12],
							'requisition_id' => $worksheet[0], //RequisitionNumber
							'requisition_title' => $worksheet[2], //RequisitionTitle
							'description_value' => $worksheet[1], //RequisitionDescription
							'date_posted' => $worksheet[8], //TargetStartDate
							'status_details' => $worksheet[11], //StatusDetails
							// 'project_code' => $worksheet[10], //PROJECTCODE
							'project_auth_name' => $worksheet[13], //PROJECTAUTHORIZER
							'project_auth_email' => $worksheet[14], //PROJECTAUTHORIZEREMAIL
							'project_manager_name' => $worksheet[16], //PROJECTMANAGER
							'project_manager_email' => $worksheet[17], //PROJECTMANAGEREMAIL
							'descriptions' => $worksheet[19], //DescriptionExternalHTML
							'qualifications' => $worksheet[21],
							'closing_date' => $worksheet[23], //COMPLETION_DATE
							'hiring_manager_name' => $worksheet[24] . ' ' . $worksheet[25], //HiringManagerFirstName + HiringManagerLastName
							'hiring_manager_email' => $worksheet[27], //HiringManagerEmail
							'recruiter_name' => $worksheet[28] . ' ' . $worksheet[29], //RecruiterFirstName + RecruiterLastName
							'recruiter_email' => $worksheet[30], //RecruiterEmail
							'org_name' => $worksheet[33], //Organization
							'sector_name' => $worksheet[34], //Sector
							'division_name' => $worksheet[35], //Division
							'dept_name' => $worksheet[36], //Department
							'apply_link' => $apply_link,
							'publish' => '',
							'slug' => $slug,
							'category' => $worksheet[4], //Category
							'college' => (strpos(strtolower($worksheet[36]), 'college') !== false) ? $worksheet[36] : '',
							'datetime' => date('Y-m-d H:i:s')
						];
						
						$tempData = '';
						if ($checkid) {
							$check_main_job = $this->common->getWhere(TBL_JOB, ['requisition_id' => $worksheet[0]], true);
							if($worksheet[11] != 'Posted') {
								if($check_main_job) {
									$this->common->updateQuery(TBL_JOB, ['requisition_id' => $worksheet[0]], ['publish' => '']);
								}
							} else {
								if($check_main_job) {
									$this->common->updateQuery(TBL_JOB, ['requisition_id' => $worksheet[0]], ['publish' => 'published']);
								}
							}
							$inserted = $this->common->updateQuery(TBL_JOB_TEMP, ['requisition_id' => $worksheet[0]], $insertData);

							$array1 = (array) $checkid; 
							$removedKeyValuePairs = array_diff_assoc($insertData, $array1);
							if($removedKeyValuePairs) {
								$tempData = $insertData['requisition_id'].' -> '.implode(", ", array_keys($removedKeyValuePairs)).' has been changed => Post updated';
							}
						} else {
								$inserted = $this->db->insert(TBL_JOB_TEMP, $insertData);
								$tempData = $insertData['requisition_id'].' has been added to unpublished jobs => Newly added post';
						}
						if($tempData) {
							array_push($taleoTempArray, $tempData);
						}
					}
				}
				$row++;
			}
			if($taleoTempArray) {
				$dataUpdate = serialize($taleoTempArray);
				$taleoData = [
					'updated_batch' => 'yes',
					'updated_method' => 'Taleo update',
					'update_status' => $dataUpdate,
					'updated_table' => TBL_JOB.', '.TBL_JOB_TEMP,
					'datetime' => date('Y-m-d H:i:s')
				];
				$this->taleo_updates($taleoData);
			}
			
			if ($inserted) {
				$taleoDataFinal = [
					'updated_batch' => 'no',
					'updated_method' => 'Cronjob End',
					'update_status' => 'Finish run',
					'updated_table' => 'no table',
					'datetime' => date('Y-m-d H:i:s')
				];
				$this->taleo_updates($taleoDataFinal);
				echo json_encode(array('error' => false, 'message' => 'Data successfully imported'));
				exit;
			} else {
				echo json_encode(array('error' => true, 'message' => 'Unable to import data. Please try again..!'));
				exit;
			}
		} else {
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

						$insertData = [
							'position_code' => $worksheet[10],
							'requisition_id' => $worksheet[0], //RequisitionNumber
							'requisition_title' => $worksheet[2], //RequisitionTitle
							'description_value' => $worksheet[1], //RequisitionDescription
							'date_posted' => $worksheet[6], //TargetStartDate
							'status_details' => $worksheet[9], //StatusDetails
							// 'project_code' => $worksheet[10], //PROJECTCODE
							'project_auth_name' => $worksheet[11], //PROJECTAUTHORIZER
							'project_auth_email' => $worksheet[12], //PROJECTAUTHORIZEREMAIL
							'project_manager_name' => $worksheet[14], //PROJECTMANAGER
							'project_manager_email' => $worksheet[15], //PROJECTMANAGEREMAIL
							'descriptions' => $worksheet[17], //DescriptionExternalHTML
							'closing_date' => ($worksheet[19]) ? substr($worksheet[19], 0, strpos($worksheet[19], "T")) : '', //COMPLETION_DATE
							'hiring_manager_name' => $worksheet[20] . ' ' . $worksheet[21], //HiringManagerFirstName + HiringManagerLastName
							'hiring_manager_email' => $worksheet[23], //HiringManagerEmail
							'recruiter_name' => $worksheet[24] . ' ' . $worksheet[25], //RecruiterFirstName + RecruiterLastName
							'recruiter_email' => $worksheet[26], //RecruiterEmail
							'org_name' => $worksheet[29], //Organization
							'sector_name' => $worksheet[30], //Sector
							'division_name' => $worksheet[31], //Division
							'dept_name' => $worksheet[32], //Department
							'apply_link' => $apply_link,
							'publish' => ($worksheet[9] == 'Posted') ? 'published' : '',
							'slug' => $slug,
							'category' => $worksheet[4], //Category
							'college' => (strpos(strtolower($worksheet[32]), 'college') !== false) ? $worksheet[32] : '',
							'datetime' => date('Y-m-d H:i:s')
						];
						if ($checkid) {
							$inserted = $this->common->updateQuery(TBL_JOB_TEMP, ['requisition_id' => $worksheet[0]], $insertData);
						} else {
							$inserted = $this->db->insert(TBL_JOB_TEMP, $insertData);	
						}
						$checkNewTable = $this->common->getWhere(TBL_JOB, ['requisition_id' => $worksheet[0]], true);
						if($worksheet[9] == 'Posted') {
							if($checkNewTable) {
								$inserted_2 = $this->common->updateQuery(TBL_JOB, ['requisition_id' => $worksheet[0]], $insertData);
							} else {
								$inserted_2 = $this->db->insert(TBL_JOB, $insertData);
							}
						}
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
	}

	public function data_import_new()
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
						'position_code' => $worksheet[10],
						'requisition_id' => $worksheet[0], //RequisitionNumber
						'requisition_title' => $worksheet[2], //RequisitionTitle
						'description_value' => $worksheet[1], //RequisitionDescription
						'date_posted' => $worksheet[6], //TargetStartDate
						'status_details' => $worksheet[8], //StatusDetails
						// 'project_code' => $worksheet[10], //PROJECTCODE
						'project_auth_name' => $worksheet[11], //PROJECTAUTHORIZER
						'project_auth_email' => $worksheet[12], //PROJECTAUTHORIZEREMAIL
						'project_manager_name' => $worksheet[14], //PROJECTMANAGER
						'project_manager_email' => $worksheet[15], //PROJECTMANAGEREMAIL
						'descriptions' => $worksheet[17], //DescriptionExternalHTML
						'closing_date' => $worksheet[19], //COMPLETION_DATE
						'hiring_manager_name' => $worksheet[20] . ' ' . $worksheet[21], //HiringManagerFirstName + HiringManagerLastName
						'hiring_manager_email' => $worksheet[23], //HiringManagerEmail
						'recruiter_name' => $worksheet[24] . ' ' . $worksheet[25], //RecruiterFirstName + RecruiterLastName
						'recruiter_email' => $worksheet[26], //RecruiterEmail
						'org_name' => $worksheet[29], //Organization
						'sector_name' => $worksheet[30], //Sector
						'division_name' => $worksheet[31], //Division
						'dept_name' => $worksheet[32], //Department
						'apply_link' => $apply_link,
						'publish' => '',
						'slug' => $slug,
						'category' => $worksheet[4], //Category
						'college' => (strpos(strtolower($worksheet[32]), 'college') !== false) ? $worksheet[32] : '',
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

	protected function taleo_updates($insertData) {
		// $taleoData = [
		// 	'updated_batch' => '',
		// 	'updated_method' => '',
		// 	'update_status' => '',
		// 	'updated_table' => '',
		// 	'datetime' => date('Y-m-d H:i:s')
		// ];
		$inserted = $this->db->insert(TBL_TALEO, $insertData);
	}

	public function post_updates() {
		$this->is_login();
		$data['page'] = 'post-updates';
		$data['updates'] = $this->common->getAll(TBL_TALEO, 'id', 'DESC');
		// _e($data);
		$this->load->view('elements/header', $data);
		$this->load->view('elements/sidebar', $data);
		$this->load->view('post_updates', $data);
		$this->load->view('elements/footer', $data);
	}

	public function manual_import()
	{
			$path = $_SERVER['DOCUMENT_ROOT'] . '/career-opportunities/excel-dump/New_Requisitions.csv';
			$taleoDatainit = [
				'updated_batch' => 'no',
				'updated_method' => 'Manual Run',
				'update_status' => 'initial run',
				'updated_table' => 'no table',
				'datetime' => date('Y-m-d H:i:s')
			];
			$this->taleo_updates($taleoDatainit);
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
			$taleoTempArray = [];
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
							'position_code' => $worksheet[12],
							'requisition_id' => $worksheet[0], //RequisitionNumber
							'requisition_title' => $worksheet[2], //RequisitionTitle
							'description_value' => $worksheet[1], //RequisitionDescription
							'date_posted' => $worksheet[8], //TargetStartDate
							'status_details' => $worksheet[11], //StatusDetails
							// 'project_code' => $worksheet[10], //PROJECTCODE
							'project_auth_name' => $worksheet[13], //PROJECTAUTHORIZER
							'project_auth_email' => $worksheet[14], //PROJECTAUTHORIZEREMAIL
							'project_manager_name' => $worksheet[16], //PROJECTMANAGER
							'project_manager_email' => $worksheet[17], //PROJECTMANAGEREMAIL
							'descriptions' => $worksheet[19], //DescriptionExternalHTML
							'qualifications' => $worksheet[21],
							'closing_date' => $worksheet[23], //COMPLETION_DATE
							'hiring_manager_name' => $worksheet[24] . ' ' . $worksheet[25], //HiringManagerFirstName + HiringManagerLastName
							'hiring_manager_email' => $worksheet[27], //HiringManagerEmail
							'recruiter_name' => $worksheet[28] . ' ' . $worksheet[29], //RecruiterFirstName + RecruiterLastName
							'recruiter_email' => $worksheet[30], //RecruiterEmail
							'org_name' => $worksheet[33], //Organization
							'sector_name' => $worksheet[34], //Sector
							'division_name' => $worksheet[35], //Division
							'dept_name' => $worksheet[36], //Department
							'apply_link' => $apply_link,
							'publish' => '',
							'slug' => $slug,
							'category' => $worksheet[4], //Category
							'college' => (strpos(strtolower($worksheet[36]), 'college') !== false) ? $worksheet[36] : '',
							'datetime' => date('Y-m-d H:i:s')
						];
						// echo "<pre>"; print_r($checkid); exit;
						$tempData = '';
						if ($checkid) {
							$check_main_job = $this->common->getWhere(TBL_JOB, ['requisition_id' => $worksheet[0]], true);
							if($worksheet[11] != 'Posted') {
								if($check_main_job) {
									$this->common->updateQuery(TBL_JOB, ['requisition_id' => $worksheet[0]], ['publish' => '']);
								}
							} else {
								if($check_main_job) {
									$this->common->updateQuery(TBL_JOB, ['requisition_id' => $worksheet[0]], ['publish' => 'published']);
								}
							}
							$inserted = $this->common->updateQuery(TBL_JOB_TEMP, ['requisition_id' => $worksheet[0]], $insertData);

							$array1 = (array) $checkid; 
							$removedKeyValuePairs = array_diff_assoc($insertData, $array1);
							if($removedKeyValuePairs) {
								$tempData = $insertData['requisition_id'].' => '.implode(", ", array_keys($removedKeyValuePairs)).' has been changed => Post updated';
							}
						} else {
							$inserted = $this->db->insert(TBL_JOB_TEMP, $insertData);
							$tempData = $insertData['requisition_id'].' has been added to unpublished jobs => Newly added post';
						}
						if($tempData) {
							array_push($taleoTempArray, $tempData);
						}
					}
				}
				$row++;
			}
			$dataUpdate = serialize($taleoTempArray);
			$taleoData = [
				'updated_batch' => 'yes',
				'updated_method' => 'Taleo update',
				'update_status' => $dataUpdate,
				'updated_table' => TBL_JOB.', '.TBL_JOB_TEMP,
				'datetime' => date('Y-m-d H:i:s')
			];
			$this->taleo_updates($taleoData);
			if ($inserted) {
				$taleoDataFinal = [
					'updated_batch' => 'no',
					'updated_method' => 'Manual run End',
					'update_status' => 'Finish run',
					'updated_table' => 'no table',
					'datetime' => date('Y-m-d H:i:s')
				];
				$this->taleo_updates($taleoDataFinal);
				echo json_encode(array('error' => false, 'message' => 'Data successfully imported'));
				exit;
			} else {
				echo json_encode(array('error' => true, 'message' => 'Unable to import data. Please try again..!'));
				exit;
			}
	}

	public function checkJob() {
		if ($this->input->post()) {
			extract($this->input->post());
			// echo $datavalue;
			$checkReqID = $this->common->getWhere(TBL_JOB_TEMP, ['requisition_id' => $datavalue, 'publish !=' => 'deleted'], false);
			if($checkReqID) {
				echo json_encode(array('type' => 'error', 'msg' => 'Requisition ID you have entered is already existing'));
				exit;
			}
		}
	}
}