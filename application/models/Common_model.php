<?php
date_default_timezone_set('Asia/Dubai');

if (!isset($_SESSION)) {
    session_start();
}

class Common_model extends CI_Model {

    public function __construct() {
        $this->load->database();
        $this->load->library('pagination');
    }

    function url($url) {
        $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
        $url = trim($url, "-");
        $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
        $url = strtolower($url);
        $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
        return $url;
    }

    public function getAll($table, $order_by, $order, $limit = null, $offset = null) {
        $query = $this->db->order_by($order_by, $order)->get($table, $limit, $offset);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getAllBy($table, $by, $value, $order_by, $order, $limit = null, $offset = null) {
        $query = $this->db->order_by($order_by, $order)->get_where($table, array($by => $value), $limit, $offset);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getAllByMulty($table, $array, $order_by, $order, $limit = null, $offset = null) {
        $query = $this->db->order_by($order_by, $order)->get_where($table, $array, $limit, $offset);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getRowBy($table, $by, $value, $limit = null, $offset = null) {
        $query = $this->db->get_where($table, array($by => $value), $limit, $offset);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function getRowByMulty($table, $array, $limit = null, $offset = null) {
        $query = $this->db->get_where($table, $array, $limit, $offset);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function image_resize($newPath, $fullpath, $thumb_marker, $width, $height, $master_dim) {
        $this->load->library('image_lib');

//  upload an image options

        $config['image_library'] = 'gd2';
        $config['new_image'] = $newPath;
        $config['source_image'] = $fullpath;
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = $thumb_marker;
//        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['master_dim'] = $master_dim;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        $this->image_lib->clear();
        unset($config);
    }

    public function getResizedImage($image, $rename) {
        $explode = explode('.', $image);
        $image_name = $explode[0];
        $ext = $explode[1];

        return $image_name . $rename . '.' . $ext;
    }

    public function dateFormatChange($format, $value) {
        $myDateTime = DateTime::createFromFormat('Y-m-d', $value);
        $formattedweddingdate = $myDateTime->format($format);
        return $formattedweddingdate;
    }

    public function createPagination($url, $rows, $per_page, $uri_segment) {
//echo $uri_segment; exit();
        $config['base_url'] = base_url() . $url . '/page';
        $config['total_rows'] = $rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $uri_segment;
        $config['use_page_numbers'] = TRUE;

        $config['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }

    public function getPageNum($perameter) {
        $explode = explode('-', $perameter);
        return $explode[1];
    }

    public function get_tiny_url($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function updateQuery($table, $whereClauseArray, $valueArray, $whereInClauseArray = null)
    {
        if (!is_null($whereClauseArray)) {
            $this->db->where($whereClauseArray);
        }
        if (!is_null($whereInClauseArray)) {
            $this->db->where_in($whereInClauseArray['column'], $whereInClauseArray['values']);
        }
        $this->db->update($table, $valueArray);
        return ($this->db->trans_status()) ? true : false;
    }

    public function updateAllQuery($table, $columnName, $valueArray, $whereClauseArray = null)
    {
        if (!is_null($whereClauseArray)) {
            $this->db->where($whereClauseArray);
        }
        $this->db->update_batch($table, $valueArray, $columnName);
        return ($this->db->trans_status()) ? true : false;
    }

    public function getWhere($table, $whereClauseArray, $rowFormat = false, $sortOrder = 'id ASC', $limit = null, $offset = null)
    {
        $this->db->order_by($sortOrder);
        $query = $this->db->get_where($table, $whereClauseArray, $limit, $offset);
        return ($query->num_rows() > 0) ? (($rowFormat) ? $query->row() : $query->result()) : false;
    }

    public function check_alumni_emirates($table, $id) {
        $query = $this->db->query("SELECT * FROM $table WHERE REPLACE (emirates_id, '-', '') in ('$id')");
        return $query->row();
    }

}
