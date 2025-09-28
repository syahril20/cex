<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * (No code provided in the selection.)
 * @property CI_DB $db
 * @property CI_Session $session
 * @property User_model $User_model
 * @property JwtAuth $jwtauth
 * @property CI_Input $input
 * Please provide the code selection you want documented.
 */
class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('JwtAuth');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 * 
	 */
	public function index()
	{

		// var_dump(getenv('DB_HOST'));
		// var_dump($_ENV['DB_HOST']);
		// echo "<script>console.log('Debug: ', " . getenv('DB_HOST') . ");</script>";
		// echo "<script>console.log('Debug: ', " . $_ENV['DB_HOST'] . ");</script>";


		$this->jwtauth->check_token();
		$session = $this->session->userdata();

		if (!isset($session['user']) || $session['user'] == null) {
			redirect('auth/login_form');
			return;
		}

		$user = $session['user'];
		$data['session'] = $session;
		$data['page'] = 'Dashboard';
		if ($user->code == 'SUPER_ADMIN') {
			$this->load->view('superadmin/superadmin_dashboard');
		}
		if ($user->code == 'ADMIN') {
			$this->load->view('admin/admin_dashboard');
		}
		if ($user->code == 'AGENT') {
			$this->load->view('base_page', ['data' => $data]);
		}
	}
}
