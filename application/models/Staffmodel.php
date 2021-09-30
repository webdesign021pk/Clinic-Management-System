<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staffmodel extends CI_Model
{
    public function doctorsList($fields)
    {
        $q=$this->db->select($fields)
            ->from('cdb_tbl_doctor')
            ->get();
        return $q->result();
    }
    public function doctor($id)
    {
        $q=$this->db->select('*')
            ->from('cdb_tbl_doctor')
            ->where('cdb_tbl_doctor.doctorIdPK', $id)
            ->get();
        return $q->row();
    }
    public function addDoctor($post)
    {
        return $this->db->insert('cdb_tbl_doctor', $post);
    }
    public function modifyDoctor($id, $post)
    {
        return $this->db->where('doctorIdPK', $id)
            ->update('cdb_tbl_doctor', $post);
    }
    public function totalDoctors()
    {
        $q=$this->db->where('doctorStatus', 1)
            ->from('cdb_tbl_doctor')
            ->count_all_results();
        return $q;
    }
    public function staffList($fields)
    {
        $q=$this->db->select($fields)
            ->from('cdb_tbl_staff')
            ->get();
        return $q->result();
    }

    public function staff($id)
    {
        $q=$this->db->select('*')
            ->from('cdb_tbl_staff')
            ->where('cdb_tbl_staff.staffIdPK', $id)
            ->get();
        return $q->row();
    }
    public function modifyStaff($id, $post)
    {
        return $this->db->where('staffIdPK', $id)
            ->update('cdb_tbl_staff', $post);
    }
    public function addStaff($post)
    {
        return $this->db->insert('cdb_tbl_staff', $post);
    }
}