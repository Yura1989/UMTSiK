<?php 
defined('BASEPATH') OR exit ('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Model_db extends CI_Model
{
    /*Создание пользователя*/
    function createUser ($query){
        $this->db->query($query);
    }

    /*Выгрузка всех пользователей*/
    function showUsers ($query){
        $result = $this->db->query($query);
        return $result->result_array();
    }
    
    /*Удаление пользователя*/
    function deleteUser ($query){
        $this->db->query($query);
    }
    /*-------------------------------------------------------------------*/

    /*Сохранение в таблицу order_mtr*/
    function saveOrder ($query){
        $this->db->query($query);
    }

    /*Удаление строки из таблицы order_mtr*/
    function delete_Row_Table ($query){
        $this->db->query($query);
    }

    /*-------------------------------------------------------------------*/
    
    /*Поиск ID ордера или поиск строк распоряжения */
    function select_id_all_order ($query){
        $result = $this->db->query($query);
        return $result->result_array();
    }

    /*-------------------------------------------------------------------*/
    
    /*Сохранение в таблицу all_orders*/
    function saveAllOrder ($query){
        $this->db->query($query);
        $row = $this->db->insert_id();
        return $row;
    }
    
    /*Удаление распоряжения по ID*/
    function delete_id_all_order ($query){
        $result = $this->db->query($query);
        return $result;
    }

    /*-------------------------------------------------------------------*/

    /*Сохранение в таблицу motion*/
    function saveMotion ($query){
            $this->db->query($query);
            $row = $this->db->insert_id();
            return $row;
    }

    /*Удаление Motion по ID*/
    function delete_id_all_motion ($query){
        $result = $this->db->query($query);
        return $result;
    }

    /*Удаление строки из таблицы motion*/
    function delete_Row_Motion($query){
        $this->db->query($query);
    }

    /*-------------------------------------------------------------------*/

    /*Работа со справочниками*/
    function create_edit_delete($query){
        $this->db->query($query);
    }

    function show($query){
       $result = $this->db->query($query);
        return $result->result_array();
    }

    function export_XLSX($query){
        foreach ($query as $exit):

        endforeach;


//        $spreadsheet = new Spreadsheet();
//        $sheet = $spreadsheet->getActiveSheet();
//        $sheet->setCellValue('A1', "1");
//
//        $writer = new Xlsx($spreadsheet);
//
//        $filename = 'SampleOrder';
//
//        header('Content-Type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
//        header('Cache-Control: max-age=0');
//
//        $writer->save('php://output'); // download file
    }
}
?>