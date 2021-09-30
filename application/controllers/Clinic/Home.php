<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $totalDoctors=$this->Staffmodel->totalDoctors();
        $totalPatients=$this->Patientmodel->totalPatients();
        $appointments=$this->Patientmodel->totalAppointments();
        $todaysAppointments=$this->Patientmodel->todaysAppointments();
        $todaysAppointmentsList=$this->Patientmodel->todaysAppointmentsList($_SESSION['doctorId']);
        $patients = $this->Patientmodel->patientList('patientIdPK, p_firstName, p_lastName');
        $this->load->view('Clinic/Dashboard',  compact('totalDoctors', 'totalPatients', 'patients', 'appointments', 'todaysAppointments', 'todaysAppointmentsList'));
        $this->load->view('Template/footer');
    }


    /*Profile Settings*/
    public function profile()
    {
        $id=$this->session->userdata('userIdPK');
        $user=$this->Loginmodel->userProfile($id);
        if (empty($_POST)) {
            $this->load->view('Users/profile', compact('user'));
            $this->load->view('Template/footer');
        }
        if (isset($_POST['userEmail'])) {
            if ($this->form_validation->run('profile_email_rule')==false) {
                $this->load->view('Users/profile',compact('user'));
                $this->load->view('Template/footer');
            } else {
                $post = $this->input->post();
                $post = $this->security->xss_clean($post);
                if ($this->Loginmodel->modifyUser($id, $post)) {
                    $this->session->set_flashdata('msg', 'User modified successfully!');
                    $this->session->set_flashdata('alert', 'success');
                    redirect(base_url('Clinic/Home/profile'));
                } else {
                    $this->session->set_flashdata('msg', 'Failed to Modify User, Contact Administrator!!');
                    $this->session->set_flashdata('alert', 'danger');
                    redirect(base_url('Clinic/Home/profile'));
                }
            }
        }
        if (isset($_POST['userName'])) {
            if ($this->form_validation->run('profile_userName_rule')==false) {
                $this->load->view('Users/profile',compact('user'));
                $this->load->view('Template/footer');
            } else {
                $post=$this->input->post();
                $post = $this->security->xss_clean($post);
                if ($this->Loginmodel->modifyUser($id, $post)) {
                    $this->session->set_flashdata('msg', 'User modified successfully!');
                    $this->session->set_flashdata('alert', 'success');
                    redirect(base_url('Clinic/Home/profile'));
                } else {
                    $this->session->set_flashdata('msg', 'Failed to Modify User, Contact Administrator!!');
                    $this->session->set_flashdata('alert', 'danger');
                    redirect(base_url('Clinic/Home/profile'));
                }
            }
        }
        if (isset($_POST['others'])) {
            unset($_POST['others']);
            if ($this->form_validation->run('profile_fields_rule')==false) {
                //$user=$this->Loginmodel->userProfile($id);
                $this->load->view('Users/profile', compact('user'));
                $this->load->view('Template/footer');
            } else {
                $post=$this->input->post();
                print_r($post);
                $post = $this->security->xss_clean($post);
                if ($this->Loginmodel->modifyUser($id, $post)) {
                    $this->session->set_flashdata('msg', 'User modified successfully!');
                    $this->session->set_flashdata('alert', 'success');
                    redirect(base_url('Clinic/Home/profile'));
                } else {
                    $this->session->set_flashdata('msg', 'Failed to Modify User, Contact Administrator!!');
                    $this->session->set_flashdata('alert', 'danger');
                    redirect(base_url('Clinic/Home/profile'));
                }
            }
        }
    }
    public function modifyPass()
    {
        $id=$this->session->userdata('userIdPK');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[3]');
        $this->form_validation->set_rules('confirm_pass', 'confirm_pass', 'required|matches[password]');
        if ($this->form_validation->run()==false) {
            $user=$this->Loginmodel->userProfile($id);
            $this->load->view('Users/profile', compact('user'));
            $this->load->view('Template/footer');
        } else {
            $userName=$this->input->post('userName');
            $password=$this->input->post('oldpwd');
            $match=$this->Loginmodel->isValidate($userName, $password);
            if ($match) {
                $post=$this->input->post();
                $post = $this->security->xss_clean($post);
                $post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
                unset($post['oldpwd'], $post['userName'], $post['confirm_pass']);
                if ($this->Loginmodel->modifyUser($id, $post)) {
                    $this->session->set_flashdata('msg', 'Password modified successfully!');
                    $this->session->set_flashdata('alert', 'success');
                    redirect(base_url('Clinic/Home/profile'));
                } else {
                    $this->session->set_flashdata('msg', 'Failed to Modify password, Contact Administrator!!');
                    $this->session->set_flashdata('alert', 'danger');
                    redirect(base_url('Clinic/Home/profile'));
                }
            } else { //echo 'no match';
                $this->session->set_flashdata('msg', 'Incorrect Old Password !!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Home/profile'));
            }
        }
    }
    /*Profile Settings*/
}
