<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_users extends CI_Model
{
    function editUser()
    {
        $editUser = array(
            array(
                'field' => 'password',
                'label' => 'Пароль',
                'rules' => 'trim|required|min_length[5]|max_length[20]|matches[repassword]'
            ),
            array(
                'field' => 'repassword',
                'label' => 'Повторный пароль',
                'rules' => 'trim|required|min_length[5]|max_length[20]'
            ),
        );
        return $editUser;
    }
}