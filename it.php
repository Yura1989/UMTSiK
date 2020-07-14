<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class it extends CI_Controller {

    public function index(){
        $query = sprintf("SELECT * FROM systems_for_matrix;");
        $query_matrix = sprintf("SELECT * FROM matrix;");
        $this->load->model('Model_it');
        $result['systems'] = $this->Model_it->show($query);
        $result['matrix'] = $this->Model_it->show($query_matrix);
        $this->load->view("it/template_it/view_header");
        $this->load->view("it/template_it/view_menu");
        $this->load->view("it/view_show_matrix", $result);
        $this->load->view("it/template_it/view_footer");
    }

/*Очистка сессиий*/
    function exit_session_it(){
        $this->session->unset_userdata('username');
        $this->load->view('template/view_header');
        $this->load->view('view_auth');
        $this->load->view('template/view_footer');
    }

/*Страница системы*/
    function systems_it(){
        $query = sprintf("SELECT * FROM systems_for_matrix;");
        $this->load->model('Model_it');
        $result['systems'] = $this->Model_it->show($query);
        $this->load->view("it/template_it/view_header");
        $this->load->view("it/template_it/view_menu");
        $this->load->view("it/view_systems",$result);
        $this->load->view("it/template_it/view_footer");
    }

/*AJAX Добавление системы*/
    function add_system_it(){
        $name_system = $this->input->post("name_system");
        $query = sprintf("INSERT INTO systems_for_matrix (name_system) VALUES ('%s');", trim($name_system));
        $this->load->model("Model_it");
        $this->Model_it->add($query);
    }

/*AJAX Удаление системы*/
    function delete_system_it(){
        $id_name_systems = $this->input->post("id_name_systems");
        $query = sprintf("DELETE FROM systems_for_matrix WHERE id_systems = '%s';", trim($id_name_systems));
        $this->load->model("Model_it");
        $this->Model_it->add($query);
    }

/*AJAX Выборка системы*/
    function show_system_it(){
        $id_name_systems = $this->input->post("id_name_systems");
        $query = sprintf("SELECT * FROM systems_for_matrix WHERE id_systems = '%s';", trim($id_name_systems));
        $this->load->model("Model_it");
        $result = $this->Model_it->show($query);
        foreach($result as $item):
            echo ("<input type=\"text\" id=\"name_system_edit\" value=\"".$item['name_system']."\" autocomplete=\"off\" data-id_name_system=\"".$item['id_systems']."\" name=name_system\" class=\"form-control\">");
        endforeach;
    }

/*AJAX Внесение изменения в систему*/
    function edit_system_it(){
        $name_system = $this->input->post("name_system");
        $id_name_system = $this->input->post("id_name_systems");
        $query = sprintf("UPDATE systems_for_matrix SET name_system ='%s' WHERE id_systems = ('%s');", trim($name_system), trim($id_name_system));
        $this->load->model("Model_it");
        $this->Model_it->add($query);
        print_r($query);
    }

/*AJAX Добавление пользователя в матрицу*/
    function add_name_user_matrix(){
        $name_user = $this->input->post("name_user");
        $name_PC = $this->input->post("name_PC");
        $name_group = $this->input->post("name_group");
        $checkbox_name_systems_checked = $this->input->post("checkbox_name_systems_checked");
        $array_name_systems = implode(",", $checkbox_name_systems_checked);
        $query = sprintf("INSERT INTO matrix (id_number_department, name_user, name_workstation, name_systems) 
                                 VALUES ('%s','%s','%s','%s');", trim($name_group), trim($name_user), trim($name_PC), trim($array_name_systems));
        $this->load->model("Model_it");
        $this->Model_it->add($query);
    }

/*AJAX Удаление пользователя из матрицы*/
    function delete_name_user(){
        $id_name_user = $this->input->post("id_name_user");
        $query = sprintf("DELETE FROM matrix WHERE id_matrix = '%s';", trim($id_name_user));
        $this->load->model("Model_it");
        $this->Model_it->add($query);
    }
}