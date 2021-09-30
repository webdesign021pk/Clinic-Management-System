<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $staff=$this->Staffmodel->staffList('*');
        $this->load->view('Clinic/staff', compact('staff'));
        $this->load->view('Template/footer');
    }
    public function add()
    {
        if ($this->form_validation->run('addStaff')==false) {
            $this->load->view('Clinic/addStaff');
            $this->load->view('Template/footer');
        } else {
            $post=$this->input->post();
            $post = $this->security->xss_clean($post);
            if ($this->Staffmodel->addStaff($post)) {
                $this->session->set_flashdata('msg', 'New staff added successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Staff'));
            } else {
                $this->session->set_flashdata('msg', 'Failed to Add Staff, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Staff'));
            }
        }
    }
    public function modify($id)
    {
        if ($this->form_validation->run('addStaff')==false) {
            $staff=$this->Staffmodel->staff($id);
            $this->load->view('Clinic/modifyStaff', compact('staff'));
            $this->load->view('Template/footer');
        } else {
            $post=$this->input->post();
            $post = $this->security->xss_clean($post);
            if ($this->Staffmodel->modifyStaff($id, $post)) { //echo "doctor updated";
                $this->session->set_flashdata('msg', 'Staff modified successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Staff/Modify/').$id);
            } else {
                $this->session->set_flashdata('msg', 'Failed to Modify Staff, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Staff'));
            }
        }
    }

}
