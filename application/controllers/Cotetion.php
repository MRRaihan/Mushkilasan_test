<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Cotetion extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['model'] = 'cotetion';
        $this->load->model('cotetion_model','cotetion');
		 //$this->load->model('user_login_model','user');
		$this->load->model('common_model','common_model');
        $this->data['base_url'] = base_url();
        $this->load->helper('user_timezone');
		$this->data['user_role']=$this->session->userdata('role');
    }

// 	public function index()
// 	{
//     // $this->data['cotetion'] = 'cotetion';
//      // $this->data['payment']= $this->dashboard->get_payments_info();
//   		$this->load->vars($this->data);
//   		$this->load->view($this->data['theme'].'/template');
	

// 	}
  

// public function index() {
//         $data['title'] = 'Cotetion';
     
//         // $data['top_bar'] = "dashboard/top_bar.php";
//         // $data['left_side_bar'] = "dashboard/left_side_bar.php";
//         // $data['footer'] = "dashboard/footer.php";
//         // $data['body_content'] = "dashboard/body_content.php";
//          $data['cotetion_view'] = "user/cotetion_view.php";
//       $this->load->vars($this->data);
//       $this->load->view($this->data['theme'].'/template');
//     }
 
 

  public function index() {
    //     $data['title'] = 'Dashboard';
    //   $data['session_user'] = $this->session_user;
    //     $data['top_bar'] = "dashboard/top_bar.php";
    //     $data['left_side_bar'] = "dashboard/left_side_bar.php";
    //     $data['footer'] = "dashboard/footer.php";
       $data['cotetion_view'] = "user/cotetion_view.php";
$this->load->vars($this->data);
        $this->load->view('admin/template', $data);
    }
 

 






//



}

?>
