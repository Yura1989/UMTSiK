<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Main extends CI_Controller {

   /*Авторизация пользователей*/
	public function index(){
		if (!isset ($_POST['username']) || !isset($_POST['password']))
		{
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		} else {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$query = sprintf ("SELECT id_user, sername, name, patronymic, username, password, department, n_sklad, n_filial, name_sklad FROM users u, sklads s WHERE u.n_sklad=s.id_sklad AND username = '%s';", trim($username));
			$result = $this->db->query($query);
			$hash = $result->result_array();

			if (($result->num_rows() == 1) && (password_verify($password, $hash['0']['password']))) {
				$query_actions = sprintf ("SELECT * FROM actions WHERE id_bond_users = '%s';", $hash['0']['id_user']);
				$this->load->model('Model_db');
				$result_actions = $this->Model_db->showUsers($query_actions);
				$array_user_data = array(
					'sername' 	=> $hash['0']['sername'],
					'name' 		=> $hash['0']['name'],
					'patronymic'=> $hash['0']['patronymic'],
					'username' 	=> $username,
					'department'=> $hash['0']['department'],
					'n_sklad'	=> $hash['0']['name_sklad'],
					'n_filial'	=> $hash['0']['n_filial'],
					'actions' 	=> array(
								'edit_order'	=> 	$result_actions['0']['edit_order'],
								'show_order'	=> 	$result_actions['0']['show_order'],
								'show_all_orders'	=> 	$result_actions['0']['show_all_orders'],
								'delete_order'	=> 	$result_actions['0']['delete_order'],
								'edit_motion'	=> 	$result_actions['0']['edit_motion'],
								'show_motion'	=>	$result_actions['0']['show_motion'],
								'show_all_motions'	=>	$result_actions['0']['show_all_motions'],
								'delete_motion'	=> 	$result_actions['0']['delete_motion'],
                                'print_orders'	=> 	$result_actions['0']['print_orders'],
								'return_edit_orders'	=> 	$result_actions['0']['return_edit_orders'],
								'filial_edit_motion'	=> 	$result_actions['0']['filial_edit_motion'], //Роль для участков
								'edit_datas'	=> 	$result_actions['0']['edit_datas'],
								'admin' 		=> 	$result_actions['0']['admin'],
					)
				);
				$this->session->set_userdata($array_user_data);
//Запрос к базе на извлечение последних добавленных 10 распоряжений
				$query_order_status = sprintf("SELECT DATE_FORMAT(date_order,'%%d.%%m.%%Y'), number_order, name_sklad, flag, date_order, sername, name, patronymic, position, department FROM all_orders o JOIN users u ON o.author_order=u.username ORDER BY date_order DESC LIMIT 1000;");
				$result_order['orders'] = $this->Model_db->select_id_all_order($query_order_status);
				$query_motion = sprintf("SELECT * FROM all_motion ORDER BY date_create_motion DESC LIMIT 1000;");
				$result_order['all_motion'] = $this->Model_db->select_id_all_order($query_motion);
				$n =count($result_order['all_motion']);
				$i = 0;

				while ($i < $n){
					$query_order = sprintf("SELECT * FROM all_orders WHERE bond_guid_motion = '%s'", trim($result_order['all_motion'][$i]['number_motion']));
					$result_order['name_order'] = $this->Model_db->select_id_all_order($query_order);
					$result_order['new_mas'][$i] = $result_order['name_order'];
					$i++;
				}

				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_main', $result_order);
				$this->load->view('template/view_footer');
			} else {
				$error['login'] = "Неправильное имя пользователя или пароль";
				$this->load->view('template/view_header');
				$this->load->view('view_auth', $error);
				$this->load->view('template/view_footer');
			}
		}
	}
	
	/*------------------------------------------------------------------------*/
//Главная страницы
	function main_page(){
		$_username = $this->session->userdata('username');
		if (isset ($_username)) {
			$this->load->model('Model_db');
//Запрос к базе на извлечение последних добавленных 10 распоряжений
			$query_order_status = sprintf("SELECT DATE_FORMAT(date_order,'%%d.%%m.%%Y'), number_order, name_sklad, flag, date_order, sername, name, patronymic, position, department FROM all_orders o JOIN users u ON o.author_order=u.username ORDER BY date_order DESC LIMIT 1000;");
			$result_order['orders'] = $this->Model_db->select_id_all_order($query_order_status);

			$query_motion = sprintf("SELECT * FROM all_motion ORDER BY date_create_motion DESC LIMIT 1000;");
			$result_order['all_motion'] = $this->Model_db->select_id_all_order($query_motion);
			$n =count($result_order['all_motion']);
			$i = 0;

			while ($i < $n){
				$query_order = sprintf("SELECT * FROM all_orders WHERE bond_guid_motion = '%s'", trim($result_order['all_motion'][$i]['number_motion']));
				$result_order['name_order'] = $this->Model_db->select_id_all_order($query_order);
				$result_order['new_mas'][$i] = $result_order['name_order'];
				$i++;
			}

			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('view_main', $result_order);
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}
	
/*Очистка сессиий*/
	function exit_session(){
		$this->session->unset_userdata('username');
		$this->load->view('template/view_header');
		$this->load->view('view_auth');
		$this->load->view('template/view_footer');
	}

/*Выгрузка всех пользователей*/
	function showUsers(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
			$query = sprintf("SELECT id_user, sername, name, patronymic, username, email FROM users ORDER BY date_create;");
			$this->load->model('Model_db');
			$result['users'] = $this->Model_db->showUsers($query);
			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('view_showUsers', $result);
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

/*Создание пользователей*/
	function createUser(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
			$query_department = sprintf("SELECT * FROM departments;");
			$query_sklad = sprintf("SELECT * FROM sklads;");
			$query_filial = sprintf("SELECT * FROM filials;");
			$this->load->model('Model_db');
			$result['deparments'] = $this->Model_db->showUsers($query_department);
			$result['sklad'] = $this->Model_db->showUsers($query_sklad);
			$result['filial'] = $this->Model_db->showUsers($query_filial);
			if (isset($_POST['buttoncreateuser'])) {
				$sername = $this->input->post('sername');
				$name = $this->input->post('name');
				$patronymic = $this->input->post('patronymic');
				$position = $this->input->post('position');
				$department = $this->input->post('department');
				$name_sklad = $this->input->post('sklad');
				$filial = $this->input->post('filial');
				$email = $this->input->post('email');
				$username = $this->input->post('username');
				$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				$date_create = date('Y-m-d');
				$query = sprintf("INSERT INTO users (sername, name, patronymic, email, position, department, n_sklad, n_filial, username, password, date_create) 
								VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
					trim($sername), trim($name), trim($patronymic), trim($email), trim($position), trim($department), trim($name_sklad), trim($filial), trim($username), trim($password), trim($date_create));
				$this->load->model('Model_db');
				$this->Model_db->createUser($query);

				$query_select_id = sprintf("SELECT id_user FROM users WHERE sername='%s' AND name='%s' AND email='%s';",
					trim($sername), trim($name), trim($email));
				$id_user_action = $this->Model_db->showUsers($query_select_id);

				$n = count($_POST['for']);
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'show_order') {
						$show_order = TRUE;
						break;
					} else $show_order = 0;
				}

				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'show_all_orders') {
						$show_all_orders = TRUE;
						break;
					} else $show_all_orders = 0;
				}

				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'show_motion') {
						$show_motion = TRUE;
						break;
					} else $show_motion = 0;
				}

				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'show_all_motions') {
						$show_all_motions = TRUE;
						break;
					} else $show_all_motions = 0;
				}

				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'edit_order') {
						$edit_order = TRUE;
						break;
					} else $edit_order = 0;
				}

				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'edit_motion') {
						$edit_motion = TRUE;
						break;
					} else $edit_motion = 0;
				}

				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'edit_datas') {
						$edit_datas = TRUE;
						break;
					} else $edit_datas = 0;
				}

				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'delete_order') {
						$delete_order = TRUE;
						break;
					} else $delete_order = 0;
				}

				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'delete_motion') {
						$delete_motion = TRUE;
						break;
					} else $delete_motion = 0;
				}

                for ($i = 0; $i < $n; $i++) {
                    if (($_POST['for'][$i]) == 'print_orders') {
                        $print_orders = TRUE;
                        break;
                    } else $print_orders = 0;
                }

				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'admin') {
						$admin = TRUE;
						break;
					} else $admin = 0;
				}

				$query_action = sprintf("INSERT INTO actions (id_bond_users, edit_order, show_order, show_all_orders, delete_order, print_orders, edit_motion, show_motion, show_all_motions,delete_motion, edit_datas, admin) 
								VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
					trim($id_user_action[0]['id_user']), trim($edit_order), trim($show_order), trim($show_all_orders), trim($delete_order), trim($edit_motion), trim($show_motion), trim($show_all_motions), trim($delete_motion), trim($print_orders), trim($edit_datas), trim($admin));
				$this->load->model('Model_db');
				$this->Model_db->createUser($query_action);

				header("Location: showUsers");
			} else {
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_createUser', $result);
				$this->load->view('template/view_footer');
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}
	
/*Удаление пользователей*/
	function deleteUser(){
		$id = $_POST['id'];
		$query = sprintf("DELETE FROM users WHERE id_user = '%s';", trim($id));
		$this->load->model('Model_db');
		$this->Model_db->deleteUser($query);
	}

/*Редактирование пользователей*/
	function editUser(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
			$id = $_REQUEST['user_id'];
			$query_department = sprintf("SELECT * FROM departments;");
			$query_sklad = sprintf("SELECT * FROM sklads;");
			$query_filial = sprintf("SELECT * FROM filials;");
			$query = sprintf("SELECT * FROM users, actions WHERE id_user = '%s' AND users.id_user=actions.id_bond_users;", trim($id));
			$this->load->model('Model_db');
			$result['user'] = $this->Model_db->showUsers($query);
			$result['deparments'] = $this->Model_db->showUsers($query_department);
			$result['sklad'] = $this->Model_db->showUsers($query_sklad);
			$result['filial'] = $this->Model_db->showUsers($query_filial);
			$this->load->library('form_validation');

			if (isset($_POST['BTedituser']) AND isset($_REQUEST['new_pw'])) {

				$this->load->model('Model_users');
				$this->form_validation->set_error_delimiters('<code style=\'color:#ff2352;\'>', '</code>');
				$this->form_validation->set_rules($this->Model_users->editUser('$editUser'));
				if ($this->form_validation->run() == false) {
					$this->load->view('template/view_header');
					$this->load->view('template/view_menu');
					$this->load->view('view_editUser', $result);
					$this->load->view('template/view_footer');
				} else {
					$sername = $this->input->post('sername');
					$name = $this->input->post('name');
					$patronymic = $this->input->post('patronymic');
					$position = $this->input->post('position');
					$department = $this->input->post('department');
					$name_sklad = $this->input->post('sklad');
					$filial = $this->input->post('filial');
					$email = $this->input->post('email');
					$username = $this->input->post('username');
					$password = $this->input->post('password');
					$repassword = $this->input->post('repassword');
					$ids = $_REQUEST['user_id'];
					$date_create = date('Y-m-d, H:i:s');

					if ($password == $repassword) {
						$newpassword = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
					}

					$n = count($_POST['for']);
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'show_order') {
							$show_order = TRUE;
							break;
						} else $show_order = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'show_all_orders') {
							$show_all_orders = TRUE;
							break;
						} else $show_all_orders = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'show_motion') {
							$show_motion = TRUE;
							break;
						} else $show_motion = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'show_all_motions') {
							$show_all_motions = TRUE;
							break;
						} else $show_all_motions = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'edit_order') {
							$edit_order = TRUE;
							break;
						} else $edit_order = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'edit_motion') {
							$edit_motion = TRUE;
							break;
						} else $edit_motion = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'delete_order') {
							$delete_order = TRUE;
							break;
						} else $delete_order = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'delete_motion') {
							$delete_motion = TRUE;
							break;
						} else $delete_motion = 0;
					}
                    for ($i = 0; $i < $n; $i++) {
                        if (($_POST['for'][$i]) == 'print_orders') {
                            $print_orders = TRUE;
                            break;
                        } else $print_orders = 0;
                    }
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'return_edit_orders') {
							$return_edit_orders = TRUE;
							break;
						} else $return_edit_orders = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'filial_edit_motion') {
							$filial_edit_motion = TRUE;
							break;
						} else $filial_edit_motion = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'edit_datas') {
							$edit_datas = TRUE;
							break;
						} else $edit_datas = 0;
					}
					for ($i = 0; $i < $n; $i++) {
						if (($_POST['for'][$i]) == 'admin') {
							$admin = TRUE;
							break;
						} else $admin = 0;
					}

					$query = sprintf("UPDATE users 
										SET 
										sername = ('%s'), 
										name = ('%s'), 
										patronymic = ('%s'), 
										email = ('%s'), 
										position = ('%s'), 
										department = ('%s'),
										n_sklad = ('%s'),
										n_filial = ('%s'),
										username = ('%s'), 
										password = ('%s'), 
										date_create = ('%s') 
									WHERE id_user = '%s';",
						trim($sername), trim($name), trim($patronymic), trim($email), trim($position), trim($department), trim($name_sklad), trim($filial), trim($username), trim($newpassword), trim($date_create), trim($ids));
					$this->load->model('Model_db');
					$this->Model_db->createUser($query);

					$query_actions = sprintf("UPDATE actions 
										SET 
										edit_order = ('%s'), 
										show_order = ('%s'), 
										show_all_orders = ('%s'), 
										delete_order = ('%s'), 
										edit_motion = ('%s'), 
										show_motion = ('%s'), 
										show_all_motions = ('%s'), 
										delete_motion = ('%s'),
										print_orders = ('%s'),
										return_edit_orders = ('%s'),
										filial_edit_motion = ('%s'),
										edit_datas = ('%s'), 
										admin = ('%s')
									WHERE id_bond_users = '%s';",
						trim($edit_order), trim($show_order), trim($show_all_orders), trim($delete_order), trim($edit_motion), trim($show_motion), trim($show_all_motions), trim($delete_motion), trim($print_orders), trim($return_edit_orders), trim($filial_edit_motion), trim($edit_datas), trim($admin), trim($ids));
					$this->Model_db->createUser($query_actions);

					header("Location: showUsers");
				}
			} elseif (isset($_POST['BTedituser'])) {

				$sername = $this->input->post('sername');
				$name = $this->input->post('name');
				$patronymic = $this->input->post('patronymic');
				$position = $this->input->post('position');
				$department = $this->input->post('department');
				$name_sklad = $this->input->post('sklad');
				$filial = $this->input->post('filial');
				$email = $this->input->post('email');
				$username = $this->input->post('username');
				$ids = $_REQUEST['user_id'];
				$date_create = date('Y-m-d, H:i:s');

				$n = count($_POST['for']);
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'show_order') {
						$show_order = TRUE;
						break;
					} else $show_order = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'show_all_orders') {
						$show_all_orders = TRUE;
						break;
					} else $show_all_orders = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'show_motion') {
						$show_motion = TRUE;
						break;
					} else $show_motion = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'show_all_motions') {
						$show_all_motions = TRUE;
						break;
					} else $show_all_motions = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'edit_order') {
						$edit_order = TRUE;
						break;
					} else $edit_order = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'edit_motion') {
						$edit_motion = TRUE;
						break;
					} else $edit_motion = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'delete_order') {
						$delete_order = TRUE;
						break;
					} else $delete_order = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'delete_motion') {
						$delete_motion = TRUE;
						break;
					} else $delete_motion = 0;
				}
                for ($i = 0; $i < $n; $i++) {
                    if (($_POST['for'][$i]) == 'print_orders') {
                        $print_orders = TRUE;
                        break;
                    } else $print_orders = 0;
                }
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'return_edit_orders') {
						$return_edit_orders = TRUE;
						break;
					} else $return_edit_orders = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'filial_edit_motion') {
						$filial_edit_motion = TRUE;
						break;
					} else $filial_edit_motion = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'edit_datas') {
						$edit_datas = TRUE;
						break;
					} else $edit_datas = 0;
				}
				for ($i = 0; $i < $n; $i++) {
					if (($_POST['for'][$i]) == 'admin') {
						$admin = TRUE;
						break;
					} else $admin = 0;
				}

				$query = sprintf("UPDATE users 
										SET 
										sername = ('%s'), 
										name = ('%s'), 
										patronymic = ('%s'), 
										email = ('%s'), 
										position = ('%s'), 
										department = ('%s'),
										n_sklad = ('%s'),
										n_filial = ('%s'),
										username = ('%s'), 
										date_create = ('%s') 
									WHERE id_user = '%s';",
					trim($sername), trim($name), trim($patronymic), trim($email), trim($position), trim($department), trim($name_sklad), trim($filial), trim($username), trim($date_create), trim($ids));
				$this->load->model('Model_db');
				$this->Model_db->createUser($query);

				$query_actions = sprintf("UPDATE actions 
										SET 
										edit_order = ('%s'), 
										show_order = ('%s'), 
										show_all_orders = ('%s'), 
										delete_order = ('%s'), 
										edit_motion = ('%s'), 
										show_motion = ('%s'), 
										show_all_motions = ('%s'), 
										delete_motion = ('%s'),
										print_orders = ('%s'),
										return_edit_orders = ('%s'),
										filial_edit_motion = ('%s'),
										edit_datas = ('%s'), 
										admin = ('%s')
									WHERE id_bond_users = '%s';",
					trim($edit_order), trim($show_order), trim($show_all_orders), trim($delete_order), trim($edit_motion), trim($show_motion), trim($show_all_motions), trim($delete_motion), trim($print_orders), trim($return_edit_orders), trim($filial_edit_motion), trim($edit_datas), trim($admin), trim($ids));
				$this->Model_db->createUser($query_actions);

				header("Location: showUsers");
			} else {
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_editUser', $result);
				$this->load->view('template/view_footer');
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

/*------------------------------------------------------------------------*/
/*Вывод поиска по Распоряжениям в разрезе даты заполнения распоряжения*/
	function range_date_orders(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && ((($_actions['edit_order']) == 1)) || (($_actions['show_order']) == 1) || (($_actions['show_all_orders']) == 1)) {
			$query_users = sprintf("SELECT department, sername, name, patronymic FROM users WHERE username = '%s';", trim($_username));
			$query_10 = sprintf("SELECT * FROM all_orders ORDER BY date_order DESC LIMIT 1000;");
			$this->load->model('Model_db');
			$result['orders'] = $this->Model_db->select_id_all_order($query_10);
			$result['users'] = $this->Model_db->showUsers($query_users);
			if (isset($_POST['search_name_order'])) {
				$order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
				$order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
				$order['number_order'] = $this->input->post('number_order');
				$order['name_MTR'] = $this->input->post('name_MTR');

//Промежуток дат
				if ( (($order['start_date']) != '1970-01-01') && (($order['end_date']) != '1970-01-01') ) {
					$filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
					$filter_new[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
				}

//Номер распоряжения
				if (($order['number_order']) != NULL) {
					$filter[] = sprintf("number_order LIKE '%%%s%%'", trim($order['number_order']));
					$filter_new[] = sprintf("number_order LIKE '%%%s%%'", trim($order['number_order']));
				}

//Наименование МТР
				if (($order['name_MTR']) != NULL) {
					$filter[] = sprintf("nameMTR LIKE '%%%s%%'", trim($order['name_MTR']));
				}

//Формирование запроса в зависимости от фильтров
				if (($order['name_MTR']) != NULL) {
					$query = "SELECT distinct number_order, date_order, id_all_orders, a.author_order, create_department, flag FROM all_orders a JOIN order_mtr o ON a.id_all_orders=o.id_bond_all_orders";
					$query .= ' WHERE ' . implode(' AND ', $filter) . ';';
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query);
				} elseif (!empty($filter)) {
					$query_new_order = "SELECT number_order, date_order, id_all_orders, create_department, author_order, flag FROM all_orders";
					$query_new_order .= ' WHERE ' . implode(' AND ', $filter_new) . ';';
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query_new_order);
				} else {
					$query = "SELECT * FROM all_orders;";
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query);
				}

				if (count($result['orders']) == 0) {
					$result['flag'] = count($result['orders']);
				}
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_range_date_orders', $result);
				$this->load->view('template/view_footer');
			} else {
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_range_date_orders', $result);
				$this->load->view('template/view_footer');
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

/*Вывод поиска по Распоряжениям для печати*/
    function print_orders(){
        $_username = $this->session->userdata('username');
        $_actions = $this->session->userdata('actions');
        if (isset ($_username) && ((($_actions['print_orders']) == 1)) ) {
            $query_users = sprintf("SELECT department, sername, name, patronymic FROM users WHERE username = '%s';", trim($_username));
            $query_10 = sprintf("SELECT * FROM all_orders ORDER BY date_order DESC LIMIT 1000;");
            $this->load->model('Model_db');
            $result['orders'] = $this->Model_db->select_id_all_order($query_10);
            $result['users'] = $this->Model_db->showUsers($query_users);
            if (isset($_POST['search_name_order'])) {
                $order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
                $order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
                $order['number_order'] = $this->input->post('number_order');
                $order['name_MTR'] = $this->input->post('name_MTR');

//Промежуток дат
                if ((($order['start_date']) != "1970-01-01") && (($order['end_date']) != "1970-01-01")) {
                    $filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                    $filter_new[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                }

//Номер распоряжения
                if (($order['number_order']) != NULL) {
                    $filter[] = sprintf("number_order LIKE '%%%s%%'", trim($order['number_order']));
                    $filter_new[] = sprintf("number_order LIKE '%%%s%%'", trim($order['number_order']));
                }

//Наименование МТР
                if (($order['name_MTR']) != NULL) {
                    $filter[] = sprintf("nameMTR LIKE '%%%s%%'", trim($order['name_MTR']));
                }

//Формирование запроса в зависимости от фильтров
                if (($order['name_MTR']) != NULL) {
                    $query = "SELECT distinct number_order, date_order, id_all_orders, a.author_order, create_department, flag FROM all_orders a JOIN order_mtr o ON a.id_all_orders=o.id_bond_all_orders";
                    $query .= ' WHERE ' . implode(' AND ', $filter) . ';';
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query);
                } elseif (!empty($filter)) {
                    $query_new_order = "SELECT number_order, date_order, id_all_orders, create_department, author_order, flag FROM all_orders";
                    $query_new_order .= ' WHERE ' . implode(' AND ', $filter_new) . ';';
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query_new_order);
                } else {
                    $query = "SELECT * FROM all_orders ORDER BY date_order DESC LIMIT 1000;";
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query);
                }

                if (count($result['orders']) == 0) {
                    $result['flag'] = count($result['orders']);
                }
                $this->load->view('template/view_header');
                $this->load->view('template/view_menu');
                $this->load->view('view_print_orders', $result);
                $this->load->view('template/view_footer');

            } elseif (isset($_GET['search_printering_order'])){
                $query_users = sprintf("SELECT department, sername, name, patronymic FROM users WHERE username = '%s';", trim($_username));
                $query = sprintf("SELECT * FROM all_orders o WHERE o.id_all_orders not in (SELECT id_bond_all_orders_print FROM print_orders) ORDER BY date_order DESC ;");
                $this->load->model('Model_db');
                $result['orders'] = $this->Model_db->select_id_all_order($query);
                $result['users'] = $this->Model_db->showUsers($query_users);
                $this->load->view('template/view_header');
                $this->load->view('template/view_menu');
                $this->load->view('view_print_orders', $result);
                $this->load->view('template/view_footer');
            } else {
                $this->load->view('template/view_header');
                $this->load->view('template/view_menu');
                $this->load->view('view_print_orders', $result);
                $this->load->view('template/view_footer');
            }
        } else {
            $this->load->view('template/view_header');
            $this->load->view('view_auth');
            $this->load->view('template/view_footer');
        }
    }

    function print_action_orders(){
        $id_order = $this->input->post('id_order');
        $author_print = $this->session->userdata('username');
        $date_print = date("Y-m-d");
        $status = 1;
        $query = sprintf("INSERT INTO print_orders (id_bond_all_orders_print, status, author_print, date_print) VALUE ('%s', '%s', '%s' , '%s');", trim($id_order),  trim($status), trim($author_print), trim($date_print));
        $query_update = sprintf("UPDATE all_orders SET status_print='1' WHERE id_all_orders='%s';", trim($id_order));
        $this->load->model('Model_db');
        $this->Model_db->saveAllOrder($query);
        $this->Model_db->saveAllOrder($query_update);
    }

/*Удаление Распоряжения*/
	function deleteOrder(){
		$id = $this->input->post('id');
		$query = sprintf("DELETE FROM all_orders WHERE id_all_orders='%s';", trim($id));
		$this->load->model('Model_db');
		$result = $this->Model_db->delete_id_all_order($query);
		print_r($result);
	}

/*Форма создания Распоряжения*/
	function create_edit_order(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && ((($_actions['edit_order']) == 1) || (($_actions['show_order']) == 1) || (($_actions['show_all_orders']) == 1) ) ) {
			if (isset($_GET['id_order'])) {
				$query_order = sprintf("SELECT * FROM all_orders WHERE id_all_orders='%s';", trim($_GET['id_order']));
				$query_sklads = sprintf("SELECT * FROM sklads ORDER BY name_sklad;");
				$query_filials = sprintf("SELECT * FROM filials;");
				$this->load->model('Model_db');
//Запрос к базе на извлечение ФИО сотрудника создавшего распоряжение
				$result['info_order'] = $this->Model_db->select_id_all_order($query_order);
				$query_author = sprintf("SELECT sername, name, patronymic, department FROM users WHERE username = '%s';", trim($result['info_order'][0]['author_order']));
				$result['author'] = $this->Model_db->select_id_all_order($query_author);
				$result['sklads'] = $this->Model_db->select_id_all_order($query_sklads);
				$result['filials'] = $this->Model_db->select_id_all_order($query_filials);
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_create_order', $result);
				$this->load->view('template/view_footer');
			} else {
				$query_sklads = sprintf("SELECT * FROM sklads ORDER BY name_sklad;");
				$query_filials = sprintf("SELECT * FROM filials ORDER BY name_filial;");
				$query_department = sprintf("SELECT * FROM users u, departments d WHERE u.department=d.id_department AND username='%s';", trim($_username));
				$query_max_id = sprintf("SELECT MAX(id_all_orders) m FROM all_orders;");
				$this->load->model('Model_db');
				$result['sklads'] = $this->Model_db->select_id_all_order($query_sklads);
				$result['filials'] = $this->Model_db->select_id_all_order($query_filials);
				$result['department'] = $this->Model_db->select_id_all_order($query_department); //выборка номера отдела по авторизованному пользователю
				$result['max_id'] = $this->Model_db->select_id_all_order($query_max_id); //выборка последнего добавленного номера распоряжения
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_create_order', $result);
				$this->load->view('template/view_footer');
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

/*Форма по заполнению Распоряжения*/
	function formation_order(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && ((($_actions['edit_order']) == 1) || (($_actions['show_order']) == 1) || (($_actions['show_all_orders']) == 1) ) ) {

				if(isset($_POST['import']) && isset($_FILES)) {
				    if ($_FILES['fileURL']['error'] == 0 ){
                        $inputFileType = 'Xlsx';
                        $reader = IOFactory::createReader($inputFileType);
                        $reader->setReadDataOnly(true);
                        $spreadsheet = $reader->load($_FILES['fileURL']['tmp_name']);

                        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                        $createArray = array('codeMTR',  'numberPart', 'nameMTR', 'ukObjectMTR', 'numberObjectMTR', 'sizeMTR', 'sumMTR', 'filialMTR', 'deliveryMTR', 'noteMTR');
                        $SheetDataKey = array();
                        foreach($sheetData as $dataInSheet) {
                            foreach ($dataInSheet as $key => $value) {
                                if (in_array(trim($value), $createArray)) {
                                    $value = preg_replace('/\s+/', '', $value);
                                    $SheetDataKey[trim($value)] = $key;
                                }
                            }
                        }
                        if (count($sheetData[10]) == 11){
                            if (isset($sheetData[11])) {
                                for($row=11; $row <= count($sheetData); $row++) {
                                    $codeMTR = $SheetDataKey['codeMTR'];
                                    $numberPart = $SheetDataKey['numberPart'];
                                    $nameMTR = $SheetDataKey['nameMTR'];
                                    $ukObjectMTR = $SheetDataKey['ukObjectMTR'];
                                    $numberObjectMTR = $SheetDataKey['numberObjectMTR'];
                                    $sizeMTR = $SheetDataKey['sizeMTR'];
                                    $sumMTR = $SheetDataKey['sumMTR'];
                                    $filialMTR = $SheetDataKey['filialMTR'];
                                    $deliveryMTR = $SheetDataKey['deliveryMTR'];
                                    $noteMTR = $SheetDataKey['noteMTR'];

                                    $codeMTR = filter_var(trim($sheetData[$row][$codeMTR]), FILTER_SANITIZE_STRING);
                                    $numberPart = filter_var(trim($sheetData[$row][$numberPart]), FILTER_SANITIZE_STRING);
                                    $nameMTR = filter_var(trim($sheetData[$row][$nameMTR]), FILTER_SANITIZE_STRING);
                                    $ukObjectMTR = filter_var(trim($sheetData[$row][$ukObjectMTR]), FILTER_SANITIZE_STRING);
                                    $numberObjectMTR = filter_var(trim($sheetData[$row][$numberObjectMTR]), FILTER_SANITIZE_STRING);
                                    $sizeMTR = filter_var(trim($sheetData[$row][$sizeMTR]), FILTER_SANITIZE_STRING);
                                    $sumMTR = filter_var(trim($sheetData[$row][$sumMTR]), FILTER_SANITIZE_STRING);
                                    $filialMTR = filter_var(trim($sheetData[$row][$filialMTR]), FILTER_SANITIZE_STRING);
                                    $deliveryMTR = filter_var(trim($sheetData[$row][$deliveryMTR]), FILTER_SANITIZE_STRING);
                                    $noteMTR = filter_var(trim($sheetData[$row][$noteMTR]), FILTER_SANITIZE_STRING);
                                    $fetchData[] = array(	'codeMTR' => $codeMTR,
                                        'numberPart' => $numberPart,
                                        'nameMTR' => $nameMTR,
                                        'ukObjectMTR' => $ukObjectMTR,
                                        'numberObjectMTR' => $numberObjectMTR,
                                        'sizeMTR' => $sizeMTR,
                                        'sumMTR' => $sumMTR,
                                        'filialMTR' => $filialMTR,
                                        'deliveryMTR' => $deliveryMTR,
                                        'noteMTR' => $noteMTR);

                                }
                                $result['dataInfo'] = $fetchData;
                            } else { ?>
                                <script>alert("Ошибка заполнения таблицы, в таблицы отсутствуют данные");</script>
                            <?php }
                        } else { ?>
                            <script>alert("Ошибка заполнения таблицы, обнаружено неверное кол-во стоблцов");</script>
                            <?php }
                    } else { ?>
				        <script>alert("Ошибка загрузки файла");</script>
                    <?php }
				}

				$query_order = sprintf("SELECT * FROM all_orders WHERE id_all_orders='%s';", trim($_GET['id_all_order']));
				$query = sprintf("SELECT * FROM order_mtr WHERE id_bond_all_orders='%s' ORDER BY filialMTR;", trim($_GET['id_all_order']));

				$query_sklads = sprintf("SELECT * FROM sklads;");
				$query_objects = sprintf("SELECT * FROM objects;");
				$query_filials = sprintf("SELECT * FROM filials;");
				$query_delivery_modes = sprintf("SELECT * FROM delivery_modes;");
				$query_measures = sprintf("SELECT * FROM measures WHERE show_measures=0;");
				$this->load->model('Model_db');
				$result['info_order'] = $this->Model_db->select_id_all_order($query_order);
//Запрос к базе на извлечение филиалов изходя из участка
				$query_lpu = sprintf("SELECT name_lpu FROM lpu l, filials f, all_orders o WHERE l.id_bond_filials=f.id_filial AND o.address_order=f.name_filial AND o.id_all_orders='%s' AND show_lpu = 0;", trim($result['info_order'][0]['id_all_orders']));
//Запрос к базе на извлечение ФИО сотрудника создавшего распоряжение
				$query_author = sprintf("SELECT sername, name, patronymic, department FROM users WHERE username = '%s';", trim($result['info_order'][0]['author_order']));
				$result['author'] = $this->Model_db->select_id_all_order($query_author);
//Запросы к базе
				$result['order'] = $this->Model_db->select_id_all_order($query);
				$result['lpu'] = $this->Model_db->select_id_all_order($query_lpu);
				$result['sklads'] = $this->Model_db->select_id_all_order($query_sklads);
				$result['objects'] = $this->Model_db->select_id_all_order($query_objects);
				$result['filials'] = $this->Model_db->select_id_all_order($query_filials);
				$result['delivery_modes'] = $this->Model_db->select_id_all_order($query_delivery_modes);
				$result['measures'] = $this->Model_db->select_id_all_order($query_measures);
				$this->load->view('view_order', $result);
		}else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

/*Занесении информации о созданном ордере в таблицу all_orders*/
	function saveOrder()
	{
		/*Формирование запроса на добавление инфы в таблицу all_orders*/
		$order['number_order_id'] = $this->input->post('number_order');
		$order['date_order_id'] = date('Y-m-d', strtotime($this->input->post('date_order')));
		$order['address_order_id'] = $this->input->post('address_order');
		$order['name_sklad_id'] = $this->input->post('name_sklad');
		$order['author_order_id'] = $this->session->userdata('username');
		$query_name_department = sprintf("SELECT department FROM users WHERE username ='%s';", trim($order['author_order_id']));
		$this->load->model('Model_db');
		$result['name_department'] = $this->Model_db->select_id_all_order($query_name_department);
            $query_all_orders = sprintf("INSERT INTO all_orders (number_order, 
															 date_order, 
															 address_order,
															 name_sklad,
															 author_order,
															 create_department)
												VALUES ('%s', '%s', '%s', '%s', '%s', '%s');",
                trim($order['number_order_id']),
                $order['date_order_id'],
                trim($order['address_order_id']),
                $order['name_sklad_id'],
                trim($order['author_order_id']),
                trim($result['name_department'][0]['department']));

            $this->load->model('Model_db');
            $this->Model_db->saveAllOrder($query_all_orders);
            /*Получаем ID ордера по которому добавляются(вносятся) изменения*/
            $query_id = sprintf("SELECT id_all_orders FROM all_orders WHERE number_order='%s' AND date_order='%s';", trim($order['number_order_id']), trim($order['date_order_id']));
            $result['id_order'] = $this->Model_db->select_id_all_order($query_id);
            print_r($result['id_order'][0]['id_all_orders']);
	}

/*Проверка номера распоряжения*/
	function validation_order_number(){
        $order['number_order_id'] = $this->input->post('number_order');
        $query_search = sprintf("SELECT number_order FROM all_orders WHERE number_order='%s'", trim($order['number_order_id']));
        $this->load->model('Model_db');
        $search = $this->Model_db->select_id_all_order($query_search);
//        print_r($search);
        if (empty($search)) {
            Print_r(TRUE);
        } else {
            Print_r(FALSE);
        }
    }

/*Сохранение изменных данных*/
	function saveEditOrder(){
		/*Формирование запроса на добавление инфы в таблицу all_orders*/
		$order['number_order'] = $this->input->post('number_order');
		$order['date_order'] = date('Y-m-d', strtotime($this->input->post('date_order')));
		$order['address_order'] = $this->input->post('address_order');
        $order['name_sklad'] = $this->input->post('name_sklad');
		$order['id_order'] = $this->input->post('id_order');
		$order['author_order'] = $this->session->userdata('username');
			$query_edit_order = sprintf("UPDATE all_orders SET number_order = ('%s'),
															   date_order = ('%s'),
															   address_order = ('%s'),
															   name_sklad = ('%s'),
															   author_order = ('%s')
														   WHERE id_all_orders = '%s';",
												trim($order['number_order']),
												$order['date_order'],
												trim($order['address_order']),
												$order['name_sklad'],
												trim($order['author_order']),
												trim($order['id_order']));
		$this->load->model('Model_db');
		$this->Model_db->saveAllOrder($query_edit_order);
		print_r("Запись в таблицу all_orders");
	}

/*AJAX Этап завершения при приеме распоряжения*/
	function endAllOrder(){
		$id = $this->input->post('id_order');
		$date = date('Y-m-d');
		$query = sprintf("UPDATE all_orders SET date_order='%s', flag = 20 WHERE id_all_orders='%s';", trim($date), trim($id));
		$this->load->model('Model_db');
		$this->Model_db->saveOrder($query);
		print_r("end game");
	}

/*AJAX Этап завершения при приеме распоряжения*/
	function OrderNach(){
		$id = $this->input->post('id_order');
		$query = sprintf("UPDATE all_orders SET flag = 10 WHERE id_all_orders='%s';", trim($id));
		$this->load->model('Model_db');
		$this->Model_db->saveOrder($query);
	}

/*AJAX Этап возврата распоряжения на этап приема*/
	function editendAllOrder(){
		$id = $this->input->post('id_order');
		$query = sprintf("UPDATE all_orders SET flag = 0 WHERE id_all_orders='%s';", trim($id));
		$this->load->model('Model_db');
		$this->Model_db->saveOrder($query);
		print_r("end game");
	}
	
	/*------------------------------------------------------------------------*/
/*AJAX Занесении информации о созданном ордере в таблицу order_mtr*/
	function saveOrderMTR(){
		/*Получаем данные с формы с помощью Ajax запроса*/

        $order['codeMTR'] = json_decode(stripslashes (addslashes($this->input->post('codeMTR'))) );
		$order['numberPartMTR'] = json_decode(stripslashes (addslashes($this->input->post('numberPartMTR'))) );
		$order['nameMTR'] = json_decode(stripslashes (addslashes($this->input->post('nameMTR'))));
		$order['ukObjectMTR'] = json_decode(stripslashes (addslashes($this->input->post('ukObjectMTR'))) );
		$order['numberObjectMTR'] = json_decode(stripslashes (addslashes($this->input->post('numberObjectMTR'))) );
		$order['sizeMTR'] = json_decode(stripslashes (addslashes($this->input->post('sizeMTR'))) );
		$order['sumMTR'] = json_decode(stripslashes (addslashes($this->input->post('sumMTR'))) );
		$order['filialMTR'] = json_decode(stripslashes (addslashes($this->input->post('filialMTR'))) );
		$order['deliveryMTR'] = json_decode(stripslashes (addslashes($this->input->post('deliveryMTR'))) );
		$order['noteMTR'] = json_decode(stripslashes (addslashes($this->input->post('noteMTR'))) );

		$order['number_orderMTR'] = $this->input->post('number_orderMTR');
        $order['date_orderMTR'] = date('Y-m-d', strtotime($this->input->post('date_orderMTR')));
		$order['address_orderMTR'] = $this->input->post('address_orderMTR');
        $order['name_skladMTR'] = $this->input->post('name_skladMTR');
		$order['author_order'] = $this->session->userdata('username');
		$order['datetime'] = date("Y-m-d H:i:s");
		$order['id_order'] = $this->input->post('id_order');

		/*Формируем запрос к базе и заносим данные*/
        for ($i = 0; $i < count($order['codeMTR']); $i++) {
            $order_query[] = "('" . $order['id_order'] . "' ,
			                   '" . $order['codeMTR'][$i] . "',
			                   '" . $order['numberPartMTR'][$i] . "',
			                   '" . $order['nameMTR'][$i] . "',
			                   '" . $order['ukObjectMTR'][$i] . "', 
			                   '" . $order['numberObjectMTR'][$i] . "', 
			                   '" . $order['sizeMTR'][$i] . "', 
			                   '" . $order['sumMTR'][$i] . "',
							   '" . $order['filialMTR'][$i] . "', 
							   '" . $order['deliveryMTR'][$i] . "', 
							   '" . $order['noteMTR'][$i] . "', 
							   '" . $order['number_orderMTR'] . "', 
							   '" . $order['date_orderMTR'] . "', 
							   '" . $order['address_orderMTR'] . "', 
							   '" . $order['name_skladMTR'] . "', 
							   '" . $order['author_order'] . "', 
							   '" . $order['datetime'] . "')";
        }
        
			$query = "INSERT INTO order_mtr (id_bond_all_orders, codeMTR, numberPart, nameMTR, ukObjectMTR, numberObjectMTR, sizeMTR, sumMTR, filialMTR, deliveryMTR, noteMTR, number_orderMTR, date_orderMTR, address_orderMTR, name_skladMTR, author_Order ,create_date_order)
									VALUES" . implode(", ", $order_query);
			$query_flag = sprintf("UPDATE all_orders SET flag = 0 WHERE id_all_orders='%s';", trim($order['id_order'])); //flag status - создание
			$this->load->model('Model_db');
			$this->Model_db->saveOrder($query_flag);
			$this->Model_db->saveOrder($query);
/*Отправляем ID строки*/
			print_r($order['id_order']);
	}

/*AJAX Занесении информации о созданном распоряжении в таблицу order_mtr*/
	function saveEditOrderMTR(){
/*получаем данные с формы с помощью Ajax запроса по общей таблице*/
		$order['id_rowMTR'] = $this->input->post('id_rowMTR');
		$order['id_orderMTR'] = $this->input->post('id_orderMTR');
		$order['codeMTR'] = $this->input->post('codeMTR');
		$order['numberPartMTR'] = $this->input->post('numberPartMTR');
		$order['nameMTR'] = $this->input->post('nameMTR');
		$order['ukObjectMTR'] = $this->input->post('ukObjectMTR');
		$order['numberObjectMTR'] = $this->input->post('numberObjectMTR');
		$order['sizeMTR'] = $this->input->post('sizeMTR');
		$order['sumMTR'] = $this->input->post('sumMTR');
		$order['filialMTR'] = $this->input->post('filialMTR');
		$order['deliveryMTR'] = $this->input->post('deliveryMTR');
		$order['noteMTR'] = $this->input->post('noteMTR');
		$order['number_orderMTR'] = $this->input->post('number_orderMTR');
		$order['date_orderMTR'] = $this->input->post('date_orderMTR');
		$order['address_orderMTR'] = $this->input->post('address_orderMTR');
        $order['name_skladMTR'] = $this->input->post('name_skladMTR');
//		$order['author_Order'] = "Adminovich";
		$order['author_Order'] = $this->session->userdata('username');
		$order['datetime'] = date("Y-m-d H:i:s");

		$query_search = sprintf("SELECT * FROM order_mtr WHERE id_order='%s' AND id_bond_all_orders='%s';",
											   trim($order['id_rowMTR']), trim($order['id_orderMTR']));
		$this->load->model('Model_db');
		$result_search = $this->Model_db->select_id_all_order($query_search);
		if (count($result_search) > 0)
		{
			$query = sprintf ("UPDATE order_mtr SET codeMTR='%s', numberPart='%s', nameMTR='%s', ukObjectMTR='%s', numberObjectMTR='%s', 
													sizeMTR='%s', sumMTR='%s', filialMTR='%s', deliveryMTR='%s', noteMTR='%s', 
													number_orderMTR='%s', date_orderMTR='%s', address_orderMTR='%s', 
													name_skladMTR='%s', author_Order='%s' ,create_date_order='%s'
												WHERE id_order='%s' AND id_bond_all_orders='%s';",
				trim($order['codeMTR']), trim($order['numberPartMTR']), trim($order['nameMTR']), trim($order['ukObjectMTR']), trim($order['numberObjectMTR']),
				trim($order['sizeMTR']), trim($order['sumMTR']), trim($order['filialMTR']),
				trim($order['deliveryMTR']), trim($order['noteMTR']), trim($order['number_orderMTR']), trim($order['date_orderMTR']),
				trim($order['address_orderMTR']), trim($order['name_skladMTR']),
				trim($order['author_Order']), trim($order['datetime']),
                trim($order['id_rowMTR']), trim($order['id_orderMTR']));
			$this->Model_db->saveOrder($query);
			print_r("Внесение изменения в таблицу order_mtr");
		} else {
			$order_row_query[] = "('". $order['id_orderMTR'] . "' , '" . $order['codeMTR'] . "', '" . $order['numberPartMTR'] . "', '" . $order['nameMTR'] . "', '" . $order['ukObjectMTR'] . "' , '" . $order['numberObjectMTR'] . "','" . $order['sizeMTR'] . "', '" . $order['sumMTR'] . "',
					 '" . $order['filialMTR'] . "', '" . $order['deliveryMTR'] . "', '" . $order['noteMTR'] . "', '" . $order['number_orderMTR'] . "', '" . $order['date_orderMTR'] . "', '" . $order['address_orderMTR'] . "', '" . $order['name_skladMTR'] . "','" . $order['author_Order'] . "', '" . $order['datetime'] . "')";
			$query_add_row = "INSERT INTO order_mtr (id_bond_all_orders, codeMTR, numberPart, nameMTR, ukObjectMTR, numberObjectMTR, sizeMTR, sumMTR, filialMTR, deliveryMTR, noteMTR, number_orderMTR, date_orderMTR, address_orderMTR, name_skladMTR, author_Order ,create_date_order)
									VALUES" . implode(", ", $order_row_query);
			$this->Model_db->saveOrder($query_add_row);
			print_r("Добавление новой позиции в таблицу order_mtr");
		}
	}

/*AJAX Удаление строки в Распоряжении*/
	function deleteRowTable(){
		$id = $this->input->post('id');
		$query = sprintf("DELETE FROM order_mtr WHERE id_order='%s';", trim($id));
		$this->load->model('Model_db');
		$this->Model_db->delete_Row_Table($query);
	}


/*AJAX Удаление строки в таблице Motion*/
	function deleteRowMotionTable(){
		$id = $this->input->post('id');
		$query = sprintf("DELETE FROM motion WHERE id_motion='%s';", trim($id));
		$this->load->model('Model_db');
		$this->Model_db->delete_Row_Table($query);
	}

/*------------------------------------------------------------------------*/

/*Создание информации о движении МТР на базе, участке*/
	function create_motion(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && ((($_actions['edit_motion']) == 1)) || (($_actions['show_motion']) == 1) || (($_actions['show_all_motions']) == 1)) {
			$query_sklad = sprintf("SELECT name_sklad FROM sklads ORDER BY name_sklad;");
			$query_10orders = "SELECT distinct name_sklad, address_order, number_order, date_order, u.sername, u.name, u.patronymic, id_all_orders, flag, bond_guid_motion FROM all_orders a JOIN order_mtr o ON a.id_all_orders=o.id_bond_all_orders JOIN users u ON a.author_order=u.username ORDER BY date_order;";
			$this->load->model('Model_db');
			$result['name_sklad'] = $this->Model_db->select_id_all_order($query_sklad);
			$result['orders'] = $this->Model_db->select_id_all_order($query_10orders);
			if (isset($_POST['search_name_order'])) {
				$order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
				$order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
				$order['number_order'] = $this->input->post('number_order');
				$order['name_MTR'] = $this->input->post('nameMTR');
				$order['name_sklad'] = $this->input->post('name_sklad');

//Промежуток дат
				if ((($order['start_date']) != NULL) && (($order['end_date']) != NULL)) {
					$filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
				}

//Номер распоряжения
				if (($order['number_order']) != NULL) {
					$filter[] = sprintf("number_order LIKE '%%%s%%'", trim($order['number_order']));
				}

//Наименование МТР
				if (($order['name_MTR']) != NULL) {
					$filter[] = sprintf("nameMTR LIKE '%%%s%%'", trim($order['name_MTR']));
				}

//Наименование Склада
				if (($order['name_sklad']) != NULL) {
					$filter[] = sprintf("name_sklad LIKE '%%%s%%'", trim($order['name_sklad']));
				}

//Формирование запроса в зависимости от фильтров
				$query = "SELECT distinct name_sklad, address_order, number_order, date_order, u.sername, u.name, u.patronymic, id_all_orders, flag, bond_guid_motion FROM all_orders a JOIN order_mtr o ON a.id_all_orders=o.id_bond_all_orders JOIN users u ON a.author_order=u.username ";
				if (!empty($filter)) {
					$query .= ' WHERE ' . implode(' AND ', $filter) . ';';
				} else {
					$query = "SELECT distinct name_sklad, address_order, number_order, date_order, u.sername, u.name, u.patronymic, id_all_orders, flag, bond_guid_motion FROM all_orders a JOIN order_mtr o ON a.id_all_orders=o.id_bond_all_orders JOIN users u ON a.author_order=u.username ORDER BY date_order;";
				}

				$this->load->model('Model_db');
				$result['orders'] = $this->Model_db->select_id_all_order($query);
				if (count($result['orders']) == 0) {
					$result['flag'] = count($result['orders']);
				}
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_create_motion', $result);
				$this->load->view('template/view_footer');
			} else {
//Запрос к базе на извлечение последних добавленных 10 распоряжений
				$this->load->model('Model_db');
				$query_order_status = sprintf("SELECT distinct name_sklad, address_order, number_order, date_order, u.sername, u.name, u.patronymic, id_all_orders, flag, bond_guid_motion FROM all_orders a JOIN order_mtr o ON a.id_all_orders=o.id_bond_all_orders JOIN users u ON a.author_order=u.username ORDER BY date_order;");
				$result['orders'] = $this->Model_db->select_id_all_order($query_order_status);
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_create_motion' , $result);
				$this->load->view('template/view_footer');
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

//	формирование заполненной информации о движении МТР
	function show_motion(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && ((($_actions['edit_motion']) == 1) || (($_actions['show_motion']) == 1) || (($_actions['show_all_motions']) == 1) ) ) {
			$query_sklad = sprintf("SELECT name_sklad FROM sklads ORDER BY name_sklad ;");
			$this->load->model('Model_db');
			$result['name_sklad'] = $this->Model_db->select_id_all_order($query_sklad);

			$query_motion = sprintf("SELECT id_all_motion, number_motion, author_motion, date_create_motion, flag_motion, sername, name, patronymic 
										FROM all_motion m 
										JOIN users u ON m.author_motion=u.username ORDER BY date_create_motion DESC;");
			$result['all_motion'] = $this->Model_db->select_id_all_order($query_motion);
			$n =count($result['all_motion']);
			$i = 0;
			$new_mas = array();
			while ($i < $n){
				$query_order = sprintf("SELECT * FROM all_orders a JOIN users u ON a.author_order=u.username WHERE bond_guid_motion = '%s'", trim($result['all_motion'][$i]['number_motion']));
				$result['name_order'] = $this->Model_db->select_id_all_order($query_order);
				$result['new_mas'][$i] = $result['name_order'];
				$i++;
			}

			if (isset($_POST['search_name_motion'])) {
				$order['number_order'] = $this->input->post('number_order');
				$order['name_MTR'] = $this->input->post('nameMTR');
				$order['name_sklad'] = $this->input->post('name_sklad');
				if ($_POST['start_date'] != NULL) {
					$order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
					$order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
				}

//Промежуток дат
				if (isset($order['start_date']) && (isset($order['end_date']))) {
					$filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
				}

//Номер распоряжения
				if (($order['number_order']) != NULL) {
					$filter[] = sprintf("number_order LIKE '%%%s%%'", trim($order['number_order']));
				}

//Наименование МТР
				if (($order['name_MTR']) != NULL) {
					$filter[] = sprintf("o.id_all_orders in (SELECT id_bond_all_orders FROM order_mtr WHERE nameMTR LIKE '%%%s%%')", trim($order['name_MTR']));
				}

//Наименование Склада
				if (($order['name_sklad']) != NULL) {
					$filter[] = sprintf("name_sklad LIKE '%%%s%%'", trim($order['name_sklad']));
				}

//Формирование запроса в зависимости от фильтров
				$query = "SELECT id_all_motion, number_motion, author_motion, date_create_motion, flag_motion, sername, name, patronymic 
							FROM all_motion m 
							JOIN users u ON m.author_motion=u.username 
							JOIN all_orders o ON m.number_motion=o.bond_guid_motion";
				if (!empty($filter)) {
					$query .= ' WHERE ' . implode(' AND ', $filter) . 'ORDER BY date_create_motion DESC;';
				} else {
					$query = "SELECT id_all_motion, number_motion, author_motion, date_create_motion, flag_motion, sername, name, patronymic 
							FROM all_motion m 
							JOIN users u ON m.author_motion=u.username 
							JOIN all_orders o ON m.number_motion=o.bond_guid_motion ORDER BY date_create_motion DESC";
				}

				$this->load->model('Model_db');
				$result['all_motion'] = $this->Model_db->select_id_all_order($query);

				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_show_motion', $result);
				$this->load->view('template/view_footer');
			} else {
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_show_motion', $result);
				$this->load->view('template/view_footer');
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}
	
//формирование заполненной информации о движении МТР со статусом Отправлен для участков
	function show_edit_filial_motion(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['filial_edit_motion']) == 1)) {
			$query_sklad = sprintf("SELECT name_sklad FROM sklads;");
			$this->load->model('Model_db');
			$result['name_sklad'] = $this->Model_db->select_id_all_order($query_sklad);

			$_filial = $this->session->userdata('n_filial');
			$query_filial = sprintf("SELECT * FROM filials WHERE id_filial='%s';", trim($_filial));
			$result['filial'] = $this->Model_db->select_id_all_order($query_filial);
			$query_area = sprintf("SELECT * FROM all_motion m, all_orders o WHERE m.number_motion=o.bond_guid_motion AND flag_motion='10' OR flag_motion='20' ORDER BY date_create_motion DESC;");
			$result['area'] = $this->Model_db->select_id_all_order($query_area);

			if ($_filial == 6) {
				$query_motion = sprintf("SELECT id_all_motion, 
											id_all_orders, 
											address_order, 
											number_motion, 
											author_motion, 
											date_create_motion, 
											flag_motion, 
											sername, 
											name, 
											patronymic 
											FROM all_motion m 
											JOIN users u ON m.author_motion=u.username 
											JOIN all_orders o ON m.number_motion=o.bond_guid_motion 
											WHERE flag_motion='10' OR flag_motion='20' OR flag_motion='30' ORDER BY date_create_motion DESC;");
			} else {
				$query_motion = sprintf("SELECT id_all_motion, 
											id_all_orders, 
											address_order, 
											number_motion, 
											author_motion, 
											date_create_motion, 
											flag_motion, 
											sername, 
											name, 
											patronymic 
											FROM all_motion m 
											JOIN users u ON m.author_motion=u.username 
											JOIN all_orders o ON m.number_motion=o.bond_guid_motion 
											WHERE (flag_motion='10' OR flag_motion='20' OR flag_motion='30') AND address_order = '%s' ORDER BY date_create_motion DESC;", trim($result['filial'][0]['name_filial']));
			}
			$result['all_motion'] = $this->Model_db->select_id_all_order($query_motion);
			$n =count($result['all_motion']);
			$i = 0;
			$new_mas = array();
			while ($i < $n){
				$query_order = sprintf("SELECT * FROM all_orders a JOIN users u ON a.author_order=u.username WHERE bond_guid_motion = '%s'", trim($result['all_motion'][$i]['number_motion']));
				$result['name_order'] = $this->Model_db->select_id_all_order($query_order);
				$result['new_mas'][$i] = $result['name_order'];
				$i++;
			}

			if (isset($_POST['search_name_motion'])) {
				$query_motion = sprintf("SELECT * FROM all_motion;");
				$result['all_motion'] = $this->Model_db->select_id_all_order($query_motion);
				$n =count($result['all_motion']);
				$i = 0;
				$new_mas = array();
				while ($i < $n){
					$query_order = sprintf("SELECT * FROM all_orders WHERE bond_guid_motion = '%s'", trim($result['all_motion'][$i]['number_motion']));
					$result['name_order'] = $this->Model_db->select_id_all_order($query_order);
					$result['new_mas'][$i] = $result['name_order'];
					$i++;
				}
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_show_edit_filial_motion', $result);
				$this->load->view('template/view_footer');
			} else {
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_show_edit_filial_motion', $result);
				$this->load->view('template/view_footer');
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}
	
	
/*Информация о движении МТР на базе, участке Дичь какая то, надо разобраться или удалить*/
	function select_motion(){
		if ($_POST['cBox']){
			print_r ($_POST);
			$this->load->model("Model_db");
			$checkbox = $this->input->post('cBox');
			$n = count($checkbox);
			for ($i=0; $i<$n; $i++){
				$query = sprintf("SELECT id_order FROM order_mtr WHERE id_bond_all_orders='%s';", trim($checkbox[$i]));
				print_r($query);
				$result = $this->Model_db->select_id_all_order($query);
				print_r($result);
			}
		}
	}

/*Информация о движении МТР на базе, участке*/
	function motion(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && ((($_actions['edit_motion']) == 1)) || (($_actions['show_motion']) == 1)) {
			if(isset($_POST['id_all_orders_check'])) {
                $string_check = implode(",", $_POST['id_all_orders_check']);
                $result['string_check'] = $string_check;
            } else {
                $string_check = $_GET['string_check'];
            }

			if ( ($string_check != NULL) ) {
//Генерируем GUID код
				function getGUID(){
					if (function_exists('com_create_guid')){
						return com_create_guid();
					}
					else {
						mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
						$charid = strtoupper(md5(uniqid(rand(), true)));
						$hyphen = chr(45);// "-"
						$uuid = chr(123)// "{"
							.substr($charid, 0, 8).$hyphen
							.substr($charid, 8, 4).$hyphen
							.substr($charid,12, 4).$hyphen
							.substr($charid,16, 4).$hyphen
							.substr($charid,20,12)
							.chr(125);// "}"
						return $uuid;
					}
				}
				$GUID = getGUID();
				$result['orders_guid'] = $GUID;

//Запрос к базе на извлечение ФИО сотрудника создающего информацию о движении МТР
				$query_author = sprintf("SELECT sername, name, department, n_sklad FROM users WHERE username = '%s';", trim($_username));
				$query = sprintf("SELECT * FROM order_mtr WHERE id_bond_all_orders IN (%s);", trim($string_check));
				$query_orders = sprintf("SELECT distinct id_bond_all_orders, number_orderMTR, date_orderMTR FROM order_mtr WHERE id_bond_all_orders IN (%s);", trim($string_check));
//				$query_flag = sprintf("UPDATE all_orders SET flag = 3 WHERE id_all_orders in (%s);", trim($string_check));
				$this->load->model('Model_db');
// Вносим в распоряжениe(я) статус "В работе"
//				$this->Model_db->saveOrder($query_flag);
				$result['orders'] = $this->Model_db->select_id_all_order($query);
				$bond_guid_motion_date = getGUID();
				$result['bond_guid_motion_date'] = $bond_guid_motion_date;
				$result['orders_name'] = $this->Model_db->select_id_all_order($query_orders);
				$result['author'] = $this->Model_db->select_id_all_order($query_author);
				
				$this->load->view('view_new_motion', $result);
			} else {
				header("Location: create_motion");
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

/*Заполнение информации о движении МТР на базе, участке выбранным элементам*/
    function motion_add_many(){
        $_username = $this->session->userdata('username');
        $_actions = $this->session->userdata('actions');
        if (isset ($_username) && ((($_actions['edit_motion']) == 1)) || (($_actions['show_motion']) == 1)) {
            $string_check = $_GET['string_check'];
            if ( ($string_check) != NULL)  {
//Генерируем GUID код
                function getGUID(){
                    if (function_exists('com_create_guid')){
                        return com_create_guid();
                    }
                    else {
                        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
                        $charid = strtoupper(md5(uniqid(rand(), true)));
                        $hyphen = chr(45);// "-"
                        $uuid = chr(123)// "{"
                            .substr($charid, 0, 8).$hyphen
                            .substr($charid, 8, 4).$hyphen
                            .substr($charid,12, 4).$hyphen
                            .substr($charid,16, 4).$hyphen
                            .substr($charid,20,12)
                            .chr(125);// "}"
                        return $uuid;
                    }
                }
                $GUID = getGUID();
                $result['orders_guid'] = $GUID;

//Запрос к базе на извлечение ФИО сотрудника создающего информацию о движении МТР
                $query_author = sprintf("SELECT sername, name, department, n_sklad FROM users WHERE username = '%s';", trim($_username));
                $query = sprintf("SELECT * FROM order_mtr WHERE id_bond_all_orders IN (%s);", trim($string_check));
                $query_orders = sprintf("SELECT distinct id_bond_all_orders, number_orderMTR, date_orderMTR FROM order_mtr WHERE id_bond_all_orders IN (%s);", trim($string_check));
//				$query_flag = sprintf("UPDATE all_orders SET flag = 3 WHERE id_all_orders in (%s);", trim($string_check));
                $this->load->model('Model_db');
// Вносим в распоряжениe(я) статус "В работе"
//				$this->Model_db->saveOrder($query_flag);
                $result['orders'] = $this->Model_db->select_id_all_order($query);
                $bond_guid_motion_date = getGUID();
                $result['bond_guid_motion_date'] = $bond_guid_motion_date;
                $result['orders_name'] = $this->Model_db->select_id_all_order($query_orders);
                $result['author'] = $this->Model_db->select_id_all_order($query_author);

                $this->load->view('view_motion_add_many', $result);
            } else {
                header("Location: create_motion");
            }
        } else {
            $this->load->view('template/view_header');
            $this->load->view('view_auth');
            $this->load->view('template/view_footer');
        }
    }

	function show_information(){
		$query = sprintf("SELECT * FROM all_motion;");
		$this->load->model('Model_db');
		$result = $this->Model_db->select_id_all_order($query);
	}

	function cancelCreateMotion(){
		$string_check = $this->input->post('id_order');
		$query_flag = sprintf("UPDATE all_orders SET flag = 20 WHERE id_all_orders in (%s);", trim($string_check));
		$this->load->model('Model_db');
// Вносим в распоряжениe(я) статус "В работе"
		$this->Model_db->saveOrder($query_flag);		
	}
	
/*AJAX Занесении в таблицу данных motion информацию о движении МТР*/
	function saveMotion(){
/*Получаем ID MTR по которому добавляется информация*/
		$order['number_id_order_mtr'] = $this->input->post('number_id_order_mtr'); 	//id из таблицы order_mtr
		$order['id_bond_all_motion'] = $this->input->post('id_bond_all_motion');	//id с таблицы all_motion (id всего отчета)
//Получаем GUID для информации о движении МТР	
		$order['guid'] = $this->input->post('guid');								//GUID всего отчета "информаиця о движении МТР"
//Получаем GUID для строки по информации о движении МТР
		$order['guid_bond_guid_motion_date'] = $this->input->post('guid_bond_guid_motion_date');

		/*получаем данные с формы с помощью Ajax запроса по общей таблице*/
		$order['length_motion'] = $this->input->post('length_motion');
		$order['width_motion'] = $this->input->post('width_motion');
		$order['height_motion'] = $this->input->post('height_motion');
		$order['weight_motion'] = $this->input->post('weight_motion');
		$order['total_motion'] = $this->input->post('total_motion');
		$order['cargo_motion'] = $this->input->post('cargo_motion');
        $order['dateRequest_motion'] = date('Y-m-d', strtotime($this->input->post('dateRequest_motion')));
        $order['dateShipments_motion'] = date('Y-m-d', strtotime($this->input->post('dateShipments_motion')));
		$order['infoShipments_motion'] = $this->input->post('infoShipments_motion');
        $order['tranzit_motion'] = $this->input->post('tranzit_motion');
		$order['shipped_motion'] = $this->input->post('shipped_motion');
		$order['sumMTR'] = $this->input->post('sumMTR');
		$order['remains_motion'] = $this->input->post('remains_motion');
		$order['numberOverhead_motion'] = $this->input->post('numberOverhead_motion');
        $order['dateOverhead_motion'] = date('Y-m-d', strtotime($this->input->post('dateOverhead_motion')));
		$order['note_motion'] = $this->input->post('note_motion');
		$order['author_motion'] = $this->session->userdata('username');
		$order['datetime_motion'] = date("Y-m-d H:i:s");

		print_r($order);
		if ( ($order['sumMTR'] == $order['shipped_motion']) ){
			/*Если отгрузка равна требуемому объему, формируем запрос к базе и заносим данные*/
			$order['reference'] = 1; //в случаи если все отправили по данному МТР
			$order_query[] = "( '". $order['number_id_order_mtr'] . "' ,
							'". $order['id_bond_all_motion'] . "' ,
		 					'" . $order['guid'] . "',
		 					'" . $order['guid_bond_guid_motion_date'] . "',
			                '" . $order['length_motion'] . "',
			                '" . $order['width_motion'] . "',
			                '" . $order['height_motion'] . "', 
			                '" . $order['weight_motion'] . "', 
			                '" . $order['total_motion'] . "',
						    '" . $order['cargo_motion'] . "', 
							'" . $order['dateRequest_motion'] . "', 
							'" . $order['dateShipments_motion'] . "', 
							'" . $order['infoShipments_motion'] . "', 
							'" . $order['sumMTR'] . "', 
							'" . $order['tranzit_motion'] . "', 
							'" . $order['shipped_motion'] . "', 
							'" . $order['remains_motion'] . "', 
							'" . $order['numberOverhead_motion'] . "', 
							'" . $order['dateOverhead_motion'] . "', 
							'" . $order['author_motion'] . "', 
							'" . $order['datetime_motion'] . "',
							'" . $order['note_motion'] . "',
							'" . $order['reference'] . "' )";
			$query_1 = "INSERT INTO motion (	id_bond_order_mtr, 
										id_bond_all_motion, 
										guid_motion,
										bond_guid_motion_date,
										length_motion, 
										width_motion, 
										height_motion, 
										weight_motion, 
										total_motion, 
										cargo_motion, 
										dateRequest_motion, 
										dateShipments_motion, 
										infoShipments_motion, 
										all_mtr,
                                        tranzit_motion,
										shipped_motion, 
										remains_motion, 
										numberOverhead_motion,
										dateOverhead_motion,
										author_motion,
										date_edit_motion,
										note_motion,
										reference)
									VALUES" . implode(", ", $order_query);
			$this->load->model('Model_db');
			$this->Model_db->saveMotion($query_1);
		} else {
			/*Если не все отправили по данному МТР*/
			$order['reference'] = 1; //в случаи если не все отправили по данному МТР
			$order_query[] = "( '". $order['number_id_order_mtr'] . "' ,
							'". $order['id_bond_all_motion'] . "' ,
		 					'" . $order['guid'] . "',
		 					'" . $order['guid_bond_guid_motion_date'] . "',
			                '" . $order['length_motion'] . "',
			                '" . $order['width_motion'] . "',
			                '" . $order['height_motion'] . "', 
			                '" . $order['weight_motion'] . "', 
			                '" . $order['total_motion'] . "',
						    '" . $order['cargo_motion'] . "', 
							'" . $order['dateRequest_motion'] . "', 
							'" . $order['dateShipments_motion'] . "', 
							'" . $order['infoShipments_motion'] . "', 
							'" . $order['sumMTR'] . "', 
							'" . $order['tranzit_motion'] . "', 
							'" . $order['shipped_motion'] . "', 
							'" . $order['remains_motion'] . "', 
							'" . $order['numberOverhead_motion'] . "', 
							'" . $order['dateOverhead_motion'] . "', 
							'" . $order['author_motion'] . "', 
							'" . $order['datetime_motion'] . "',
							'" . $order['note_motion'] . "',
							'" . $order['reference'] . "' )";
			$query_1 = "INSERT INTO motion (	id_bond_order_mtr, 
										id_bond_all_motion, 
										guid_motion,
										bond_guid_motion_date,
										length_motion, 
										width_motion, 
										height_motion, 
										weight_motion, 
										total_motion, 
										cargo_motion, 
										dateRequest_motion, 
										dateShipments_motion, 
										infoShipments_motion, 
										all_mtr,
                                        tranzit_motion,
										shipped_motion, 
										remains_motion, 
										numberOverhead_motion,
										dateOverhead_motion,
										author_motion,
										date_edit_motion,
										note_motion,
										reference
										)
									VALUES" . implode(", ", $order_query);
			$this->load->model('Model_db');
			$this->Model_db->saveMotion($query_1);
		}
	}

/*AJAX Множественное занесении в таблицу данных motion информацию о движении МТР*/
    function saveManyMotion(){
        /*Получаем ID MTR по которому добавляется информация*/
        $order['number_id_order_mtr'] = $this->input->post('number_id_order_mtr'); 	//id из таблицы order_mtr
        $order['id_bond_all_motion'] = $this->input->post('id_bond_all_motion');	//id с таблицы all_motion (id всего отчета)
//Получаем GUID для информации о движении МТР
        $order['guid'] = $this->input->post('guid');								//GUID всего отчета "информаиця о движении МТР"
//Получаем GUID для строки по информации о движении МТР
        $order['guid_bond_guid_motion_date'] = $this->input->post('guid_bond_guid_motion_date');

        /*получаем данные с формы с помощью Ajax запроса по общей таблице*/
        $order['length_motion'] = $this->input->post('length_motion');
        $order['width_motion'] = $this->input->post('width_motion');
        $order['height_motion'] = $this->input->post('height_motion');
        $order['weight_motion'] = $this->input->post('weight_motion');
        $order['total_motion'] = $this->input->post('total_motion');
        $order['cargo_motion'] = $this->input->post('cargo_motion');
        $order['dateRequest_motion'] = date('Y-m-d', strtotime($this->input->post('dateRequest_motion')));
        $order['dateShipments_motion'] = date('Y-m-d', strtotime($this->input->post('dateShipments_motion')));
        $order['infoShipments_motion'] = $this->input->post('infoShipments_motion');
        $order['tranzit_motion'] = $this->input->post('tranzit_motion');
        $order['shipped_motion'] = $this->input->post('shipped_motion');
        $order['sumMTR'] = $this->input->post('sumMTR');
        $order['remains_motion'] = $this->input->post('remains_motion');
        $order['numberOverhead_motion'] = $this->input->post('numberOverhead_motion');
        $order['dateOverhead_motion'] = date('Y-m-d', strtotime($this->input->post('dateOverhead_motion')));
        $order['note_motion'] = $this->input->post('note_motion');
        $order['author_motion'] = $this->session->userdata('username');
        $order['datetime_motion'] = date("Y-m-d H:i:s");

        $n = 0;
        while ($n<count($order['number_id_order_mtr'])){
            /*Если отгрузка равна требуемому объему, формируем запрос к базе и заносим данные*/
            $order['reference'] = 1; //в случаи если все отправили по данному МТР
            $order_query[] = "( '". $order['number_id_order_mtr'][$n] . "' ,
							'". $order['id_bond_all_motion'] . "' ,
		 					'" . $order['guid'] . "',
		 					'" . $order['guid_bond_guid_motion_date'] . "',
			                '" . $order['length_motion'] . "',
			                '" . $order['width_motion'] . "',
			                '" . $order['height_motion'] . "', 
			                '" . $order['weight_motion'] . "', 
			                '" . $order['total_motion'] . "',
						    '" . $order['cargo_motion'] . "', 
							'" . $order['dateRequest_motion'] . "', 
							'" . $order['dateShipments_motion'] . "', 
							'" . $order['infoShipments_motion'] . "', 
							'" . $order['sumMTR'] . "', 
							'" . $order['tranzit_motion'] . "',
							'" . $order['shipped_motion'] . "', 
							'" . $order['remains_motion'] . "', 
							'" . $order['numberOverhead_motion'] . "', 
							'" . $order['dateOverhead_motion'] . "', 
							'" . $order['author_motion'] . "', 
							'" . $order['datetime_motion'] . "',
							'" . $order['note_motion'] . "',
							'" . $order['reference'] . "' )";
            $n++;
        }
        $query_add_motion = "INSERT INTO motion (	id_bond_order_mtr, 
										id_bond_all_motion, 
										guid_motion,
										bond_guid_motion_date,
										length_motion, 
										width_motion, 
										height_motion, 
										weight_motion, 
										total_motion, 
										cargo_motion, 
										dateRequest_motion, 
										dateShipments_motion, 
										infoShipments_motion, 
										all_mtr,
                                        tranzit_motion, 
										shipped_motion, 
										remains_motion, 
										numberOverhead_motion,
										dateOverhead_motion,
										author_motion,
										date_edit_motion,
										note_motion,
										reference)
									VALUES" . implode(", ", $order_query);
        $this->load->model('Model_db');
        $this->Model_db->saveMotion($query_add_motion);
    }

/*AJAX Занесении информации об изменении информации о движении МТР в таблицу motion*/
	function saveEditMotion(){
/*Получаем ID MTR по которому изменяем информацию*/
		$order['number_id_motion'] = $this->input->post('number_id_motion');
		$order['number_id_order_mtr'] = $this->input->post('number_id_order_mtr');
//Получаем id_motion для информации о движении МТР
		$order['id_motion'] = $this->input->post('id_motion');
		$order['guid'] = $this->input->post('gid_motion');
//Получаем сгенерированный guid для строк по информации о движении МТР
		$order['bond_guid_motion_date'] = $this->input->post('guid_bond_guid_motion_date');

/*получаем данные с формы с помощью Ajax запроса по общей таблице*/
		$order['length_motion'] = $this->input->post('length_motion');
		$order['width_motion'] = $this->input->post('width_motion');
		$order['height_motion'] = $this->input->post('height_motion');
		$order['weight_motion'] = $this->input->post('weight_motion');
		$order['total_motion'] = $this->input->post('total_motion');
		$order['cargo_motion'] = $this->input->post('cargo_motion');
        $order['dateRequest_motion'] = date('Y-m-d', strtotime($this->input->post('dateRequest_motion')));
        $order['dateShipments_motion'] = date('Y-m-d', strtotime($this->input->post('dateShipments_motion')));
		$order['infoShipments_motion'] = $this->input->post('infoShipments_motion');
        $order['tranzit_motion'] = $this->input->post('tranzit_motion'); //Кол-во отгруженного на текущую дату
		$order['shipped_motion'] = $this->input->post('shipped_motion'); //Кол-во отгруженного на текущую дату
		$order['sumMTR'] = $this->input->post('sumMTR'); 				 //Общее кол-во необходимого для отгрузки
		$order['remains_motion'] = $this->input->post('remains_motion');
		$order['numberOverhead_motion'] = $this->input->post('numberOverhead_motion');
        $order['dateOverhead_motion'] = date('Y-m-d', strtotime($this->input->post('dateOverhead_motion')));
		$order['note_motion'] = $this->input->post('note_motion');
		$order['author_motion'] = $this->session->userdata('username');
		$order['date_edit_motion'] = date("Y-m-d H:i:s");

		print_R($order['number_id_motion']);
//Условие при котором закрывается позиция по МТР или же дублируется с остатками
		if ( ($order['number_id_motion'] != NULL) ) {
/*Формируем запрос к базе и обновляем данные*/
			print_r("Обновление строки");
			$query_update = sprintf ("UPDATE motion SET 
										bond_guid_motion_date = '%s',
										length_motion = '%s', 
										width_motion = '%s', 
										height_motion = '%s', 
										weight_motion = '%s', 
										total_motion = '%s', 
										cargo_motion = '%s', 
										dateRequest_motion = '%s', 
										dateShipments_motion = '%s', 
										infoShipments_motion = '%s', 
										all_mtr = '%s', 
                                        tranzit_motion = '%s', 
										shipped_motion = '%s', 
										remains_motion = '%s',
										numberOverhead_motion = '%s',
										dateOverhead_motion = '%s',
										author_motion = '%s',
										date_edit_motion = '%s',
										note_motion = '%s'
										WHERE id_motion='%s' AND id_bond_order_mtr='%s';",
				trim($order['bond_guid_motion_date']),
				trim($order['length_motion']) ,
				trim($order['width_motion']) ,
				trim($order['height_motion']) ,
				trim($order['weight_motion']) ,
				trim($order['total_motion']) ,
				trim($order['cargo_motion']) ,
				trim($order['dateRequest_motion']) ,
				trim($order['dateShipments_motion']) ,
				trim($order['infoShipments_motion']) ,
				trim($order['sumMTR']) ,
                trim($order['tranzit_motion']) ,
				trim($order['shipped_motion']) ,
				trim($order['remains_motion']) ,
				trim($order['numberOverhead_motion']) ,
				trim($order['dateOverhead_motion']) ,
				trim($order['author_motion']) ,
				trim($order['date_edit_motion']),
				trim($order['note_motion']) ,
				trim($order['number_id_motion']),
				trim($order['number_id_order_mtr']) );
			print_R($query_update);
			$this->load->model('Model_db');
			$this->Model_db->saveMotion($query_update);
		} else {
//Формируем запрос к базе и добавляем строку в таблицу motion
			print_r("Добавление строки");
			$order['answer'] = $order['sumMTR'] - $order['shipped_motion'];
			$order_query[] = "( '". $order['number_id_order_mtr'] . "' ,
							'". $order['id_motion'] . "' ,
		 					'" . $order['guid'] . "',
		 					'" . $order['bond_guid_motion_date'] . "',
			                '" . $order['length_motion'] . "',
			                '" . $order['width_motion'] . "',
			                '" . $order['height_motion'] . "',
			                '" . $order['weight_motion'] . "',
			                '" . $order['total_motion'] . "',
						    '" . $order['cargo_motion'] . "',
							'" . $order['dateRequest_motion'] . "',
							'" . $order['dateShipments_motion'] . "',
							'" . $order['infoShipments_motion'] . "',
							'" . $order['tranzit_motion'] . "',
							'" . $order['shipped_motion'] . "',
							'" . $order['remains_motion'] . "',
							'" . $order['numberOverhead_motion'] . "',
							'" . $order['dateOverhead_motion'] . "',
							'" . $order['author_motion'] . "',
							'" . $order['date_edit_motion'] . "',
							'" . $order['note_motion'] . "' )";
			$query_add = "INSERT INTO motion (	id_bond_order_mtr,
										id_bond_all_motion,
										guid_motion,
										bond_guid_motion_date,
										length_motion,
										width_motion,
										height_motion,
										weight_motion,
										total_motion,
										cargo_motion,
										dateRequest_motion,
										dateShipments_motion,
										infoShipments_motion,
                                        tranzit_motion,
										shipped_motion,
										remains_motion,
										numberOverhead_motion,
										dateOverhead_motion,
										author_motion,
										date_edit_motion,
										note_motion)
									VALUES" . implode(", ", $order_query);
			print_R($query_add);
			$this->load->model('Model_db');
			$this->Model_db->saveMotion($query_add);
		}
	}

/*AJAX Запрос на извлечение id_all_motion из таблицы all_motion*/
    function selectIdAllMotion(){
        $order['guid'] = $this->input->post('guid_bond_guid_motion_date');
        $query_id_all_motion = sprintf("SELECT id_all_motion FROM all_motion WHERE number_motion='%s';", trim($order['guid']));
        $this->load->model('Model_db');
        $result_id_all_motion = $this->Model_db->select_id_all_order($query_id_all_motion);
        print_r($result_id_all_motion[0]['id_all_motion']);
    }

/*AJAX Занесении информации о созданном движении МТР в таблицу all_motion*/
	function saveAllMotion(){
		$order['guid'] = $this->input->post('guid');
		$order['author_motion'] = $this->session->userdata('username');
		$order['date_create_motion'] = date("Y-m-d H:i:s");
		$query = sprintf("INSERT INTO all_motion (number_motion, author_motion, date_create_motion) VALUES ('%s', '%s', '%s')", trim($order['guid']), trim($order['author_motion']), trim($order['date_create_motion']));
		$this->load->model('Model_db');
		$this->Model_db->saveMotion($query);
		$query_id_all_motion = sprintf("SELECT id_all_motion FROM all_motion WHERE number_motion='%s';", trim($order['guid']));
		$result_id_all_motion = $this->Model_db->select_id_all_order($query_id_all_motion);
		print_r($result_id_all_motion[0]['id_all_motion']);
	}

/*AJAX изменение статуса распорядения "В работе" в таблице all_orders*/
	function saveStatusOrder(){
		$order['id_order'] = $this->input->post('id_order');
		$query_flag = sprintf("UPDATE all_orders SET flag = 30 WHERE id_all_orders in (%s);", trim($order['id_order']));
		$this->load->model('Model_db');
		$this->Model_db->saveOrder($query_flag);
	}

/*AJAX Занесении информации о созданном движении МТР в таблицу all_motion*/
	function saveEditAllMotion(){
		$order['id_motion'] = $this->input->post('id_motion');
		$order['author_motion'] = $this->session->userdata('username');
		$order['date_create_motion'] = date("Y-m-d H:i:s");
		$query = sprintf("UPDATE all_motion SET author_motion = ('%s'), date_create_motion = ('%s') WHERE id_all_motion= ('%s');", trim($order['author_motion']), trim($order['date_create_motion']), trim($order['id_motion']));
		$this->load->model('Model_db');
		$this->Model_db->saveMotion($query);
	}

/*AJAX Занесении информации о созданном движении МТР в таблицу all_orders*/
	function saveGUIDAllMotionInOrders(){
		$order['guid'] = $this->input->post('guid');
		$order['id_order'] = $this->input->post('id_order');
		$query = sprintf("UPDATE all_orders SET bond_guid_motion = ('%s'), flag='30' WHERE id_all_orders = ('%s');", trim($order['guid']), trim($order['id_order']));
		$this->load->model('Model_db');
		$this->Model_db->saveMotion($query);
	}

/*Форма редактирования информации о движении МТР*/
	function edit_motion(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && ((($_actions['edit_motion']) == 1) || (($_actions['show_motion']) == 1))) {
			if (isset($_GET['id_motion']) || isset($_GET['guid'])) {
				if (isset($_GET['id_motion'])) {
					$query_motion = sprintf("SELECT * FROM all_motion WHERE id_all_motion='%s';", trim($_GET['id_motion']));
				} else {
					$query_motion = sprintf("SELECT * FROM all_motion WHERE number_motion='%s';", trim($_GET['guid']));
				}
				$this->load->model('Model_db');
				$result['info_motion'] = $this->Model_db->select_id_all_order($query_motion);
//Формирование guid для строк
				function getGUID(){
					if (function_exists('com_create_guid')){
						return com_create_guid();
					}
					else {
						mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
						$charid = strtoupper(md5(uniqid(rand(), true)));
						$hyphen = chr(45);// "-"
						$uuid = chr(123)// "{"
							.substr($charid, 0, 8).$hyphen
							.substr($charid, 8, 4).$hyphen
							.substr($charid,12, 4).$hyphen
							.substr($charid,16, 4).$hyphen
							.substr($charid,20,12)
							.chr(125);// "}"
						return $uuid;
					}
				}
				$bond_guid_motion_date = getGUID();
				$result['bond_guid_motion_date'] = $bond_guid_motion_date;

				//Выгрузка всех дат внесения изменений по Информации о движении МТР
				$query_date = sprintf("SELECT distinct bond_guid_motion_date, date_edit_motion FROM motion WHERE guid_motion='%s';", trim($result['info_motion'][0]['number_motion']));
				//Сбор информации по данному распоряжению
				$query_orders = sprintf("SELECT * FROM all_orders WHERE bond_guid_motion='%s';", trim($result['info_motion'][0]['number_motion']));
				$result['info_orders'] = $this->Model_db->select_id_all_order($query_orders); //считаем сколько распоряжений находится в данной информации

				$n =count($result['info_orders']);
				$i = 0;
				$result['order'] = array();
				while ($i < $n){
					$query_order = sprintf("SELECT * FROM order_mtr WHERE id_bond_all_orders='%s';", trim($result['info_orders'][$i]['id_all_orders']) );
					$result[$i] = $this->Model_db->select_id_all_order($query_order);
					$m =count($result[$i]);
					$j=0;
					while($j < $m) {
						array_push($result['order'], $result[$i][$j]);
						$j++;
					}
//					$result['new_mas'][$i] = $result[$i];
					$i++;
				}

				$query_motion = sprintf("SELECT * FROM motion m JOIN order_mtr o ON  m.id_bond_order_mtr=o.id_order WHERE m.guid_motion='%s' ORDER BY id_motion;", trim($result['info_motion'][0]['number_motion']));
					$result['orders'] = $this->Model_db->select_id_all_order($query_motion);
					$result['date_edit_motion'] = $this->Model_db->select_id_all_order($query_date);
					$this->load->view('view_new_edit_motion', $result);
			} else {
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_show_motion');
				$this->load->view('template/view_footer');
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

	/*Форма редактирования информации о движении МТР для Участков*/
	function filial_edit_motion(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['filial_edit_motion']) == 1)) {
			if (isset($_GET['id_motion']) || isset($_GET['guid'])) {
				if (isset($_GET['id_motion'])) {
					$query_motion = sprintf("SELECT * FROM all_motion WHERE id_all_motion='%s';", trim($_GET['id_motion']));
				} else {
					$query_motion = sprintf("SELECT * FROM all_motion WHERE number_motion='%s';", trim($_GET['guid']));
				}
				$this->load->model('Model_db');
				$result['info_motion'] = $this->Model_db->select_id_all_order($query_motion);

				//Выгрузка всех дат внесения изменений по Информации о движении МТР
				$query_date = sprintf("SELECT distinct bond_guid_motion_date, date_edit_motion FROM motion WHERE guid_motion='%s';", trim($result['info_motion'][0]['number_motion']));
				//Сбор информации по данному распоряжению
				$query_orders = sprintf("SELECT * FROM all_orders WHERE bond_guid_motion='%s';", trim($result['info_motion'][0]['number_motion']));
				$result['info_orders'] = $this->Model_db->select_id_all_order($query_orders); //считаем сколько распоряжений находится в данной информации

				$n =count($result['info_orders']);
				$i = 0;
				$result['order'] = array();
				while ($i < $n){
					$query_order = sprintf("SELECT * FROM order_mtr WHERE id_bond_all_orders='%s';", trim($result['info_orders'][$i]['id_all_orders']) );
					$result[$i] = $this->Model_db->select_id_all_order($query_order);
					$m =count($result[$i]);
					$j=0;
					while($j < $m) {
						array_push($result['order'], $result[$i][$j]);
						$j++;
					}
					$i++;
				}

				$query_motion = sprintf("SELECT * FROM motion m JOIN order_mtr o ON  m.id_bond_order_mtr=o.id_order WHERE m.guid_motion='%s' ORDER BY id_motion;", trim($result['info_motion'][0]['number_motion']));
				$result['orders'] = $this->Model_db->select_id_all_order($query_motion);
				$result['date_edit_motion'] = $this->Model_db->select_id_all_order($query_date);
				$this->load->view('view_area_edit_motion', $result);
			} else {
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('view_show_edit_filial_motion');
				$this->load->view('template/view_footer');
			}
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

/*AJAX Занесении информации Участками об изменении информации о движении МТР в таблицу motion*/
	function save_area_edit_motion(){
		/*Получаем ID MTR по которому изменяем информацию*/
		$order['number_id_motion'] = $this->input->post('number_id_motion');
		$order['number_id_order_mtr'] = $this->input->post('number_id_order_mtr');
		$order['id_bond_all_motion'] = $this->input->post('id_bond_all_motion');
//Получаем id_motion для информации о движении МТР
		$order['id_motion'] = $this->input->post('id_motion');
		$order['id_order'] = $this->input->post('id_order');

		/*получаем данные с формы с помощью Ajax запроса по общей таблице*/
        $order['dateArrival_motion'] = date('Y-m-d', strtotime($this->input->post('dateArrival_motion')));
		$order['numberM15_motion'] = $this->input->post('numberM15_motion');
        $order['dateM15_motion'] = date('Y-m-d', strtotime($this->input->post('dateM15_motion')));
        $order['dateFilial_motion'] = date('Y-m-d', strtotime($this->input->post('dateFilial_motion')));
		$order['author_motion'] = $this->session->userdata('username');
		$order['recd'] = $this->input->post('recd');
		$order['datetime_motion'] = date("Y-m-d H:i:s");

		/*Формируем запрос к базе и заносим данные*/
		$query = sprintf ("UPDATE motion SET 
										dateArrival_motion = '%s', 
										numberM15_motion = '%s',
										dateM15_motion = '%s',
										dateFilial_motion = '%s',
										recd = '%s',
										author_motion = '%s',
										date_edit_motion = '%s'
										WHERE id_motion='%s' AND id_bond_order_mtr='%s';",
			trim($order['dateArrival_motion']) ,
			trim($order['numberM15_motion']) ,
			trim($order['dateM15_motion']) ,
			trim($order['dateFilial_motion']) ,
			trim($order['recd']) ,
			trim($order['author_motion']) ,
			trim($order['datetime_motion']),
			trim($order['number_id_motion']),
			trim($order['number_id_order_mtr']) );

		$query_all_motion = sprintf("UPDATE all_motion SET flag_motion = 20 WHERE id_all_motion = '%s';", trim($order['id_motion']));
		$query_all_order = sprintf("UPDATE all_orders SET flag = 50 WHERE id_all_orders = '%s';", trim($order['id_order']));
		$query_motion = sprintf("UPDATE motion SET reference = 2 WHERE id_motion = '%s';", trim($order['number_id_motion']));
		print_R($query_all_order);

		$this->load->model('Model_db');
		$this->Model_db->saveMotion($query);
		$this->Model_db->saveMotion($query_all_motion);
		$this->Model_db->saveMotion($query_all_order);
		$this->Model_db->saveMotion($query_motion);
	}

/*AJAX Удаление строки в Информации о движении МТР*/
	function deleteRowMotion(){
		$id = $this->input->post('id');
		$bond_guid_motion_date = $this->input->post('bond_guid_motion_date');
		$query = sprintf("DELETE FROM motion WHERE id_motion='%s';", trim($id));
		$query_guid_date = sprintf("UPDATE motion SET bond_guid_motion_date = NULL WHERE bond_guid_motion_date='%s';", trim($bond_guid_motion_date));
		$this->load->model('Model_db');
		$this->Model_db->delete_Row_Motion($query);
		$this->Model_db->saveAllOrder($query_guid_date);
	}

/*Удаление Информации о движении МТР*/
	function deleteMotion(){
		$id = $this->input->post('id');
		$query_guid_motion = sprintf("SELECT * FROM all_motion WHERE id_all_motion = '%s';", trim($id));
		$this->load->model('Model_db');
		$result['guid'] = $this->Model_db->select_id_all_order($query_guid_motion);
		$query = sprintf("DELETE FROM all_motion WHERE id_all_motion='%s';", trim($id));
		$query_update_order = sprintf("UPDATE all_orders SET flag = 20, bond_guid_motion = NULL WHERE bond_guid_motion = '%s';", trim($result['guid'][0]['number_motion']));

		$result = $this->Model_db->saveAllOrder($query_update_order);
		$result_update = $this->Model_db->delete_id_all_motion($query);
		print_r($result);
	}
	
/*Этап отправки МТР на участки*/
	function endGameMotion(){
		$id_all_motion = $this->input->post('id_motion');
		$id_order_mtr = $this->input->post('id_order');
		$id_motion = $this->input->post('number_id_order_mtr');
		$query_all_motion = sprintf("UPDATE all_motion SET flag_motion = 10 WHERE id_all_motion = '%s';", trim($id_all_motion));
		$query_all_order = sprintf("UPDATE all_orders SET flag = 40 WHERE id_all_orders = '%s';", trim($id_order_mtr));
		$query_motion = sprintf("UPDATE motion SET reference = 2 WHERE id_motion = '%s';", trim($id_motion));
		$this->load->model('Model_db');
		$result['motion']= $this->Model_db->saveOrder($query_all_motion);
		$result['order'] = $this->Model_db->saveOrder($query_all_order);
		$result['motiom_mtr'] = $this->Model_db->saveOrder($query_motion);
	}

/*Этап завершения приема МТР на участках*/
	function finishMotion(){
		$id_all_motion = $this->input->post('id_motion');
		$id_order_mtr = $this->input->post('id_order');
		$id_motion = $this->input->post('number_id_order_mtr');
		$query_all_motion = sprintf("UPDATE all_motion SET flag_motion = 30 WHERE id_all_motion = '%s';", trim($id_all_motion));
		$query_all_order = sprintf("UPDATE all_orders SET flag = 60 WHERE id_all_orders = '%s';", trim($id_order_mtr));
		$query_motion = sprintf("UPDATE motion SET reference = 3 WHERE id_motion = '%s';", trim($id_motion));
		$this->load->model('Model_db');
		$result['motion']= $this->Model_db->saveOrder($query_all_motion);
		$result['order'] = $this->Model_db->saveOrder($query_all_order);
		$result['motiom_mtr'] = $this->Model_db->saveOrder($query_motion);
	}

/*Этап возврата распоряжение на корректировку*/
    function return_edit_motion(){
        $id_motion = $this->input->post('id_motion');
        $query_all_motion = sprintf("UPDATE all_motion SET flag_motion = 0 WHERE id_all_motion = '%s';", trim($id_motion));
        $query_motion = sprintf("UPDATE motion SET reference = 1 WHERE id_bond_all_motion = '%s';", trim($id_motion));
        $query_number_motion = sprintf("SELECT number_motion FROM all_motion WHERE id_all_motion = '%s';", trim($id_motion));
        $this->load->model('Model_db');

        $this->Model_db->saveOrder($query_all_motion);
        $this->Model_db->saveOrder($query_motion);
        $result['number_motion'] = $this->Model_db->select_id_all_order($query_number_motion);
        $query_all_orders = sprintf("UPDATE all_orders SET flag = 30 WHERE bond_guid_motion = '%s';", trim($result['number_motion']));
        $this->Model_db->saveOrder($query_all_orders);
    }

/*Этап возврата распоряжение на корректировку*/
	function return_edit_order(){
		$id_order_mtr = $this->input->post('id_order');
		print_R($id_order_mtr);
        $query_all_order = sprintf("UPDATE all_orders SET flag = 0 WHERE id_all_orders = '%s';", trim($id_order_mtr));
		$this->load->model('Model_db');
		$this->Model_db->saveOrder($query_all_order);
	}
	
	/*------------------------------------------------------------------------*/
	/*Реестр центровозов МТР*/
	function registry(){
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('view_registry');
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

/*------------------------------------------------------------------------*/
	/*Экспорт в Excel текущего распоряжения*/
	function sample_order(){
		$this->load->model('Model_db');
		$id = $this->input->get('JSid_order');
		
		$query_order = sprintf("SELECT * FROM all_orders WHERE id_all_orders='%s';", trim($id));
		$result_order = $this->Model_db->select_id_all_order($query_order);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		/*Название листа*/
		$sheet->setTitle('Приложение 2');

		/*формируем название таблицы*/
		foreach ($result_order as $order) {
			$sheet->setCellValue('A1', 'Приложение №2 к распоряжению №____________________');
			$sheet->setCellValue('A2', 'Начальнику участка, базы Югорского УМТСиК ');
			$sheet->setCellValue('A3', '_________________________________________');
			$sheet->setCellValue('A4', 'Факс:____________________________________');
			$sheet->setCellValue('A5', 'Р А С П О Р Я Ж Е Н И Е № ' . $order['number_order'] . '* от ' . $order['date_order']);
			$sheet->setCellValue('A6', 'Прошу отгрузить в адрес: ' . $order['address_order'] . ' : со склада №' . $order['name_sklad']);
		}

		/*Формируем шапку таблицы*/
		$createArray = array('number', 'codeMTR', 'numberPart', 'nameMTR', 'ukObjectMTR', 'numberObjectMTR', 'sizeMTR', 'sumMTR', 'filialMTR', 'deliveryMTR', 'noteMTR');
		$table_columns = array ("№ п/п", "Код МТР", "Номер партии", "Наименование МТР", "Объект", "Инвентарный номер объекта", "Ед. изм.", "Кол-во", "Филиал", "Режим доставки МТР, условия транспортировки **", "Примечания");
		$number_table_columns = array ("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11");
		$column = 1;
		foreach ($table_columns as $item){
			$sheet->setCellValueByColumnAndRow($column, 8 ,$item);
			$column++;
		}
		$column = 1;
		foreach ($createArray as $item){
			$sheet->setCellValueByColumnAndRow($column, 9 ,$item);
			$column++;
		}
		$column = 1;
		foreach ($number_table_columns as $item){
			$sheet->setCellValueByColumnAndRow($column, 10 ,$item);
			$column++;
		}

		/*формируем тело Excel*/
		$row_start=11;
		$row_next = 0;
		$i=0;
		
		/*Стиль footer */
		$stylefooter = array(
			'font' => array(
				'size' => 10,
				'italic' => true,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Автоматическое вычисление ширины столбца A*/
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8);
		/*Ширину столбца B*/
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(35);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(25);

		/*Перенос по словам*/
		$spreadsheet->getActiveSheet()->getStyle('A8:K8')
			->getAlignment()->setWrapText(true);

		/*Стиль Header A1 - J1*/
		$styleHeader = array(
			'font' => array(
				'italic' => true,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Стиль Header A2 - J4*/
		$styleHeaderAI = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Стиль title*/
		$styleFootertitle = array(
			'font' => array(
				'size' =>11,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allBorders' => array (
					'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
				)
			),
			'fill' => array(
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'color'   => array(
					'rgb' => 'C0C0C0')
			),
		);

		/*Стиль Title A1-J1*/
		$styleTitle = array(
			'font' => array(
				'bold' => true,
				'size' => 16
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Стиль BODY*/
		$styleBody = array(
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allBorders' => array (
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
				)
			),
		);

		/*Объединение ячеек*/
		$spreadsheet->getActiveSheet()->mergeCells('A1:K1');
		$spreadsheet->getActiveSheet()->mergeCells('A2:K2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:K3');
		$spreadsheet->getActiveSheet()->mergeCells('A4:K4');
		$spreadsheet->getActiveSheet()->mergeCells('A5:K5');
		$spreadsheet->getActiveSheet()->mergeCells('A6:K6');
//		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
		$spreadsheet->getActiveSheet()->getStyle('A5:K5')->applyFromArray($styleTitle);
		$spreadsheet->getActiveSheet()->getStyle('A6:K6')->applyFromArray($styleTitle);

		/*Применение стиля к телу*/
		$sheet->getStyle('A8:K10')->applyFromArray($styleBody);
		$sheet->getStyle('A1:K1')->applyFromArray($styleHeader);
		$sheet->getStyle('A2:K2')->applyFromArray($styleHeaderAI);
		$sheet->getStyle('A3:K3')->applyFromArray($styleHeaderAI);
		$sheet->getStyle('A4:K4')->applyFromArray($styleHeaderAI);
		$sheet->getStyle('A8:K8')->applyFromArray($styleFootertitle);
		$sheet->getStyle('A9:K9')->applyFromArray($styleFootertitle);
		$sheet->getStyle('A10:K10')->applyFromArray($styleFootertitle);


		$writer = new Xlsx($spreadsheet);

		$filename = 'SampleOrder';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output'); // download file
	}

/*------------------------------------------------------------------------*/
/*Экспорт в Excel текущего распоряжения*/
	function export_Orders(){
		$this->load->model('Model_db');
		$id = $this->input->get('JSid_order');

		$query = sprintf("SELECT * FROM order_mtr WHERE id_bond_all_orders='%s' ORDER BY filialMTR;", trim($id));
		$query_order = sprintf("SELECT * FROM all_orders WHERE id_all_orders='%s';", trim($id));

		$result = $this->Model_db->select_id_all_order($query);
		$result_order = $this->Model_db->select_id_all_order($query_order);

//Запрос к базе на извлечение ФИО сотрудника создавшего распоряжение
		$query_author = sprintf("SELECT sername, name, patronymic, department FROM users WHERE username = '%s';", trim($result_order[0]['author_order']));
		$author = $this->Model_db->select_id_all_order($query_author);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		/*Название листа*/
		$sheet->setTitle('Приложение 2');

		/*формируем название таблицы*/
		foreach ($result_order as $order) {
			$sheet->setCellValue('A1', 'Приложение №2 к распоряжению №____________________');
			$sheet->setCellValue('A2', 'Начальнику участка, базы Югорского УМТСиК ');
			$sheet->setCellValue('A3', '_________________________________________');
			$sheet->setCellValue('A4', 'Факс:____________________________________');
			$sheet->setCellValue('A5', 'Р А С П О Р Я Ж Е Н И Е № ' . $order['number_order'] . '* от ' . date('d-m-Y', strtotime($order['date_order'])));
			$sheet->setCellValue('A6', 'Прошу отгрузить в адрес: ' . $order['address_order'] . ' : со склада №' . $order['name_sklad']);
		}

		/*Формируем шапку таблицы*/
		$table_columns = array ("№ п/п", "Код МТР", "Номер партии", "Наименование МТР", "Объект", "Инвентарный номер объекта", "Ед. изм.", "Кол-во", "Филиал", "Режим доставки МТР, условия транспортировки **", "Примечания");
		$number_table_columns = array ("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11");
		$column = 1;
		foreach ($table_columns as $item){
			$sheet->setCellValueByColumnAndRow($column, 8 ,$item);
			$column++;
		}
		$column = 1;
		foreach ($number_table_columns as $item){
			$sheet->setCellValueByColumnAndRow($column, 9 ,$item);
			$column++;
		}

		/*формируем тело Excel*/
		$row_start=10;
		$row_next = 0;
		$i=0;
		foreach ($result as $item){
			$row_next=$row_start+$i;

			/*Перенос по словам*/
			$spreadsheet->getActiveSheet()->getStyle('A'.$row_next.':Y'.$row_next)
				->getAlignment()->setWrapText(true);

			$sheet->setCellValue('A'.$row_next, $i+1);
			$sheet->setCellValue('B'.$row_next, $item['codeMTR']);
			$sheet->setCellValue('C'.$row_next, $item['numberPart']);
			$sheet->setCellValue('D'.$row_next, $item['nameMTR']);
			$sheet->setCellValue('E'.$row_next, $item['ukObjectMTR']);
			$sheet->setCellValue('F'.$row_next, $item['numberObjectMTR']);
			$sheet->setCellValue('G'.$row_next, $item['sizeMTR']);
			$sheet->setCellValue('H'.$row_next, $item['sumMTR']);
			$sheet->setCellValue('I'.$row_next, $item['filialMTR']);
			$sheet->setCellValue('J'.$row_next, $item['deliveryMTR']);
			$sheet->setCellValue('K'.$row_next, $item['noteMTR']);
			$i++;
		}
		/*Стиль footer */
		$stylefooter = array(
			'font' => array(
				'size' => 10,
				'italic' => true,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		$row_footer=$row_next;
		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, '*45 – код ресурсного отдела, который инициировал распоряжение ');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':K'.($row_footer));
		$sheet->getStyle('A'.($row_footer).':K'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, '*12 – порядковый номер распоряжения проставляется, согласно реестру распоряжений, который ведётся в ресурсном отделе.');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':K'.($row_footer));
		$sheet->getStyle('A'.($row_footer).':K'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, '**-Режим доставки МТР:');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':K'.($row_footer));
		$sheet->getStyle('A'.($row_footer).':K'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+1;
		$sheet->setCellValue('B'.$row_footer, '- аварийный (срочная доставка МТР к месту аварии на объектах МГ и КС или с целью исключения возникновения аварийной, сбойной ситуации);');
		$spreadsheet->getActiveSheet()->mergeCells('B'.($row_footer).':K'.($row_footer));
		$sheet->getStyle('B'.($row_footer).':K'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+1;;
		$sheet->setCellValue('B'.$row_footer, '- срочный (доставка МТР для завершения выполняемых работ, исключения срыва сроков плановых работ и т.п.);');
		$spreadsheet->getActiveSheet()->mergeCells('B'.($row_footer).':K'.($row_footer));
		$sheet->getStyle('B'.($row_footer).':K'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+1;
		$sheet->setCellValue('B'.$row_footer, '- плановый  (доставка МТР поступившего согласно сроков указанных в годовой заявке филиала на приобретение МТР, не требующего срочного вовлечения в производство).');
		$spreadsheet->getActiveSheet()->mergeCells('B'.($row_footer).':K'.($row_footer));
		$sheet->getStyle('B'.($row_footer).':K'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, 'при указании признаков: «аварийный», «срочно», в примечании указывается  причина, по которой МТР требует внеплановой доставки.');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':K'.($row_footer));
		$sheet->getStyle('A'.($row_footer).':K'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+2;
		$sheet->setCellValue('A'.$row_footer, 'Начальник отдела_______________________ ');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':K'.($row_footer));
		$row_footer=$row_footer+1;

		/*формируем footer*/
		foreach ($author as $item_order){
			$sheet->setCellValue('A'.$row_footer, 'Исп. '.$item_order['sername'].' '.$item_order['name'].' '.$item_order['patronymic']);
		}
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':K'.($row_footer));

		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, 'Тел._______________________');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':K'.($row_footer));

		/*Автоматическое вычисление ширины столбца A*/
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8);
		/*Ширину столбца B*/
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(35);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		/*Высота строк*/
//		$spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);

		/*Перенос по словам*/
		$spreadsheet->getActiveSheet()->getStyle('A8:K8')
			->getAlignment()->setWrapText(true);

		/*Стиль Header A1 - J1*/
		$styleHeader = array(
			'font' => array(
				'italic' => true,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Стиль Header A2 - J4*/
		$styleHeaderAI = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Стиль title*/
		$styleFootertitle = array(
			'font' => array(
				'size' =>11,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allBorders' => array (
					'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
				)
			),
			'fill' => array(
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'color'   => array(
					'rgb' => 'C0C0C0')
			),
		);

		/*Стиль Title A1-J1*/
		$styleTitle = array(
			'font' => array(
				'bold' => true,
				'size' => 16
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Стиль BODY*/
		$styleBody = array(
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allBorders' => array (
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
				)
			),
		);

		/*Объединение ячеек*/
		$spreadsheet->getActiveSheet()->mergeCells('A1:K1');
		$spreadsheet->getActiveSheet()->mergeCells('A2:K2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:K3');
		$spreadsheet->getActiveSheet()->mergeCells('A4:K4');
		$spreadsheet->getActiveSheet()->mergeCells('A5:K5');
		$spreadsheet->getActiveSheet()->mergeCells('A6:K6');
//		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
		$spreadsheet->getActiveSheet()->getStyle('A5:K5')->applyFromArray($styleTitle);
		$spreadsheet->getActiveSheet()->getStyle('A6:K6')->applyFromArray($styleTitle);

		/*Применение стиля к телу*/
		$sheet->getStyle('A8:K'.($row_next))->applyFromArray($styleBody);
		$sheet->getStyle('A1:K1')->applyFromArray($styleHeader);
		$sheet->getStyle('A2:K2')->applyFromArray($styleHeaderAI);
		$sheet->getStyle('A3:K3')->applyFromArray($styleHeaderAI);
		$sheet->getStyle('A4:K4')->applyFromArray($styleHeaderAI);
		$sheet->getStyle('A8:K8')->applyFromArray($styleFootertitle);
		$sheet->getStyle('A9:K9')->applyFromArray($styleFootertitle);


		$writer = new Xlsx($spreadsheet);

		foreach ($result_order as $order) {
		$filename = 'Order' .  $order['number_order'];
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output'); // download file
	}

	/*------------------------------------------------------------------------*/
/*Экспорт в Excel текущей информации о движении МТР*/
	function export_Motion(){
		$this->load->model('Model_db');
		$id = $this->input->get('id_motion');

		$query = sprintf("SELECT * FROM motion m JOIN order_mtr o ON m.id_bond_order_mtr=o.id_order WHERE id_bond_all_motion='%s' ORDER BY codeMTR;", trim($id));
		$query_motion = sprintf("SELECT * FROM all_motion WHERE id_all_motion='%s';", trim($id));
		$result_motion = $this->Model_db->select_id_all_order($query_motion);

		$query_orders = sprintf("SELECT * FROM all_orders WHERE bond_guid_motion='%s';", trim($result_motion[0]['number_motion']));

		$orders = $this->Model_db->select_id_all_order($query_orders);
		$result = $this->Model_db->select_id_all_order($query);


////Запрос к базе на извлечение ФИО сотрудника создавшего распоряжение
//		$query_author = sprintf("SELECT sername, name, patronymic, department FROM users WHERE username = '%s';", trim($result_motion[0]['author_order']));
//		$author = $this->Model_db->select_id_all_order($query_author);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		/*Название листа*/
		$sheet->setTitle('Приложение 3');

		/*формируем название таблицы*/
		$sheet->setCellValue('A1', 'Приложение №3 к распоряжению №____________________');
		$sheet->setCellValue('A5', '  Информация о движении МТР на базе, участке сформированно на основании:' );
		$row_start=6;
		$row_head = 0;
		$i=0;
		foreach ($orders as $order){
			$row_head=$row_start+$i;
			$sheet->setCellValue('A'.$row_head, 'Распоряжения '.'№'.$order['number_order'].' от '.date('d-m-Y', strtotime($order['date_order'])));
			$spreadsheet->getActiveSheet()->mergeCells('A'.$row_head.':AD'.$row_head);
			$i++;
		}
		$row_table_head=$row_head+1;
		/*Формируем шапку таблицы*/
		$table_columns = array ("№ п/п", "Наименование МТР", "Массогобаритные характеристики***", "Ед. изм.", "Наименование объекта", "Инвентарный № объекта",
			"вес 1 ед.", "Всего", "Груз сформирован в контейнер/автотранспорт", "Дата поступления МТР на базу, участок", "Дата заявки на отгрузку	",
			"Дата отгрузки", "Информация об отгрузке на текущую дату", "Отгружено", "Остаток", "Наименование транзитного* или конечного получателя груза",
			"Наименование филиала получателя, указывается, в случае транзитной отправки груза", "№ накладной на отпуск МТР на сторону",
			"Дата накладной на отпуск МТР на сторону", "Примечание по доставке", "Приоритет(1,2,3)**", "Общие примечания");
		$number_table_columns = array ("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "29", "29" , "30");
		$sheet->setCellValue('A'.$row_table_head, '№ п/п');
		$sheet->setCellValue('B'.$row_table_head, 'Код МТР');
		$sheet->setCellValue('C'.$row_table_head, 'Наименование МТР');
		$sheet->setCellValue('D'.$row_table_head, 'Массогобаритные характеристики***');

		$sheet->setCellValue('G'.$row_table_head, 'Ед. изм.');
		$sheet->setCellValue('H'.$row_table_head, 'Наименование объекта');
		$sheet->setCellValue('I'.$row_table_head, 'Инвентарный № объекта');
		$sheet->setCellValue('J'.$row_table_head, 'Кол-во');
		$sheet->setCellValue('K'.$row_table_head, 'вес 1 ед.');
		$sheet->setCellValue('L'.$row_table_head, 'Всего');
        $sheet->setCellValue('M'.$row_table_head, 'Дата заявки на отгрузку');
        $sheet->setCellValue('N'.$row_table_head, 'Заявка на контейнер/автотранспорт');
        $sheet->setCellValue('O'.$row_table_head, 'Дата отгрузки');
		$sheet->setCellValue('P'.$row_table_head, 'Груз сформирован в контейнер/автотранспорт');
		$sheet->setCellValue('Q'.$row_table_head, 'Отгружено');
		$sheet->setCellValue('R'.$row_table_head, 'Остаток');
		$sheet->setCellValue('S'.$row_table_head, 'Наименование транзитного* или конечного получателя груза');
		$sheet->setCellValue('T'.$row_table_head, 'Наименование филиала получателя');
		$sheet->setCellValue('U'.$row_table_head, 'Накладная формы М11');

		$sheet->setCellValue('W'.$row_table_head, 'Приоритет(1,2,3)**');
		$sheet->setCellValue('X'.$row_table_head, 'Примечание по доставке');
		$sheet->setCellValue('Y'.$row_table_head, 'Общие примечания');
		$sheet->setCellValue('Z'.$row_table_head, 'Заполняется транзитным участком, базой ЮУМТСиК');

		$row_table_head_merge=$row_table_head+1;
		$sheet->setCellValue('D'.$row_table_head_merge, 'Длина, м');
		$sheet->setCellValue('E'.$row_table_head_merge, 'Ширина, м');
		$sheet->setCellValue('F'.$row_table_head_merge, 'Высота, м');

		$sheet->setCellValue('U'.$row_table_head_merge, '№ накладной');
		$sheet->setCellValue('V'.$row_table_head_merge, 'Дата накладной');

		$sheet->setCellValue('Z'.$row_table_head_merge, 'Дата поступления МТР на базу, участок');
		$sheet->setCellValue('AA'.$row_table_head_merge, '№ накладной М 15');
		$sheet->setCellValue('AB'.$row_table_head_merge, 'Дата накладной М 15');
		$sheet->setCellValue('AC'.$row_table_head_merge, 'Дата получения МТР филиалом получателя');
		$sheet->setCellValue('AD'.$row_table_head_merge, 'Принято, кол-во');

		$column = 1;
		$row_table_head_number=$row_table_head_merge+1;
		foreach ($number_table_columns as $item){
			$sheet->setCellValueByColumnAndRow($column, $row_table_head_number, $item);
			$column++;
		}

		/*формируем тело Excel*/
		$row_table_head_number_t = $row_table_head_number + 1;
		$row_next = 0;
		$n=0;
		foreach ($result as $item){
			$row_next = $row_table_head_number_t + $n;
			/*Перенос по словам*/
			$spreadsheet->getActiveSheet()->getStyle('A'.$row_next.':AC'.$row_next)
				->getAlignment()->setWrapText(true);

			$sheet->setCellValue('A'.$row_next, $n+1);
			$sheet->setCellValue('B'.$row_next, $item['codeMTR']);
			$sheet->setCellValue('C'.$row_next, $item['nameMTR']);

			$sheet->setCellValue('D'.$row_next, $item['length_motion']);
			$sheet->setCellValue('E'.$row_next, $item['width_motion']);
			$sheet->setCellValue('F'.$row_next, $item['height_motion']);

			$sheet->setCellValue('G'.$row_next, $item['sizeMTR']);
			$sheet->setCellValue('H'.$row_next, $item['ukObjectMTR']);
			$sheet->setCellValue('I'.$row_next, $item['numberObjectMTR']);
			$sheet->setCellValue('J'.$row_next, $item['sumMTR']);
			$sheet->setCellValue('K'.$row_next, $item['weight_motion']);
			$sheet->setCellValue('L'.$row_next, $item['total_motion']);
            if($item['dateRequest_motion'] == NULL || $item['dateRequest_motion'] == '1970-01-01' || $item['dateRequest_motion'] == '0000-00-00') { $dateRequest_motion = '-';  } else { $dateRequest_motion = (date('d-m-Y', strtotime($item['dateRequest_motion']))); }
            $sheet->setCellValue('M'.$row_next, $dateRequest_motion );
            $sheet->setCellValue('N'.$row_next, $item['infoShipments_motion']);
            if($item['dateShipments_motion'] == NULL|| $item['dateShipments_motion'] == '1970-01-01' || $item['dateShipments_motion'] == '0000-00-00') { $dateShipments_motion = '-';  } else { $dateShipments_motion = (date('d-m-Y', strtotime($item['dateShipments_motion']))); }
            $sheet->setCellValue('O'.$row_next, $dateShipments_motion);
            $sheet->setCellValue('P'.$row_next, $item['cargo_motion']);
			$sheet->setCellValue('Q'.$row_next, $item['shipped_motion']);

			$sheet->setCellValue('R'.$row_next, $item['remains_motion']);
			$sheet->setCellValue('S'.$row_next, $item['filialMTR']);
			$sheet->setCellValue('T'.$row_next, $item['address_orderMTR']);
			$sheet->setCellValue('U'.$row_next, $item['numberOverhead_motion']);

            if($item['dateOverhead_motion'] == NULL || $item['dateOverhead_motion'] == '1970-01-01' || $item['dateOverhead_motion'] == '0000-00-00') { $dateOverhead_motion = '-';  } else { $dateOverhead_motion = (date('d-m-Y', strtotime($item['dateOverhead_motion']))); }
            $sheet->setCellValue('V'.$row_next, $dateOverhead_motion);
			$sheet->setCellValue('W'.$row_next, $item['deliveryMTR']);
			$sheet->setCellValue('X'.$row_next, $item['noteMTR']);
			$sheet->setCellValue('Y'.$row_next, $item['note_motion']);

            if($item['dateArrival_motion'] == NULL || $item['dateArrival_motion'] == '1970-01-01' || $item['dateArrival_motion'] == '0000-00-00') { $dateArrival_motion = '-';  } else { $dateArrival_motion = (date('d-m-Y', strtotime($item['dateArrival_motion']))); }
            $sheet->setCellValue('Z'.$row_next, $dateArrival_motion);
			$sheet->setCellValue('AA'.$row_next, $item['numberM15_motion']);
            if($item['dateM15_motion'] == NULL || $item['dateM15_motion'] == '1970-01-01' || $item['dateM15_motion'] == '0000-00-00') { $dateM15_motion = '-';  } else { $dateM15_motion = (date('d-m-Y', strtotime($item['dateM15_motion']))); }
            $sheet->setCellValue('AB'.$row_next, $dateM15_motion);
            if($item['dateFilial_motion'] == NULL || $item['dateFilial_motion'] == '1970-01-01' || $item['dateFilial_motion'] == '0000-00-00') { $dateFilial_motion = '-';  } else { $dateFilial_motion = (date('d-m-Y', strtotime($item['dateFilial_motion']))); }
            $sheet->setCellValue('AC'.$row_next, $dateFilial_motion);
			$sheet->setCellValue('AD'.$row_next, $item['recd']);
			$n++;
		}
		/*Стиль footer */
		$stylefooter = array(
			'font' => array(
				'size' => 10,
				'italic' => true,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		$row_footer=$row_next;
		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, '*транзитный получатель- это участок или база по хранению и реализации МТР Югорского УМТСиК или филиал Общества , который в логистической схеме доставки груза конечному получателю, выступает как база временного хранения  ');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':AD'.($row_footer));
		$sheet->getStyle('A'.($row_footer).':AD'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, '**-1-аварийный, 2-срочный, 3 -плановый');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':AD'.($row_footer));
		$sheet->getStyle('A'.($row_footer).':AD'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, '***-указывается представителем базы или участка погрузочно-разгрузочных работ  по запросу перевозчика ');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':AD'.($row_footer));
		$sheet->getStyle('A'.($row_footer).':AD'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, '****-заполняется при наличии выписанной накладной формы М-15, графа необходимо для исполнения распоряжения №_______в части уведомления филиалов о необходимости получения МТР с приобъектного склада.');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':AD'.($row_footer));
		$sheet->getStyle('A'.($row_footer).':AD'.($row_footer))->applyFromArray($stylefooter);
		$row_footer=$row_footer+2;;
		$sheet->setCellValue('A'.$row_footer, 'Начальник участка, базы_______________________ ');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':AD'.($row_footer));

		/*формируем footer*/
//		foreach ($author as $item_order){
//			$sheet->setCellValue('A'.$row_footer, 'Исп. '.$item_order['sername'].' '.$item_order['name'].' '.$item_order['patronymic']);
//		}
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':AD'.($row_footer));

		$row_footer=$row_footer+1;
		$sheet->setCellValue('A'.$row_footer, 'Тел._______________________');
		$spreadsheet->getActiveSheet()->mergeCells('A'.($row_footer).':AD'.($row_footer));

		/*Автоматическое вычисление ширины столбца A*/
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8);
		/*Ширину столбца B*/
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
		$spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(12);
		$spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(25);
		$spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(25);
		$spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
		/*Высота строк*/
//		$spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);

		/*Перенос по словам*/
		$spreadsheet->getActiveSheet()->getStyle('A'.$row_table_head.':AD'.$row_table_head)
			->getAlignment()->setWrapText(true);
		$row_table_head_two=$row_table_head+1;
		$spreadsheet->getActiveSheet()->getStyle('A'.$row_table_head_two.':AD'.$row_table_head_two)
			->getAlignment()->setWrapText(true);


		/*Стиль Header A1 - X1*/
		$styleHeader = array(
			'font' => array(
				'italic' => true,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Стиль Header A2 - X4*/
		$styleHeaderAI = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Стиль title*/
		$styleFootertitle = array(
			'font' => array(
				'size' =>10,
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allBorders' => array (
					'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
				)
			),
			'fill' => array(
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'color'   => array(
					'rgb' => 'C0C0C0')
			),
		);

		/*Стиль Title A1-X1*/
		$styleTitle = array(
			'font' => array(
				'bold' => true,
				'size' => 16
			),
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
		);

		/*Стиль BODY*/
		$styleBody = array(
			'alignment' => array(
				'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allBorders' => array (
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
				)
			),
		);

		/*Объединение ячеек*/
		$spreadsheet->getActiveSheet()->mergeCells('A1:AD1');
		$spreadsheet->getActiveSheet()->mergeCells('A2:AD2');
		$spreadsheet->getActiveSheet()->mergeCells('A3:AD3');
		$spreadsheet->getActiveSheet()->mergeCells('A4:AD4');
		$spreadsheet->getActiveSheet()->mergeCells('A5:AD5');
		$spreadsheet->getActiveSheet()->mergeCells('D'.$row_table_head.':F'.$row_table_head);
		$spreadsheet->getActiveSheet()->mergeCells('U'.$row_table_head.':V'.$row_table_head);
		$spreadsheet->getActiveSheet()->mergeCells('Z'.$row_table_head.':AD'.$row_table_head);
//		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
		$spreadsheet->getActiveSheet()->getStyle('A5:AD5')->applyFromArray($styleTitle);
		$spreadsheet->getActiveSheet()->getStyle('A'.$row_start.':AD'.$row_head)->applyFromArray($styleTitle);

		/*Применение стиля к телу*/
		$sheet->getStyle('A'.$row_table_head.':AD'.($row_next))->applyFromArray($styleBody);
		$sheet->getStyle('A1:AD1')->applyFromArray($styleHeader);
		$sheet->getStyle('A2:AD2')->applyFromArray($styleHeaderAI);
		$sheet->getStyle('A3:AD3')->applyFromArray($styleHeaderAI);
		$sheet->getStyle('A4:AD4')->applyFromArray($styleHeaderAI);
		$sheet->getStyle('A'.$row_table_head.':AD'.$row_table_head)->applyFromArray($styleFootertitle);
		$sheet->getStyle('A'.$row_table_head_merge.':AD'.$row_table_head_merge)->applyFromArray($styleFootertitle);
		$sheet->getStyle('A'.$row_table_head_number.':AD'.$row_table_head_number)->applyFromArray($styleFootertitle);

		$writer = new Xlsx($spreadsheet);

		$filename = 'Information on MTR';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output'); // download file
	}


	/*------------------------------------------------------------------------*/
	/*Справочники*/
//	Склады
	function sklads()
	{
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
//		Добавление
			if (isset($_POST['button_create_sklad'])) {
				$sklad = $this->input->post('name_sklad');
				$date_create_sklad = date('Y-m-d');
				$query = sprintf("INSERT INTO sklads (name_sklad, date_create_sklad) 
								VALUES ('%s', '%s');", trim($sklad), trim($date_create_sklad));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query);
				header("Location: sklads");
			}

//		Выгрузка элемента из БД по ID
			if (isset($_GET['id_sklad']) && isset($_GET['check'])) {
				$id_sklad = $this->input->get('id_sklad');
				$query = sprintf("SELECT * FROM sklads WHERE id_sklad='%s';", trim($id_sklad));
				$this->load->model('Model_db');
				$result['sklad'] = $this->Model_db->show($query);
			}

//		Редактирование
			if (isset($_POST['id_sklad']) && isset($_POST['name_sklad'])) {
				$id_sklad = $this->input->post('id_sklad');
				$name_sklad = $this->input->post('name_sklad');
				$date_create_sklad = date('Y-m-d');
				$query_edit = sprintf("UPDATE sklads SET name_sklad='%s', date_create_sklad='%s' WHERE id_sklad='%s';", trim($name_sklad), trim($date_create_sklad), trim($id_sklad));
				print_r($query_edit);
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query_edit);
			}

//		Удаление
			if (isset($_POST['id_sklad']) && isset($_POST['checkDel'])) {
				$query = sprintf("DELETE FROM sklads WHERE id_sklad='%s';", trim($_POST['id_sklad']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Выгрузка всех элементов из БД
			$query = sprintf("SELECT * FROM sklads;");
			$this->load->model('Model_db');
			$result['sklads'] = $this->Model_db->show($query);
			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('catalog/view_sklads', $result);
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}
//	Объекты
	function objects()
	{
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
//		Добавление
			if (isset($_POST['button_create_object'])) {
				$object = $this->input->post('name_object');
				$date_create_object = date('Y-m-d');
				$query = sprintf("INSERT INTO objects (name_object, date_create_object) 
								VALUES ('%s', '%s');", trim($object), trim($date_create_object));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query);
				header("Location: objects");
			}

//		Выгрузка элемента из БД по ID
			if (isset($_GET['id_object']) && isset($_GET['check'])) {
				$id_object = $this->input->get('id_object');
				$query = sprintf("SELECT * FROM objects WHERE id_object='%s';", trim($id_object));
				$this->load->model('Model_db');
				$result['object'] = $this->Model_db->show($query);
			}

//		Редактирование
			if (isset($_POST['id_object']) && isset($_POST['name_object'])) {
				$id_object = $this->input->post('id_object');
				$name_object = $this->input->post('name_object');
				$date_create_object = date('Y-m-d');
				$query_edit = sprintf("UPDATE objects SET name_object='%s', date_create_object='%s' WHERE id_object='%s';", trim($name_object), trim($date_create_object), trim($id_object));
				print_r($query_edit);
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query_edit);
			}

//		Удаление
			if (isset($_POST['id_object']) && isset($_POST['checkDel'])) {
				$query = sprintf("DELETE FROM objects WHERE id_object='%s';", trim($_POST['id_object']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Выгрузка всех элементов из БД
			$query = sprintf("SELECT * FROM objects;");
			$this->load->model('Model_db');
			$result['objects'] = $this->Model_db->show($query);
			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('catalog/view_objects', $result);
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

//		Филиалы
	function filials()
	{
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
//		Добавление
			if (isset($_POST['button_create_filial'])) {
				$filial = $this->input->post('name_filial');
				$date_create_filial = date('Y-m-d');
				$query = sprintf("INSERT INTO filials (name_filial, date_create_filial) 
								VALUES ('%s', '%s');", trim($filial), trim($date_create_filial));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query);
				header("Location: filials");
			}

//		Выгрузка элемента из БД по ID
			if (isset($_GET['id_filial']) && isset($_GET['check'])) {
				$id_filial = $this->input->get('id_filial');
				$query = sprintf("SELECT * FROM filials WHERE id_filial='%s';", trim($id_filial));
				$this->load->model('Model_db');
				$result['filial'] = $this->Model_db->show($query);
			}

//		Редактирование
			if (isset($_POST['id_filial']) && isset($_POST['name_filial'])) {
				$id_filial = $this->input->post('id_filial');
				$name_filial = $this->input->post('name_filial');
				$date_create_filial = date('Y-m-d');
				$query_edit = sprintf("UPDATE filials SET name_filial='%s', date_create_filial='%s' WHERE id_filial='%s';", trim($name_filial), trim($date_create_filial), trim($id_filial));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query_edit);
			}

//		Удаление
			if (isset($_POST['id_filial']) && isset($_POST['checkDel'])) {
				$query = sprintf("DELETE FROM filials WHERE id_filial='%s';", trim($_POST['id_filial']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Выгрузка всех элементов из БД
			$query = sprintf("SELECT * FROM filials;");
			$this->load->model('Model_db');
			$result['filials'] = $this->Model_db->show($query);
			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('catalog/view_filials', $result);
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}
	//		Режим доставки
	function delivery_modes()
	{
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
//		Добавление
			if (isset($_POST['button_create_delivery_mode'])) {
				$delivery_mode = $this->input->post('name_delivery_mode');
				$date_create_delivery_mode = date('Y-m-d');
				$query = sprintf("INSERT INTO delivery_modes (name_delivery_mode, date_create_delivery_mode) 
								VALUES ('%s', '%s');", trim($delivery_mode), trim($date_create_delivery_mode));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query);
				header("Location: delivery_modes");
			}

//		Выгрузка элемента из БД по ID
			if (isset($_GET['id_delivery_mode']) && isset($_GET['check'])) {
				$id_delivery_mode = $this->input->get('id_delivery_mode');
				$query = sprintf("SELECT * FROM delivery_modes WHERE id_delivery_mode='%s';", trim($id_delivery_mode));
				$this->load->model('Model_db');
				$result['delivery_mode'] = $this->Model_db->show($query);
			}

//		Редактирование
			if (isset($_POST['id_delivery_mode']) && isset($_POST['name_delivery_mode'])) {
				$id_delivery_mode = $this->input->post('id_delivery_mode');
				$name_delivery_mode = $this->input->post('name_delivery_mode');
				$date_create_delivery_mode = date('Y-m-d');
				$query_edit = sprintf("UPDATE delivery_modes SET name_delivery_mode='%s', date_create_delivery_mode='%s' WHERE id_delivery_mode='%s';", trim($name_delivery_mode), trim($date_create_delivery_mode), trim($id_delivery_mode));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query_edit);
			}

//		Удаление
			if (isset($_POST['id_delivery_mode']) && isset($_POST['checkDel'])) {
				$query = sprintf("DELETE FROM delivery_modes WHERE id_delivery_mode='%s';", trim($_POST['id_delivery_mode']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Выгрузка всех элементов из БД
			$query = sprintf("SELECT * FROM delivery_modes;");
			$this->load->model('Model_db');
			$result['delivery_modes'] = $this->Model_db->show($query);
			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('catalog/view_delivery_modes', $result);
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}
//		Единицы измерения
	function measures()
	{
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
//		Добавление
			if (isset($_POST['button_create_measure'])) {
				$measure = $this->input->post('name_measure');
				$date_create_measure = date('Y-m-d');
				$query = sprintf("INSERT INTO measures (name_measure, date_create_measure) 
								VALUES ('%s', '%s');", trim($measure), trim($date_create_measure));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query);
				header("Location: measures");
			}

//		Выгрузка элемента из БД по ID
			if (isset($_GET['id_measure']) && isset($_GET['check'])) {
				$id_measure = $this->input->get('id_measure');
				$query = sprintf("SELECT * FROM measures WHERE id_measure='%s';", trim($id_measure));
				$this->load->model('Model_db');
				$result['measure'] = $this->Model_db->show($query);
			}

//		Редактирование
			if (isset($_POST['id_measure']) && isset($_POST['name_measure'])) {
				$id_measure = $this->input->post('id_measure');
				$name_measure = $this->input->post('name_measure');
				$date_create_measure = date('Y-m-d');
				$query_edit = sprintf("UPDATE measures SET name_measure='%s', date_create_measure='%s' WHERE id_measure='%s';", trim($name_measure), trim($date_create_measure), trim($id_measure));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query_edit);
			}

//		Включение
			if (isset($_POST['id_measure']) && isset($_POST['checkOn'])) {
				$query = sprintf("UPDATE measures SET show_measures=0 WHERE id_measure='%s';", trim($_POST['id_measure']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Отключение
			if (isset($_POST['id_measure']) && isset($_POST['checkOff'])) {
				$query = sprintf("UPDATE measures SET show_measures=1 WHERE id_measure='%s';", trim($_POST['id_measure']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Удаление
			if (isset($_POST['id_measure']) && isset($_POST['checkDel'])) {
				$query = sprintf("DELETE FROM measures WHERE id_measure='%s';", trim($_POST['id_measure']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Выгрузка всех элементов из БД
			$query = sprintf("SELECT * FROM measures;");
			$this->load->model('Model_db');
			$result['measures'] = $this->Model_db->show($query);
			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('catalog/view_measures', $result);
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

//	Отделы(склады)
	function departments()
	{
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
//		Добавление
			if (isset($_POST['button_create_department'])) {
				$department = $this->input->post('name_department');
				$number_department = $this->input->post('number_department');
				$date_create_department = date('Y-m-d');
				$query = sprintf("INSERT INTO departments (name_department, number_department, date_create_department) 
								VALUES ('%s', '%s', '%s');", trim($department), trim($number_department), trim($date_create_department));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query);
			}

//		Выгрузка элемента из БД по ID
			if (isset($_GET['id_department']) && isset($_GET['check'])) {
				$id_department = $this->input->get('id_department');
				$query = sprintf("SELECT * FROM departments WHERE id_department='%s';", trim($id_department));
				$this->load->model('Model_db');
				$result['department'] = $this->Model_db->show($query);
			}

//		Редактирование
			if (isset($_POST['id_department']) && isset($_POST['name_department'])) {
				$id_department = $this->input->post('id_department');
				$name_department = $this->input->post('name_department');
				$number_department = $this->input->post('number_department');
				$date_create_department = date('Y-m-d');
				$query_edit = sprintf("UPDATE departments SET name_department='%s', number_department='%s',  date_create_department='%s' WHERE id_department='%s';", trim($name_department), trim($number_department), trim($date_create_department), trim($id_department));
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query_edit);
			}

//		Удаление
			if (isset($_POST['id_department']) && isset($_POST['checkDel'])) {
				$query = sprintf("DELETE FROM departments WHERE id_department='%s';", trim($_POST['id_department']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Выгрузка всех элементов из БД
			$query = sprintf("SELECT * FROM departments;");
			$this->load->model('Model_db');
			$result['departments'] = $this->Model_db->show($query);
			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('catalog/view_department', $result);
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

//Филиалы
	function lpu()
	{
		$_username = $this->session->userdata('username');
		$_actions = $this->session->userdata('actions');
		if (isset ($_username) && (($_actions['admin']) == 1)) {
//		Добавление
			if (isset($_POST['button_create_lpu'])) {
				$this->load->model('Model_db');
				$locations = $this->input->post('locations');
				$lpu = $this->input->post('name_lpu');
				$date_create_lpu = date('Y-m-d');
				$query = sprintf("INSERT INTO lpu (id_bond_filials, name_lpu, date_create_lpu) 
								VALUES ('%s', '%s', '%s');", trim($locations), trim($lpu), trim($date_create_lpu));
				$this->Model_db->create_edit_delete($query);
				header("Location: lpu");
			}

//		Выгрузка элемента из БД по ID
			if (isset($_GET['id_lpu']) && isset($_GET['check'])) {
				$id_lpu = $this->input->get('id_lpu');
				$query = sprintf("SELECT * FROM lpu WHERE id_lpu='%s';", trim($id_lpu));
				$query_locations = sprintf("SELECT * FROM filials;");
				$this->load->model('Model_db');
				$result['lpus'] = $this->Model_db->show($query);
				$result['locations'] = $this->Model_db->show($query_locations);
			}

//		Редактирование
			if (isset($_POST['id_lpu']) && isset($_POST['name_lpu'])) {
				$id_lpu = $this->input->post('id_lpu');
				$name_lpu = $this->input->post('name_lpu');
				$locations = $this->input->post('location');
				$date_create_lpu = date('Y-m-d');
				$query_edit = sprintf("UPDATE lpu SET id_bond_filials='%s', name_lpu='%s', date_create_lpu='%s' WHERE id_lpu='%s';", trim($locations), trim($name_lpu), trim($date_create_lpu), trim($id_lpu));
				print_r($query_edit);
				$this->load->model('Model_db');
				$this->Model_db->create_edit_delete($query_edit);
			}

//		Включение
			if (isset($_POST['id_lpu']) && isset($_POST['checkOn'])) {
				$query = sprintf("UPDATE lpu SET show_lpu=0 WHERE id_lpu='%s';", trim($_POST['id_lpu']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Отключение
			if (isset($_POST['id_lpu']) && isset($_POST['checkOff'])) {
				$query = sprintf("UPDATE lpu SET show_lpu=1 WHERE id_lpu='%s';", trim($_POST['id_lpu']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Удаление
			if (isset($_POST['id_lpu']) && isset($_POST['checkDel'])) {
				$query = sprintf("DELETE FROM lpu WHERE id_lpu='%s';", trim($_POST['id_lpu']));
				$this->load->model("Model_db");
				$this->Model_db->create_edit_delete($query);
			}

//		Выгрузка всех элементов из БД
			$query = sprintf("SELECT * FROM lpu l JOIN filials f ON l.id_bond_filials=f.id_filial;");
			$query_locations = sprintf("SELECT * FROM filials;");
			$this->load->model('Model_db');
			$result['lpu'] = $this->Model_db->show($query);
			$result['locations'] = $this->Model_db->show($query_locations);
			$this->load->view('template/view_header');
			$this->load->view('template/view_menu');
			$this->load->view('catalog/view_lpu', $result);
			$this->load->view('template/view_footer');
		} else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

	function reports(){
        $_username = $this->session->userdata('username');
        if (isset ($_username) ) {
            $query_users = sprintf("SELECT department, sername, name, patronymic FROM users WHERE username = '%s';", trim($_username));
            $query_filials = sprintf("SELECT * FROM filials ORDER BY name_filial;");

            $this->load->model('Model_db');
            $result['filials'] = $this->Model_db->select_id_all_order($query_filials);
            $result['users'] = $this->Model_db->showUsers($query_users);
//Отчет по наименованию МТР
            if (isset($_POST['button_search_name_mtr'])) {
                $order['name_mtr'] = $this->input->post('name_mtr');
                $order['name_filial'] = $this->input->post('name_filial');
                if ($_POST['start_date_1'] != NULL) {
                    $order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date_1')));
                    $order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date_1')));
                }

                //Наименование МТР
                if (($order['name_mtr']) != NULL) {
                    $filter[] = sprintf("nameMTR LIKE '%%%s%%'", trim($order['name_mtr']));
                }

                //Наименование филиала
                if (($order['name_filial']) != NULL) {
                    $filter[] = sprintf("address_order LIKE '%%%s%%'", trim($order['name_filial']));
                    $filter_new[] = sprintf("address_order LIKE '%%%s%%'", trim($order['name_filial']));
                }

                //Промежуток дат
                if (isset($order['start_date']) && (isset($order['end_date']))) {
                    $filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                    $filter_new[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                }
                //Формирование запроса в зависимости от фильтров
                if (($order['name_mtr']) != NULL) {
                    $query = "SELECT number_order, date_order, id_all_orders, nameMTR, address_order, name_sklad, flag FROM all_orders a JOIN order_mtr o ON a.id_all_orders=o.id_bond_all_orders";
                    $query .= ' WHERE ' . implode(' AND ', $filter) . ';';
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query);
                }
                if (count($result['orders']) == 0) {
                    $result['flag'] = count($result['orders']);
                }
                $this->load->view('template/view_header');
                $this->load->view('template/view_menu');
                $this->load->view('reports/view_reports', $result);
                $this->load->view('template/view_footer');
            }
//Отчет по неотправленным МТР
            elseif (isset($_POST['button_search_mtr'])) {
                $order['name_mtr'] = $this->input->post('name_mtr_2');
                if ($_POST['start_date_2'] != NULL) {
                    $order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date_2')));
                    $order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date_2')));
                }

                //Наименование МТР
                if (($order['name_mtr']) != NULL) {
                    $filter[] = sprintf("nameMTR LIKE '%%%s%%'", trim($order['name_mtr']));
                }

                //Промежуток дат
                if (isset($order['start_date']) && (isset($order['end_date']))) {
                    $filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                    $filter_new[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                }
                //Формирование запроса в зависимости от фильтров
                if ((($order['name_mtr']) != NULL) || (($_POST['start_date_2']) != NULL)) {
                    $query = "SELECT number_order, date_order, id_all_orders, nameMTR, address_order, name_sklad, flag FROM all_orders a JOIN order_mtr o ON a.id_all_orders=o.id_bond_all_orders WHERE o.id_order not in (SELECT id_bond_order_mtr FROM motion)";
                    $query .= ' AND ' . implode(' AND ', $filter) . ';';
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query);
                } else {
                    $query = "SELECT number_order, date_order, id_all_orders, nameMTR, address_order, name_sklad, flag FROM all_orders a JOIN order_mtr o ON a.id_all_orders=o.id_bond_all_orders WHERE o.id_order not in (SELECT id_bond_order_mtr FROM motion);";
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query);
                }
                if (count($result['orders']) == 0) {
                    $result['flag'] = count($result['orders']);
                }
                $this->load->view('template/view_header');
                $this->load->view('template/view_menu');
                $this->load->view('reports/view_reports', $result);
                $this->load->view('template/view_footer');
            }
//Отчет по направлению
            elseif (isset($_POST['button_search_filials'])) {
                $order['name_filial'] = $this->input->post('name_filial_3');
                if ($_POST['start_date_3'] != NULL) {
                    $order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date_3')));
                    $order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date_3')));
                }

                //Наименование филиала
                if (($order['name_filial']) != NULL) {
                    $filter[] = sprintf("address_order LIKE '%%%s%%'", trim($order['name_filial']));
                    $filter_new[] = sprintf("address_order LIKE '%%%s%%'", trim($order['name_filial']));
                }

                //Промежуток дат
                if (isset($order['start_date']) && (isset($order['end_date']))) {
                    $filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                    $filter_new[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                }
                //Формирование запроса в зависимости от фильтров
                if ((($order['name_filial']) != NULL) || (($_POST['start_date_3']) != NULL)) {
                    $query = "SELECT number_order, date_order, id_all_orders, address_order, name_sklad, flag FROM all_orders";
                    $query .= ' WHERE ' . implode(' AND ', $filter) . ';';
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query);
                } else {
                    $query = "SELECT number_order, date_order, id_all_orders, address_order, name_sklad, flag FROM all_orders;";
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query);
                }
                if (count($result['orders']) == 0) {
                    $result['flag'] = count($result['orders']);
                }
                $this->load->view('template/view_header');
                $this->load->view('template/view_menu');
                $this->load->view('reports/view_reports', $result);
                $this->load->view('template/view_footer');
            }
//Отчет по статусу распоряжений
            elseif (isset($_POST['button_search_status_orders'])) {
                $order['status'] = $this->input->post('status');
                if ($_POST['start_date_4'] != NULL) {
                    $order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date_4')));
                    $order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date_4')));
                }

                //Наименование филиала
                if (($order['status']) != NULL) {
                    $filter[] = sprintf("flag LIKE '%s'", trim($order['status']));
                    $filter_new[] = sprintf("flag LIKE '%s'", trim($order['status']));
                }

                //Промежуток дат
                if (isset($order['start_date']) && (isset($order['end_date']))) {
                    $filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                    $filter_new[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
                }
                //Формирование запроса в зависимости от фильтров
                if ((($order['status']) != NULL) || (($_POST['start_date_4']) != NULL)) {
                    $query = "SELECT number_order, date_order, id_all_orders, address_order, name_sklad, flag FROM all_orders";
                    $query .= ' WHERE ' . implode(' AND ', $filter) . ';';
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query);
                } else {
                    $query = "SELECT number_order, date_order, id_all_orders, address_order, name_sklad, flag FROM all_orders;";
                    $this->load->model('Model_db');
                    $result['orders'] = $this->Model_db->select_id_all_order($query);
                }
                if (count($result['orders']) == 0) {
                    $result['flag'] = count($result['orders']);
                }
                $this->load->view('template/view_header');
                $this->load->view('template/view_menu');
                $this->load->view('reports/view_reports', $result);
                $this->load->view('template/view_footer');
            }
            else {
                $this->load->view('template/view_header');
                $this->load->view('template/view_menu');
                $this->load->view('reports/view_reports', $result);
                $this->load->view('template/view_footer');
            }

        }  else {
            $this->load->view('template/view_header');
            $this->load->view('view_auth');
            $this->load->view('template/view_footer');
        }
    }

	function report_motions(){
		$_username = $this->session->userdata('username');
		if (isset ($_username) ) {
			$query_users = sprintf("SELECT department, sername, name, patronymic FROM users WHERE username = '%s';", trim($_username));
			$query_filials = sprintf("SELECT * FROM filials ORDER BY name_filial;");

			$this->load->model('Model_db');
			$result['filials'] = $this->Model_db->select_id_all_order($query_filials);
			$result['users'] = $this->Model_db->showUsers($query_users);
//Отчет по наименованию МТР
			if (isset($_POST['button_search_name_mtr'])) {
				$order['name_mtr'] = $this->input->post('name_mtr');
				$order['name_filial'] = $this->input->post('name_filial');
				if ($_POST['start_date_1'] != NULL) {
					$order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date_1')));
					$order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date_1')));
				}

				//Наименование МТР
				if (($order['name_mtr']) != NULL) {
					$filter[] = sprintf("nameMTR LIKE '%%%s%%'", trim($order['name_mtr']));
				}

				//Наименование филиала
				if (($order['name_filial']) != NULL) {
					$filter[] = sprintf("address_orderMTR LIKE '%%%s%%'", trim($order['name_filial']));
					$filter_new[] = sprintf("address_orderMTR LIKE '%%%s%%'", trim($order['name_filial']));
				}

				//Промежуток дат
				if (isset($order['start_date']) && (isset($order['end_date']))) {
					$filter[] = sprintf("date_orderMTR BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
					$filter_new[] = sprintf("date_orderMTR BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
				}
				//Формирование запроса в зависимости от фильтров
				if (($order['name_mtr']) != NULL) {
					$query = "SELECT * FROM motion m JOIN order_mtr o ON m.id_bond_order_mtr=o.id_order";
					$query .= ' WHERE ' . implode(' AND ', $filter) . ';';
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query);
				}
				if (count($result['orders']) == 0) {
					$result['flag'] = count($result['orders']);
				}
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('reports/view_report_motions', $result);
				$this->load->view('template/view_footer');
			}
//Отчет по неотправленным МТР
			elseif (isset($_POST['button_search_mtr'])) {
                $order['name_filial'] = $this->input->post('name_filial_2');

                if ($_POST['start_date_2'] != NULL) {
					$order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date_2')));
					$order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date_2')));
				}

                //Наименование филиала
                if (($order['name_filial']) != NULL) {
                    $filter[] = sprintf("address_orderMTR LIKE '%%%s%%'", trim($order['name_filial']));
                    $filter_new[] = sprintf("address_orderMTR LIKE '%%%s%%'", trim($order['name_filial']));
                }

				//Промежуток дат
				if (isset($order['start_date']) && (isset($order['end_date']))) {
					$filter[] = sprintf("date_orderMTR BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
					$filter_new[] = sprintf("date_orderMTR BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
				}

				//Формирование запроса в зависимости от фильтров
				if ((($order['name_filial']) != NULL) || (($_POST['start_date_2']) != NULL)) {
                    $query = "SELECT * FROM order_mtr o WHERE o.id_order not in (SELECT id_bond_order_mtr FROM motion)";
                    $query .= ' AND ' . implode(' AND ', $filter) . ';';
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query);
				} else {
					$query = "SELECT * FROM order_mtr o WHERE o.id_order not in (SELECT id_bond_order_mtr FROM motion);";
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query);
				}
				if (count($result['orders']) == 0) {
					$result['flag'] = count($result['orders']);
				}
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('reports/view_report_motions', $result);
				$this->load->view('template/view_footer');
			}
//Отчет по направлению
			elseif (isset($_POST['button_search_filials'])) {
				$order['name_filial'] = $this->input->post('name_filial_3');
				if ($_POST['start_date_3'] != NULL) {
					$order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date_3')));
					$order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date_3')));
				}

				//Наименование филиала
				if (($order['name_filial']) != NULL) {
					$filter[] = sprintf("address_orderMTR LIKE '%%%s%%'", trim($order['name_filial']));
					$filter_new[] = sprintf("address_orderMTR LIKE '%%%s%%'", trim($order['name_filial']));
				}

				//Промежуток дат
				if (isset($order['start_date']) && (isset($order['end_date']))) {
					$filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
					$filter_new[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
				}
				//Формирование запроса в зависимости от фильтров
				if ((($order['name_filial']) != NULL) || (($_POST['start_date_3']) != NULL)) {
					$query = "SELECT * FROM motion m JOIN order_mtr o ON m.id_bond_order_mtr=o.id_order";
					$query .= ' WHERE ' . implode(' AND ', $filter) . ';';
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query);
				} else {
					$query = "SELECT * FROM motion m JOIN order_mtr o ON m.id_bond_order_mtr=o.id_order;";
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query);
				}
				if (count($result['orders']) == 0) {
					$result['flag'] = count($result['orders']);
				}
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('reports/view_report_motions', $result);
				$this->load->view('template/view_footer');
			}
//Отчет по статусу распоряжений
			elseif (isset($_POST['button_search_status_orders'])) {
				$order['status'] = $this->input->post('status');
				if ($_POST['start_date_4'] != NULL) {
					$order['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date_4')));
					$order['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date_4')));
				}

				//Наименование филиала
				if (($order['status']) != NULL) {
					$filter[] = sprintf("flag LIKE '%s'", trim($order['status']));
					$filter_new[] = sprintf("flag LIKE '%s'", trim($order['status']));
				}

				//Промежуток дат
				if (isset($order['start_date']) && (isset($order['end_date']))) {
					$filter[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
					$filter_new[] = sprintf("date_order BETWEEN '%s' AND '%s'", trim($order['start_date']), trim($order['end_date']));
				}
				//Формирование запроса в зависимости от фильтров
				if ((($order['status']) != NULL) || (($_POST['start_date_4']) != NULL)) {
					$query = "SELECT number_order, date_order, id_all_orders, address_order, name_sklad, flag FROM all_orders";
					$query .= ' WHERE ' . implode(' AND ', $filter) . ';';
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query);
				} else {
					$query = "SELECT number_order, date_order, id_all_orders, address_order, name_sklad, flag FROM all_orders;";
					$this->load->model('Model_db');
					$result['orders'] = $this->Model_db->select_id_all_order($query);
				}
				if (count($result['orders']) == 0) {
					$result['flag'] = count($result['orders']);
				}
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('reports/view_report_motions', $result);
				$this->load->view('template/view_footer');
			}
			else {
				$this->load->view('template/view_header');
				$this->load->view('template/view_menu');
				$this->load->view('reports/view_report_motions', $result);
				$this->load->view('template/view_footer');
			}

		}  else {
			$this->load->view('template/view_header');
			$this->load->view('view_auth');
			$this->load->view('template/view_footer');
		}
	}

	function manual(){
		$this->load->view('template/view_header');
		$this->load->view('template/view_menu');
		$this->load->view('view_manual');
		$this->load->view('template/view_footer');
	}
}
