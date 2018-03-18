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

        if (!empty($this->input->post())) {

            $this->load->library('form_validation');

            $this->config->load('form_validation');            
            $this->form_validation->set_rules($this->config->item('signIn'));

            if ($this->form_validation->run() == true) {
                $formData = $this->input->post();
                $userData = $this->login($formData);

            } 
            // else {

            //     $this->session->set_flashdata(array('msg' => 'Incorrect Username / Email ', 'msgClass' => 'alert-danger'));
            //     $this->session->keep_flashdata(array('msg', 'msgClass'));
            // }

        }

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
                    $this->email->from('no-reply@udhaar.com');
                    $this->email->to('swapnilshukla201@gmail.com');
                    $this->email->subject('Udhaar | Verify Account');
                    $this->email->message('
                    Dear ' . $user["first_name"] . ',
                    Click on below link to verify your account.' .
                        base_url('welcomeUser/verifyAccount/') . $user['otp'] . '
                     ');

                    $this->email->set_mailtype("html");
                    $this->email->set_newline("\r\n");

                    if ($this->email->send()) {

                        $this->session->set_flashdata(array('msg' => 'Mail with activation link has been sent successfully! Kindly verify your email account. ',
                            'msgClass' => 'alert-success'));
                        $this->session->keep_flashdata(array('msg', 'msgClass'));
                        redirect(current_url());
                    }

                } else {
                    $this->session->set_flashdata(array('msg' => 'Something went wrong! Please try again after sometime.',
                        'msgClass' => 'alert-danger'));
                    $this->session->keep_flashdata(array('msg', 'msgClass'));
                    print_r('mail not sent');
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

    public function verifyAccount($otp = null)
    {
        $this->load->model('WelcomeUser_model');
        $result = $this->WelcomeUser_model->verifyAccount($otp);
        if ($result) {
            $this->session->set_flashdata(array('msg' => 'Account has been verified successfully! Enter your credentials to signin. ', 'msgClass' => 'alert-success'));
            $this->session->keep_flashdata(array('msg', 'msgClass'));
            redirect('welcomeuser/signin');
        } else {
            $this->session->set_flashdata(array('msg' => 'Activation link is invalid ', 'msgClass' => 'alert-danger'));
            $this->session->keep_flashdata(array('msg', 'msgClass'));
            redirect('welcomeuser/signin');
        }
    }

    public function login($formData = null)
    {
        // add this function just in case if will have further requirements in the future.
        $this->load->model('WelcomeUser_model');
        $userData = $this->WelcomeUser_model->login($formData);
        return $userData;
    }
}
