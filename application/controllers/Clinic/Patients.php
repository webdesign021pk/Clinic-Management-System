<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Patients extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $patients=$this->Patientmodel->patientList('*');
        $this->load->view('Clinic/patients', compact('patients'));
        $this->load->view('Template/footer');
    }
    public function add()
    {
        if ($this->form_validation->run('addPatient')==false) {
            $this->load->view('Clinic/addPatient');
            $this->load->view('Template/footer');
        } else {
            $post=$this->input->post();
            $post = $this->security->xss_clean($post);
            if ($this->Patientmodel->addpatient($post)) {
                $this->session->set_flashdata('msg', 'New Patient added successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Patients'));
            } else {
                $this->session->set_flashdata('msg', 'Failed to Add Patient, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Patients'));
            }
        }
    }
    public function MR()
    {
        if ((($this->uri->segment(4))=='') || !ctype_digit($this->uri->segment(4))) {
            redirect(base_url('Clinic/Patients'));
        }
        $id=$this->uri->segment(4);
        $patient=$this->Patientmodel->MR($id);
        $reports=$this->Patientmodel->reports($id);
        $history=$this->Patientmodel->patientAppointmentHistory($id);
        $appointments = $this->Patientmodel->patientAppointmentList($id);
        $payments = $this->Patientmodel->paymentByPatient($id);
        $graphBp = $this->Graphmodel->graphBp($id);
        $graphPulse = $this->Graphmodel->graphPulse($id);
        $this->load->view('Clinic/patientMR', compact('patient','appointments','reports', 'history', 'payments','graphBp', 'graphPulse'));
        $this->load->view('Template/footer');
    }
    public function addReport()
    {
        $patients = $this->Patientmodel->patientList('patientIdPK, p_firstName, p_lastName');
        $post=$this->input->post();
        $post = $this->security->xss_clean($post);
        $file_name='';
        if (isset($_POST['patientId'])) {
            $file_name=$post['patientId'].'-'.$post['reportTitle'].'-'.$post['reportDate'];
        }
        $config['upload_path']   = './uploads/reports/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 200;
        $config['max_width']     = 1024;
        $config['max_height']    = 1024;
        $config['overwrite']     = true;
        $config['file_name']     = $file_name;
        $this->load->library('upload', $config);
        if ($this->form_validation->run('uploadReport') && $this->upload->do_upload('userfile')) {
            $data = $this->upload->data();
            //$image_path=base_url('uploads/'.$data['raw_name'].$data['file_ext']);
            $image_path='uploads/reports/'.$data['raw_name'].$data['file_ext'];
            $post['image_path']=$image_path;
            $r = $this->Patientmodel->addReport($post);
            if ($r) { //echo "insert successful";
                echo 1;
                $this->session->set_flashdata('msg', 'Report added successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Patients/MR/'.$post['patientId'].'/Reports'));
            } else { //echo "sorry";
                $this->session->set_flashdata('msg', 'Failed to add report, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Patients/MR/'.$post['patientId'].'/Reports'));
            }
        } else {
            $error = $this->upload->display_errors();
            $this->load->view('Clinic/addReport', compact('patients','error'));
            $this->load->view('Template/footer');
        }
    }
    public function deleteReport()
    {
        $r = $this->Patientmodel->deleteReport($_POST['rID']);
        if ($r) { //echo "Delete successful";
            print_r(unlink('./'.$_POST['imagePath']));
            echo '1';
        }
    }

}
