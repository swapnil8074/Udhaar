<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WelcomeUser extends CI_Controller {

	public function index()
	{
		$this->load->template('home');
	}

	public function signin(){
		$this->load->template('signin');
	}

	public function signup(){
		$this->load->template('signup');
	}
}
