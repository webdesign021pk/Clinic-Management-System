<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payments extends MY_Controller
{
    public function index()
    {
        $payments = $this->Patientmodel->payments();
        $invoices = $this->Patientmodel->invoices();
        $this->load->view('Clinic/payments', compact('payments', 'invoices'));
        $this->load->view('Template/footer');
    }
    public function addInvoice(){
        $patients = $this->Patientmodel->patientList('patientIdPK, p_firstName, p_lastName');
        $paymentType = $this->Patientmodel->paymentType('paymentTypeIdPK, paymentType, suggestedAmount');
        if ($this->form_validation->run('addInvoice') == false) {
            $this->load->view('Clinic/addInvoice', compact('patients', 'paymentType'));
            $this->load->view('Template/footer');
        } else {
            $post = $this->input->post();
            $post = $this->security->xss_clean($post);
            if ($this->Patientmodel->addInvoice($post)) {
                $this->session->set_flashdata('msg', 'New invoice added successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Payments'));
            } else {
                $this->session->set_flashdata('msg', 'Failed to Add Invoice, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Payments'));
            }
        }
    }
    public function payInvoice($id){
        $paymentType = $this->Patientmodel->paymentType('paymentTypeIdPK, paymentType, suggestedAmount');
        $payment = $this->Patientmodel->getPayment($id);
        if ($this->form_validation->run('payInvoice') == false) {
            $this->load->view('Clinic/payInvoice', compact('payment', 'paymentType'));
            $this->load->view('Template/footer');
        } else {
            $post = $this->input->post();
            $post = $this->security->xss_clean($post);
            if ($this->Patientmodel->payInvoice($id, $post)) {
                $data=[
                    'paymentID'=>$id,
                    'isPaid'=>'1',
                ];
                $this->Patientmodel->addNotes($post['appointmentId'], $data);
                $this->session->set_flashdata('msg', 'Invoice paid successfully!');
                $this->session->set_flashdata('alert', 'success');
                redirect(base_url('Clinic/Payments/viewInvoice/'.$id));
            } else {
                $this->session->set_flashdata('msg', 'Failed to pay Invoice, Contact Administrator!!');
                $this->session->set_flashdata('alert', 'danger');
                redirect(base_url('Clinic/Payments'));
            }
        }
    }
    public function viewInvoice($id){
        $paymentType = $this->Patientmodel->paymentType('paymentTypeIdPK, paymentType, suggestedAmount');
        $payment = $this->Patientmodel->getInvoice($id);
        $this->load->view('Clinic/viewInvoice', compact('payment', 'paymentType'));
        $this->load->view('Template/footer');
    }

}