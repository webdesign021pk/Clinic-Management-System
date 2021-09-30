<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NoUI extends CI_Controller
{
    public function getAppointmentTime($date)
    {
        $q=$this->db->select('timeSlotId')
            ->from('cdb_tbl_appointments')
            ->where('appointmentDate', $date)
            ->get();
        $r= $q->result_array();
        if($r){
            foreach($r as $row){
                $time[] = $row['timeSlotId'];
            }
            $q2=$this->db->select('*')
                ->from('cdb_tbl_timeslots')
                ->where_not_in('timeSlotIdPK', $time)
                ->get();
            $r2= $q2->result();
            foreach($r2 as $row2){
                echo "<option value='".$row2->timeSlotIdPK."'>";
                echo $row2->timeSlot;
                echo "</option>";
            }
        } else {
            $q2=$this->db->select('*')
                ->from('cdb_tbl_timeslots')
                ->get();
            $r2= $q2->result();
            foreach($r2 as $row2){
                echo "<option value='".$row2->timeSlotIdPK."'>";
                echo $row2->timeSlot;
                echo "</option>";
            }
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
    public function addVitals($id){
        if($this->form_validation->run('addVitals') == false){
            echo '<div class="alert alert-danger alert-dismissible rounded w-100 p-1" style="font-size: 0.8rem">
                    <button type="button" class="close my-0 py-0" data-dismiss="alert">&times;</button>'
                    .validation_errors().
                 '</div>';
        } else {
            $post=$this->input->post();
            if($this->Patientmodel->addNotes($id, $post)) {
                echo 1;
            }
        }
    }
    public function addInvoice(){
        if($this->form_validation->run('addInvoice') == false){
            echo '<div class="alert alert-danger alert-dismissible rounded w-100 p-1" style="font-size: 0.8rem">
                    <button type="button" class="close my-0 py-0" data-dismiss="alert">&times;</button>'
                .validation_errors().
                '</div>';
        } else {
            $post=$this->input->post();
            $invoiceId=$this->Patientmodel->addInvoice($post);
            if($invoiceId) {
                $data=[
                    'paymentID'=>$invoiceId
                ];
                $this->Patientmodel->addNotes($post['appointmentId'], $data);
                echo 1;
            }
        }
    }
}