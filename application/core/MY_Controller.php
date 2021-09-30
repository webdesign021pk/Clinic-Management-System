<?php
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userIdPK')) {
            return redirect(base_url().'login');
        }
		date_default_timezone_set('Asia/Karachi');
        $userDetail=$this->Loginmodel->userDetail();
        $this->load->view('Template/header', compact('userDetail'));
        $this->form_validation->set_error_delimiters("<div class='text-danger' style='font-size:0.7em'>", '</div>');
    }
}
