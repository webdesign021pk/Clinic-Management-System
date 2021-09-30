<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Appointments extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $appointments = $this->Patientmodel->appointmentList($_SESSION['doctorId']);
        $attendedAppointments = $this->Patientmodel->attendedAppointments($_SESSION['doctorId']);
        $this->load->view('Clinic/appointments', compact('appointments', 'attendedAppointments'));
        $this->load->view('Template/footer');
    }
    public function add()
    {
        $paymentType = $this->Patientmodel->paymentType('paymentTypeIdPK, paymentType, suggestedAmount');
        $doctors = $this->Staffmodel->doctorsList('doctorIdPK, d_firstName, d_lastName');
        $patients = $this->Patientmodel->patientList('patientIdPK, p_firstName, p_lastName');
        if ($this->form_validation->run('addAppointment') == false) {
            $this->load->view('Clinic/addAppointment', compact('doctors', 'patients', 'paymentType'));
            $this->load->view('Template/footer');
        } else {
            $post = $this->input->post();
            $post = $this->security->xss_clean($post);
            /*$data = [
                'paymentTypeId'=>$post['paymentTypeId'],
                'amountDue'=>$post['amountDue'],
                'discount'=>$post['discount'],
                'patientId'=>$post['patientId'],
                'paymentDate'=>$post['appointmentDate']
            ];
            unset($post['paymentTypeId'], $post['amountDue'], $post['discount'] );*/
            /*$invoiceId=$this->Patientmodel->addInvoice($data);*/
            if ($this->Patientmodel->addAppointment($post)) {
                /*$post['paymentID']=$invoiceId;
                $this->Patientmodel->addAppointment($post);*/
                $this->session->set_flashdata('msg', 'New Appointment added successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Appointments'));
            } else {
                $this->session->set_flashdata('msg', 'Failed to Add Appointment, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Appointments'));
            }
        }
    }
    public function view(){
        if ((($this->uri->segment(4))=='') || !ctype_digit($this->uri->segment(4))) {
            redirect(base_url('Clinic/Home'));
        }
        $id=$this->uri->segment(4);
        $paymentType = $this->Patientmodel->paymentType('paymentTypeIdPK, paymentType, suggestedAmount');
        $appointment=$this->Patientmodel->viewAppointment($id);
        $aptId=$this->Patientmodel->getPatientByAppointmentId($id);
        $reports=$this->Patientmodel->reports($aptId);
        $post = $this->input->post();
        $post = $this->security->xss_clean($post);
        if ($this->form_validation->run('addNotes')==false ) {
            $this->load->view('Clinic/viewAppointment', compact('appointment', 'reports', 'paymentType'));
            $this->load->view('Template/footer');
        } else {
            if ($this->Patientmodel->addNotes($id, $post)) {
                $this->session->set_flashdata('msg', 'Appointment processed successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Appointments'));
            } else {
                $this->session->set_flashdata('msg', 'Failed to Process Appointment, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Appointments'));
            }
        }
    }
    public function uploadConsultation($id){
        $appointment=$this->Patientmodel->viewAppointment($id);
        $reports=$this->Patientmodel->reports($id);
        $post = $this->input->post();
        $post = $this->security->xss_clean($post);
        $file_name='consultID-'.$id;
        $config['upload_path']   = './uploads/consultation/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 600;
        $config['max_width']     = 4024;
        $config['max_height']    = 4024;
        $config['overwrite']     = true;
        $config['file_name']     = $file_name;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('userfile')) {
            $data = $this->upload->data();
            $image_path='uploads/consultation/'.$config['file_name'].$data['file_ext'];
            $post['image_path']=$image_path;
            unset($post['userfile']);
            if ($this->Patientmodel->addNotes($id, $post)) {
                $this->session->set_flashdata('msg', 'Consultation uploaded successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Appointments/View/'.$id));
            } else {
                $this->session->set_flashdata('msg', 'Failed to Upload Consultation, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Appointments/View/'.$id));
            }
        } else {

            $error = $this->upload->display_errors();
            $this->load->view('Clinic/viewAppointment', compact('appointment', 'reports', 'error'));
            $this->load->view('Template/footer');
        }
    }

}