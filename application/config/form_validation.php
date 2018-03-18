<?php

$config = array(
    'signUp' => array(
        array(
            'field' => 'name',
            'label' => 'Your Name',
            'rules' => 'required',
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|trim|valid_email',
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required',
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[5]',
        ),
        array(
            'field' => 'confirm',
            'label' => 'Confirm Password',
            'rules' => 'required|matches[password]|min_length[5]',
        ),
    ),

    'signIn' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|trim',
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required',
        ),
    ),

);
