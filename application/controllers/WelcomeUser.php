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
        $this->load->library('form_validation');

        // setting validation rules
        $this->config->load('form_validation');
        $this->form_validation->set_rules($this->config->item('signUp'));

        if ($this->form_validation->run() == true) {
            $formData = $this->input->post();
            $this->load->model('WelcomeUser_model');
            $user = $this->WelcomeUser_model->getUserInfo($email);
            // print_r($user);die;

            if (!empty($user)) {
                $this->session->set_flashdata(array('msg' => 'Email already exist!', 'msgClass' => 'alert-danger'));
                $this->session->keep_flashdata(array('msg', 'msgClass'));
                // print_r($this->session->flashdata('msg'));die;
                $this->load->template('signup');
            } else {
                $form['name'] = explode(" ",$form['name']);
                $user['first_name'] = $form['name'][0];
                $user['last_name'] = $form['name'][1];
                $user['email'] = $form['email'];
                $user['password'] = $form['password'];
                $user['otp'] = $this->generateOtp(30);
                
                print_r($user);die;
                $this->load->template('signup');
            }

        } else {
            $this->load->template('signup');
        }
    }

    protected function generateOtp($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
