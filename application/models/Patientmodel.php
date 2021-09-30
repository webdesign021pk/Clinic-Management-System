<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Patientmodel extends CI_Model
{
    /*Patients*/
    function patientList($fields){
        $q=$this->db->select($fields)
            ->from('cdb_tbl_patients')
            ->get();
        return $q->result();
    }
    public function addpatient($post){
        return $this->db->insert('cdb_tbl_patients', $post);
    }
    public function totalPatients(){
        $q=$this->db->where('patientStatus', 1)
            ->from('cdb_tbl_patients')
            ->count_all_results();
        return $q;
    }
    public function getPatientByAppointmentId($aptId){
        $q=$this->db->select('patientId')
            ->from('cdb_tbl_appointments')
            ->where('cdb_tbl_appointments.appointmentIdPK', $aptId)
            ->get();
        return $q->row()->patientId;
    }
    /*Patients*/

    /*Appointments*/
    public function totalAppointments(){
        $q=$this->db->where('appointmentStatus', 1)
            ->from('cdb_tbl_appointments')
            ->count_all_results();
        return $q;
    }
    public function todaysAppointments(){
        $today=date('Y-m-d');
        $q=$this->db->like('appointmentDate', $today)
            ->from('cdb_tbl_appointments')
            ->count_all_results();
        return $q;
    }
    public function appointmentList($doctorID){
        if($doctorID != 0) {
            $condition = 'cdb_tbl_appointments.doctorId = '.$doctorID;
        } else {
            $condition='cdb_tbl_appointments.appointmentStatus = 1';
        }
        $q=$this->db->select('cdb_tbl_appointments.*, cdb_tbl_patients.patientIdPK,cdb_tbl_patients.p_firstName, cdb_tbl_patients.p_lastName,
        cdb_tbl_doctor.doctorIdPK,cdb_tbl_doctor.d_firstName,cdb_tbl_doctor.d_lastName,cdb_tbl_timeslots.timeSlot')
            ->from('cdb_tbl_appointments')
            ->join('cdb_tbl_patients', 'cdb_tbl_patients.patientIdPK = cdb_tbl_appointments.patientId')
            ->join('cdb_tbl_doctor', 'cdb_tbl_doctor.doctorIdPK = cdb_tbl_appointments.doctorId')
            ->join('cdb_tbl_timeslots', 'cdb_tbl_timeslots.timeSlotIdPK = cdb_tbl_appointments.timeSlotId')
            ->where('cdb_tbl_appointments.appointmentStatus','1')
            ->where($condition)
            ->get();
        return $q->result();
    }

    public function todaysAppointmentsList($doctorID){
        if($doctorID != 0) {
            $condition = 'cdb_tbl_appointments.doctorId = '.$doctorID;
        } else {
            $condition='cdb_tbl_appointments.appointmentStatus = 1';
        }
        $today=date('Y-m-d');
        $q=$this->db->select('cdb_tbl_appointments.appointmentIdPK, cdb_tbl_appointments.timeSlotId, cdb_tbl_appointments.patientId,  cdb_tbl_appointments.doctorId,
        cdb_tbl_patients.patientIdPK,cdb_tbl_patients.p_firstName, cdb_tbl_patients.p_lastName,
        cdb_tbl_doctor.doctorIdPK,cdb_tbl_doctor.d_firstName,cdb_tbl_doctor.d_lastName,
        cdb_tbl_timeslots.timeSlot')
            ->join('cdb_tbl_patients', 'cdb_tbl_patients.patientIdPK = cdb_tbl_appointments.patientId')
            ->join('cdb_tbl_doctor', 'cdb_tbl_doctor.doctorIdPK = cdb_tbl_appointments.doctorId')
            ->join('cdb_tbl_timeslots', 'cdb_tbl_timeslots.timeSlotIdPK = cdb_tbl_appointments.timeSlotId')
            ->like('appointmentDate', $today)
            ->where($condition)
            ->from('cdb_tbl_appointments')
            ->get();
        return $q->result();
    }
    public function attendedAppointments($doctorID){
        if($doctorID != 0) {
            $condition = 'cdb_tbl_appointments.doctorId = '.$doctorID;
        } else {
            $condition='cdb_tbl_appointments.appointmentStatus = 2';
        }
        $q=$this->db->select('cdb_tbl_appointments.*, cdb_tbl_patients.patientIdPK,cdb_tbl_patients.p_firstName, cdb_tbl_patients.p_lastName,
        cdb_tbl_doctor.doctorIdPK,cdb_tbl_doctor.d_firstName,cdb_tbl_doctor.d_lastName,cdb_tbl_timeslots.timeSlot')
            ->from('cdb_tbl_appointments')
            ->join('cdb_tbl_patients', 'cdb_tbl_patients.patientIdPK = cdb_tbl_appointments.patientId')
            ->join('cdb_tbl_doctor', 'cdb_tbl_doctor.doctorIdPK = cdb_tbl_appointments.doctorId')
            ->join('cdb_tbl_timeslots', 'cdb_tbl_timeslots.timeSlotIdPK = cdb_tbl_appointments.timeSlotId')
            ->where('cdb_tbl_appointments.appointmentStatus','2')
            ->where($condition)
            ->get();
        return $q->result();
    }
    public function patientAppointmentList($id){
        $q=$this->db->select('cdb_tbl_appointments.*, cdb_tbl_patients.patientIdPK,cdb_tbl_patients.p_firstName, cdb_tbl_patients.p_lastName,
        cdb_tbl_doctor.doctorIdPK,cdb_tbl_doctor.d_firstName,cdb_tbl_doctor.d_lastName,cdb_tbl_timeslots.timeSlot')
            ->from('cdb_tbl_appointments')
            ->join('cdb_tbl_patients', 'cdb_tbl_patients.patientIdPK = cdb_tbl_appointments.patientId')
            ->join('cdb_tbl_doctor', 'cdb_tbl_doctor.doctorIdPK = cdb_tbl_appointments.doctorId')
            ->join('cdb_tbl_timeslots', 'cdb_tbl_timeslots.timeSlotIdPK = cdb_tbl_appointments.timeSlotId')
            ->where('cdb_tbl_appointments.appointmentStatus !=','0')
            ->where('cdb_tbl_appointments.appointmentStatus !=','2')
            ->where('cdb_tbl_appointments.patientId', $id)
            ->get();
        return $q->result();
    }
    public function patientAppointmentHistory($id){
        $q=$this->db->select('cdb_tbl_appointments.*, cdb_tbl_patients.patientIdPK,cdb_tbl_patients.p_firstName, cdb_tbl_patients.p_lastName,
        cdb_tbl_doctor.doctorIdPK,cdb_tbl_doctor.d_firstName,cdb_tbl_doctor.d_lastName,cdb_tbl_timeslots.timeSlot')
            ->from('cdb_tbl_appointments')
            ->join('cdb_tbl_patients', 'cdb_tbl_patients.patientIdPK = cdb_tbl_appointments.patientId')
            ->join('cdb_tbl_doctor', 'cdb_tbl_doctor.doctorIdPK = cdb_tbl_appointments.doctorId')
            ->join('cdb_tbl_timeslots', 'cdb_tbl_timeslots.timeSlotIdPK = cdb_tbl_appointments.timeSlotId')
            ->where('cdb_tbl_appointments.appointmentStatus','2')
            ->where('cdb_tbl_appointments.patientId', $id)
            ->get();
        return $q->result();
    }
    public function addAppointment($post)
    {
        return $this->db->insert('cdb_tbl_appointments', $post);
    }
    public function addNotes($id, $array)
    {
        return $this->db->where('appointmentIdPK', $id)
            ->update('cdb_tbl_appointments', $array);
    }
    public function viewAppointment($id)
    {
        $q=$this->db->select('cdb_tbl_appointments.*, cdb_tbl_doctor.d_firstName, cdb_tbl_doctor.d_lastName, cdb_tbl_doctor.contact1,
        cdb_tbl_patients.*, cdb_tbl_timeslots.timeSlot')
            ->from('cdb_tbl_appointments')
            ->join('cdb_tbl_patients','cdb_tbl_patients.patientIdPK = cdb_tbl_appointments.patientId')
            ->join('cdb_tbl_doctor','cdb_tbl_doctor.doctorIdPK = cdb_tbl_appointments.doctorId')
            ->join('cdb_tbl_timeslots','cdb_tbl_timeslots.timeSlotIdPK = cdb_tbl_appointments.timeSlotId')
            ->where('cdb_tbl_appointments.appointmentIdPK', $id)
            ->get();
        return $q->row();
    }
    /*public function addVitals($post)
    {
        $this->db->insert('cdb_tbl_vitals', $post);
    }*/
    public function getVitalId($id){
        $q=$this->db->select('vitalIdPK')
            ->from('cdb_tbl_vitals')
            ->where('appointmentId', $id)
            ->get();
        return $q->row()->vitalIdPK;
    }
    public function updateVitalId($id, $value){
        $q=$this->db->set('vitalsId', $value)
            ->where('cdb_tbl_appointments.appointmentIdPK', $id)
            ->update('cdb_tbl_appointments');
        return $q;
    }

    /*Appointments*/

    /*Medical Record*/
    public function MR($id){
        $q = $this->db->select('*')
            ->from('cdb_tbl_patients')
            ->where('patientIdPK', $id)
            ->get();
        return $q->row();
    }
    /*Medical Record*/

    /*Reports*/
    public function reports($id){
        $q = $this->db->select('*')
            ->from('cdb_tbl_reports')
            ->where('cdb_tbl_reports.patientId', $id)
            ->order_by('cdb_tbl_reports.reportIdPK', 'desc')
            ->get();
        return $q->result();
    }
    public function addReport($post){
        return $this->db->insert('cdb_tbl_reports', $post);
    }
    public function deleteReport($id){
        return $this->db->delete('cdb_tbl_reports', array('reportIdPK' => $id));
    }
    /*Reports*/

    /*Payments*/
    public function payments(){
        $q=$this->db->select('cdb_tbl_payments.*, cdb_tbl_patients.p_firstName, cdb_tbl_patients.p_lastName, cdb_tbl_payment_type.paymentType')
            ->from('cdb_tbl_payments')
            ->join('cdb_tbl_patients', 'cdb_tbl_patients.patientIdPK = cdb_tbl_payments.patientId')
            ->join('cdb_tbl_payment_type', 'cdb_tbl_payment_type.paymentTypeIdPK = cdb_tbl_payments.paymentTypeId')
            ->where('paymentStatus','0')
            ->get();
        return $q->result();
    }
    public function invoices(){
        $q=$this->db->select('cdb_tbl_payments.*, cdb_tbl_patients.p_firstName, cdb_tbl_patients.p_lastName, cdb_tbl_payment_type.paymentType')
            ->from('cdb_tbl_payments')
            ->join('cdb_tbl_patients', 'cdb_tbl_patients.patientIdPK = cdb_tbl_payments.patientId')
            ->join('cdb_tbl_payment_type', 'cdb_tbl_payment_type.paymentTypeIdPK = cdb_tbl_payments.paymentTypeId')
            ->where('paymentStatus','1')
            ->get();
        return $q->result();
    }
    public function getPayment($id){
        $q=$this->db->select('cdb_tbl_payments.*, cdb_tbl_patients.patientIdPK, cdb_tbl_patients.p_firstName, cdb_tbl_patients.p_lastName, cdb_tbl_payment_type.paymentType')
            ->from('cdb_tbl_payments')
            ->join('cdb_tbl_patients', 'cdb_tbl_patients.patientIdPK = cdb_tbl_payments.patientId')
            ->join('cdb_tbl_payment_type', 'cdb_tbl_payment_type.paymentTypeIdPK = cdb_tbl_payments.paymentTypeId')
            ->where('paymentStatus','0')
            ->where('paymentIdPK', $id)
            ->get();
        return $q->row();
    }
    public function paymentByPatient($id){
        $q=$this->db->select('cdb_tbl_payments.*, cdb_tbl_payment_type.paymentType')
            ->from('cdb_tbl_payments')
            ->join('cdb_tbl_payment_type', 'cdb_tbl_payment_type.paymentTypeIdPK = cdb_tbl_payments.paymentTypeId')
            ->where('patientId', $id)
            ->get();
        return $q->result();
    }
    public function getInvoice($id){
        $q=$this->db->select('cdb_tbl_payments.*, cdb_tbl_patients.patientIdPK, cdb_tbl_patients.p_firstName, cdb_tbl_patients.p_lastName, cdb_tbl_payment_type.paymentType')
            ->from('cdb_tbl_payments')
            ->join('cdb_tbl_patients', 'cdb_tbl_patients.patientIdPK = cdb_tbl_payments.patientId')
            ->join('cdb_tbl_payment_type', 'cdb_tbl_payment_type.paymentTypeIdPK = cdb_tbl_payments.paymentTypeId')
            ->where('paymentStatus','1')
            ->where('paymentIdPK', $id)
            ->get();
        return $q->row();
    }
    public function paymentType($fields){
        $q=$this->db->select($fields)
            ->from('cdb_tbl_payment_type')
            ->where('paymentTypeStatus','1')
            ->get();
        return $q->result();
    }
    public function addInvoice($post){
        $this->db->insert('cdb_tbl_payments', $post);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
    public function payInvoice($id, $array){
        return $this->db->where('paymentIdPK', $id)
            ->update('cdb_tbl_payments', $array);
    }
    /*Payments*/

}