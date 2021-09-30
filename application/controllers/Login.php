<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('userIdPK')) {
            return redirect(base_url('Clinic/Home'));
        }
    }
    public function index()
    {
        $this->load->view('Users/login');
        $this->load->view('Template/footer');
    }
    public function register()
    {
        $this->load->view('Users/Register');
        $this->load->view('Template/footer');
    }
}
