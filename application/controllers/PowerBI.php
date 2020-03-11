<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PowerBI extends MY_Controller {
	
	public function __construct() {
        parent::__construct();
        $this->load->model('PowerBI_Model', 'PowerBI');
	}
	
	public function index() {
		$data['page_title'] = 'Power BI';
        $data['page_subtitle'] = 'Dashboards';
		$data['views'] = ['pages/powerbi/index'];
		$data['pbi'] = $this->get_dashboard_list();

		$this->load->view('site/layout', $data);
	}
	
	public function get_dashboard_list() {
		$data = $this->PowerBI->get_dashboard_list();
		return $data;
	}
   
}