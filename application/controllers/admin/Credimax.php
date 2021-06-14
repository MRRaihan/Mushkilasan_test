<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Credimax extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
       $this->data['theme'] = 'admin';
     $this->data['model'] = 'dashboard';
  $this->load->model('dashboard_model','dashboard');
		 $this->load->model('user_login_model','user');
	//	$this->load->model('common_model','common_model');
        $this->data['base_url'] = base_url();
        $this->load->helper('user_timezone');
		$this->data['user_role']=$this->session->userdata('role');
    }

	public function index()
	{
      $this->data['page'] = 'index';
     // $this->data['payment']= $this->dashboard->get_payments_info();
  		$this->load->vars($this->data);
  		$this->load->view($this->data['theme'].'/template');
	  $this->load->view('admin/settings/credimax_payment_gateway');

	}
  
//paramesh code

//



}

?>
