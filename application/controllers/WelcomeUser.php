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
            $user = $this->WelcomeUser_model->getUserInfo($formData['email']);
            // print_r($user);die;

            if (!empty($user)) {
                $this->session->set_flashdata(array('msg' => 'Email already exist!', 'msgClass' => 'alert-danger'));
                $this->session->keep_flashdata(array('msg', 'msgClass'));
            } else {

                $user['first_name'] = $formData['name'];
                // $user['last_name'] = $formData['name'];
                $user['email'] = $formData['email'];
                $user['password'] = $formData['password'];
                $user['otp'] = $this->generateOtp(30);
                $accountCreated = $this->WelcomeUser_model->createUserAccount($user);
                if ($accountCreated) {
                    $this->load->library('email');
                    $this->email->from('your@example.com', 'Your Name');
                    $this->email->to('someone@example.com');
                    $this->email->cc('another@another-example.com');
                    $this->email->bcc('them@their-example.com');
                    $this->email->subject('Email Test');
                    $this->email->message('Testing the email class.');


                    $this->email->send();
                    $this->session->set_flashdata(array('msg' => 'Mail with activation link has been sent successfully! Kindly verify your email account. ',
                        'msgClass' => 'alert-success'));
                    $this->session->keep_flashdata(array('msg', 'msgClass'));
                } else {
                    $this->session->set_flashdata(array('msg' => 'Something went wrong! Please try again after sometime.',
                        'msgClass' => 'alert-danger'));
                }

            }

        }
        $this->load->template('signup');
    }

    public function generateOtp($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // public function sendMail(){}


}
