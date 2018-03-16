<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WelcomeUser_model extends CI_Model
{

    public function getUserInfo($email = null)
    {

        $this->db->select('email')->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $result = $query->result();
        if (empty($result)) {
            return false;
        } else {
            // print_r($result[0]); die;
            return $result[0];
        }
    }

    public function createUserAccount($user = null)
    {
        if ($user) {
            $this->db->insert('users', $user);
            return ($this->db->affected_rows() != 1) ? false : true;
        } else {
            return false;
        }

    }

}
