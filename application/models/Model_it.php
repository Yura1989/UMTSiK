<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Model_it extends CI_Model
{
    /*Добавление в базу*/
    function add ($query){
        $this->db->query($query);
    }

    /*Выгрузка из базы*/
    function show ($query){
        $result = $this->db->query($query);
        return $result->result_array();
    }

    /*Удаление из базы*/
    function delete ($query){
        $this->db->query($query);
    }
}
?>