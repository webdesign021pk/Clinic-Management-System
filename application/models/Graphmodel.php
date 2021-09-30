<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Graphmodel extends CI_Model
{
    public function graphBp($id)
    {
        $q=$this->db->select('cdb_tbl_appointments.bpUp, cdb_tbl_appointments.bpDown, cdb_tbl_appointments.appointmentDate, cdb_tbl_appointments.pulse, cdb_tbl_appointments.temperature, cdb_tbl_appointments.weight')
            ->from('cdb_tbl_appointments')
            ->where('cdb_tbl_appointments.patientId', $id)
            ->where('cdb_tbl_appointments.appointmentStatus', '2')
            ->order_by('cdb_tbl_appointments.appointmentIdPK', 'DESC')
            ->limit(20)
            ->get();
        return array_reverse($q->result());
    }
    public function graphPulse($id)
    {
        $q=$this->db->select('cdb_tbl_appointments.bpUp, cdb_tbl_appointments.bpDown, cdb_tbl_appointments.appointmentDate')
            ->from('cdb_tbl_appointments')
            ->where('cdb_tbl_appointments.patientId', $id)
            ->order_by('cdb_tbl_appointments.appointmentIdPK', 'DESC')
            ->limit(20)
            ->get();
        return array_reverse($q->result());
    }
}