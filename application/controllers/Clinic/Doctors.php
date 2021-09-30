<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Doctors extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $doctors=$this->Staffmodel->doctorsList('*');
        $this->load->view('Clinic/doctors', compact('doctors'));
        $this->load->view('Template/footer');
    }
    public function add()
    {
        if ($this->form_validation->run('addDoctor')==false) {
            $this->load->view('Clinic/addDoctor');
            $this->load->view('Template/footer');
        } else {
            $post=$this->input->post();
            $post = $this->security->xss_clean($post);
            if ($this->Staffmodel->addDoctor($post)) {
                $this->session->set_flashdata('msg', 'New Patient added successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Doctors'));
            } else {
                $this->session->set_flashdata('msg', 'Failed to Add Patient, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Patients'));
            }
        }
    }
    public function modify($id)
    {
        if ($this->form_validation->run('addDoctor')==false) {
            $doctor=$this->Staffmodel->doctor($id);
            $this->load->view('Clinic/modifyDoctor', compact('doctor'));
            $this->load->view('Template/footer');
        } else {
            $post=$this->input->post();
            $post = $this->security->xss_clean($post);
            if ($this->Staffmodel->modifyDoctor($id, $post)) { //echo "doctor updated";
                $this->session->set_flashdata('msg', 'Doctor modified successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Doctors/Modify/').$id);
            } else {
                $this->session->set_flashdata('msg', 'Failed to Modify Doctor, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Doctors'));
            }
        }
    }

}
