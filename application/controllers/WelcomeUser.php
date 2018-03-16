<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WelcomeUser extends CI_Controller
{

    public function _construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->template('home');
    }

    public function signin()
    {
        $this->load->template('signin');
    }

    public function signup()
    {
        // $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        // setting validation rules

        $this->config->load('form_validation');
        $this->form_validation->set_rules($this->config->item('signUp'));

        if ($this->form_validation->run() == true) {
            $formData = $this->input->post();

            $this->load->template('signup');

        } else {
            $this->load->template('signup');
        }
    }

    protected function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function getUserInfo($email = null)
    {
        $this->load->model('WelcomeUser');
        $this->WelcomeUser->getUserInfo($email);
    }
}
