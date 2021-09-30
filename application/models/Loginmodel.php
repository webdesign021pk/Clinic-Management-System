<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Loginmodel extends CI_Model
{
    public function isValidate($userName, $password)
    {
        $q=$this->db->where(['userName'=>$userName/*,'password'=>$password*/])
                 ->get('cdb_tbl_users');
        if ($q->num_rows()) {
            if (password_verify($password, $q->row()->password)) {
                // Success!
                return $q->row()->userIdPK;
            } else {
                // Invalid credentials
                return false;
            }
            return $q->row()->userIdPK;
        } else {
            return false;
        }
    }
    public function userDetail()
    {
        $uid=$this->session->userdata('userIdPK');
        $q=$this->db->select('*')
            ->from('cdb_tbl_users')
            ->where('userIdPK', $uid)
            ->get();
        return $q->row();
    }
    public function userList()
    {
        $q=$this->db->select()
                ->from('cdb_tbl_users')
                ->get();
        return $q->result();
    }
    public function userProfile($id)
    {
        $q=$this->db->select()
            ->from('cdb_tbl_users')
            ->where('userIdPK', $id)
            ->get();
        return $q->row();
    }
    public function modifyUser($id, $array)
    {
        return $this->db->where('userIdPK', $id)
            ->update('cdb_tbl_users', $array);
    }
    public function addUser($array)
    {
        return $this->db->insert('cdb_tbl_users', $array);
    }
}
