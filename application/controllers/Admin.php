<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function user()
    {
        if ($this->session->userdata('userIdPK')) {
            redirect(base_url('Clinic/Home'));
        }
        $this->form_validation->set_rules('userName', 'userName', 'required');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[3]');
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", '</div>');
        if ($this->form_validation->run()) {
            $userName=$this->input->post('userName');
            $password=$this->input->post('password');
            $id=$this->Loginmodel->isValidate($userName, $password);
            if ($id) { //logic pass
                $this->session->set_userdata('userIdPK', $id);
                redirect(base_url('Clinic/Home'));
            } else { //logic fail
                $this->session->set_flashdata('msg', 'Invalid Username / Password');
                $this->session->set_flashdata('alert', 'danger');
                //return redirect(base_url().'login');
                $this->load->view('Users/login');
            }
        } else {
            $this->load->view('Users/login');
        }
    }
    public function register()
    {
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", '</div>');
        $this->form_validation->set_rules('userName', 'userName', 'required|alpha_numeric|is_unique[cdb_tbl_users.userName]');
        $this->form_validation->set_rules('userEmail', 'userEmail', 'required|valid_email|is_unique[cdb_tbl_users.userEmail]');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[3]');
        $this->form_validation->set_rules('confirm_pass', 'confirm_pass', 'required|matches[password]');
        $this->form_validation->set_rules('firstName', 'firstName', 'required|trim|min_length[4]|alpha_numeric_spaces');
        $this->form_validation->set_rules('lastName', 'lastName', 'required|trim|min_length[4]|alpha_numeric_spaces');
        $this->form_validation->set_rules('secretQuestion', 'secretQuestion', 'required|min_length[3]|alpha_numeric_spaces');
        $this->form_validation->set_rules('secretAnswer', 'secretAnswer', 'required|min_length[3]|alpha_numeric_spaces');
        if ($this->form_validation->run()==false) {
            $this->load->view('Users/register');
        } else {
            $post = $this->input->post();
            $post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            unset($post['confirm_pass']);
            if ($this->Loginmodel->addUser($post)) { //logic pass
                $this->session->set_flashdata('msg', 'Registration Successful, you can now Login..');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('login'));
            } else { //logic fail
                $this->session->set_flashdata('msg', 'Invalid Username / Password');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('login'));
            }
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('userIdPK');
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}

