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

    public function verifyAccount($otp = null)
    {
        // $this->db->set('verified','1');
        $data = array('verified' => '1', 'otp' => '');
        $this->db->where('otp', $otp);
        $this->db->update('users', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }
    public function login($formData = null)
    {
        $this->db->select('id,first_name, username, email, gender, picture_url, verified');
        $this->db->from('users');
        $this->db->where('email', $formData['email']);
        $this->db->or_where('username', $formData['email']);
        $this->db->where('password', $formData['password']);
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
        // $result = $query->row();
        $result = $query->result_array();
        
        if (!empty($result)) {
            return $result[0];
        } else {
            return false;
        }

    }

}
