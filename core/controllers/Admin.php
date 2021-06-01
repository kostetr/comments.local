<?php

namespace core\controllers;

use core\controllers\AbstractController;
use core\models\AdminModel;
use core\Router;

class Admin extends AbstractController {

    public function __construct() {
        if (!Auth::checkValidation() || !isset($_SESSION['access_level'])) {
            Router::redirect('auth/');
        }

        if ($_SESSION['access_level'] > 100) {
            Router::redirect('CP/');
        }

        parent::__construct();
        $this->model = new AdminModel();
        $this->viewer->template = "main.php";
    }

    public function action_index() {
//Пункт меню используется в условии меню вьюшки Admin 
        $this->viewer->menu = 0;
        $tempArray = $this->model->showAllLibsWithCommentsForAdm();
        $arrayIdLibsWithCommentsDorAdm = array();
        foreach ($tempArray as $value) {
            array_push($arrayIdLibsWithCommentsDorAdm, $value["file_id"]);
        }
        $filters = array_unique($arrayIdLibsWithCommentsDorAdm);
        $arrayList = array();
        foreach ($filters as $filter_item) {
            foreach ($tempArray as $value) {
                if ($value['file_id'] == $filter_item) {
                    array_push($arrayList, ['file_id' => $value['file_id'], 'file_name' => $value['file_name'], 'library_name' => $value['library_name']]);
                    break;
                }
            }
        }
        if (!empty($arrayList)) {
            $this->viewer->list = $arrayList;
        } else {
            $this->viewer->listEmpty = True;
        }

        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_index_view.php";
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_commentforadm() {
//Пункт меню используется в условии меню вьюшки Admin



        if (filter_input_array(INPUT_POST)['file_id'] != null) {
            $this->viewer->menu = filter_input_array(INPUT_POST)['menu'];
            $file_id = filter_input_array(INPUT_POST)['file_id'];
        } elseif (filter_input_array(INPUT_GET)['file_id'] != null) {
            $this->viewer->menu = filter_input_array(INPUT_GET)['menu'];
            $file_id = filter_input_array(INPUT_GET)['file_id'];
        } else {
            Router::notFoundAction();
        }

        $this->viewer->libsWithComment = $this->model->showAllLibsWithCommentsForAdmByFileId($file_id);
//        var_dump($this->viewer->libsWithComment );
//        exit();
//["file_name"]=> string(10) "_bga_p0.40" 
//["library_name"]=> string(16) "BGA Pitch 0.40mm" 
//["id_user"]=> string(1) "1" 
//["id_user_check"]=> string(1) "2" 
//["file_completed"]=> NULL 
//["file_completed_date"]=> NULL 
//["pattern_id"]=> string(1) "6" 
//["file_id"]=> string(3) "265" 
//["pattern_name"]=> string(14) "ANALOG_CB-16-6" 
//["pattern_comments"]=> string(98) "15-01-2020 20:16:11 - Рябушенко К.Г. - Комментарий админу" 
//["pattern_completed"]=> string(1) "1" 
//["pattern_checked"]=> string(1) "0" 
//["comment_for_adm"]=> string(1) "1" 
//["user_login"]=> string(7) "kostetr" 
//["user_snp"]=> string(25) "Рябушенко К.Г." 
//["user_check_login"]=> string(8) "kostetr2" 
//["user_check_snp"]=> string(26) "Рябушенко2 К.Г."


        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_commentforadm_view.php";
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_files() {
//Пункт меню используется в условии меню вьюшки Admin 
        $this->viewer->menu = 1;
        $this->viewer->files = $this->model->showAllFiles();
        foreach ($this->viewer->files as $key => $value) {
            $this->viewer->files[$key]['completed_date'] = ControlPanel::editBirthday($value['completed_date']);
        }

        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_files_view.php";
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_editfile() {
        $getArrayTemp = filter_input_array(INPUT_GET);
        $this->viewer->menu = filter_input_array(INPUT_GET)['menu'];
        $this->viewer->files = $this->model->showTableWhere('files', 'id', $getArrayTemp['id']);
//        var_dump($this->viewer->files );
//        exi();
//        ["id"]=> string(3) "263" 
//        ["file_name"]=> string(11) "_bga_p0.252" 
//        ["name"]=> string(17) "BGA Pitch 0.252mm" 
//        ["id_user"]=> NULL ["id_user_check"]=> NULL 
//        ["completed"]=> NULL ["completed_date"]=> NULL
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_editfile_view.php";
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_updatefile() {
        $postArrayTemp = filter_input_array(INPUT_POST);
        $menu = filter_input_array(INPUT_POST)['menu'];
        if ($this->model->updateFileName($postArrayTemp['file_name'], $postArrayTemp['name'], $postArrayTemp['id'])) {
            $_SESSION['message']['edit-file'] = 'Файл отредактирован!';
            Router::redirect('admin/editfile/?menu=' . $menu . '&id=' . $postArrayTemp['id']);
        } else {
            $_SESSION['Errors']['edit-file'] = 'Произошла ошибка такой файл уже существует!';
            Router::redirect('admin/editfile/?menu=' . $menu . '&id=' . $postArrayTemp['id']);
        }
    }

    public function action_allpatterns() {
//Пункт меню используется в условии меню вьюшки Admin         
        $this->viewer->menu = filter_input_array(INPUT_GET)['menu'];
        $getArrayTemp = filter_input_array(INPUT_GET);
        $this->viewer->patterns = $this->model->showTableWhere('patterns', 'file_id', $getArrayTemp['id']);
        $this->viewer->file_id = $getArrayTemp['id'];
//        var_dump($this->viewer->patterns);
//        exit();
//        ["id"] => string(1) "1"
//        ["file_id"] => string(3) "264"
//        ["pattern_name"] => string(12) "ONSEMI_567JZ"
//        ["comments"] => string(1015) "1"
//        ["completed"] => string(1) "1"
//        ["checked"] => string(1) "0"
//        ["comment_for_adm"] => string(1) "0"
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_allpatterns_view.php";
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
        $_SESSION['temp-array'] = null;
    }

    public function action_deletefiles() {
        $postArrayTemp = filter_input_array(INPUT_POST);
        if (count($postArrayTemp) > 0) {
            if ($this->model->deleteFiles($postArrayTemp)) {
                $_SESSION['message']['delete-files'] = 'Корпуса удалены с БД!';
            } else {
                $_SESSION['Errors']['delete-files'] = 'Ошибка! Обратитесь к разработчику!';
            }
        } else {
            $_SESSION['Errors']['delete-files'] = 'Ошибка! Выберите файл!';
        }
        Router::redirect('admin/files/');
    }

    public function action_deleteormovepatterns() {
        $menu = filter_input_array(INPUT_POST)['menu'];
        $file_id = filter_input_array(INPUT_POST)['file_id'];
        $postArrayTemp = filter_input_array(INPUT_POST);
        unset($postArrayTemp['menu'], $postArrayTemp['file_id']);
        if (count($postArrayTemp) > 1) {
            if (isset($postArrayTemp['delete'])) {
                unset($postArrayTemp['delete']);
                if ($this->model->deletePatterns($postArrayTemp)) {
                    $_SESSION['message']['delete-or-move'] = 'Корпуса удалены с БД!';
                } else {
                    $_SESSION['Errors']['delete-or-move'] = 'Ошибка! Обратитесь к разработчику!';
                }
            } elseif (isset($postArrayTemp['move'])) {
                unset($postArrayTemp['move']);
                $_SESSION['temp-array'] = $postArrayTemp;
                Router::redirect('admin/allfiles4/?menu=' . $menu . '&id=' . $file_id);
            }
        } else {
            $_SESSION['Errors']['delete-or-move'] = 'Ошибка! Выберите корпус!';
        }
        Router::redirect('admin/allpatterns/?menu=' . $menu . '&id=' . $file_id);
    }

    public function action_moveallpaterns() {
        $menu = filter_input_array(INPUT_POST)['menu'];
        $file_id = filter_input_array(INPUT_POST)['file_id'];
        $file_id_new = filter_input_array(INPUT_POST)['file_id_new'];
        $file_name_new = filter_input_array(INPUT_POST)['file_name_new'];
        if ($this->model->movepaterns($file_id_new, $_SESSION['temp-array'])) {
            $_SESSION['message']['move'] = 'Корпуса (' . count($_SESSION['temp-array']) . 'шт.) были успешно перемещены в библиотеку: ' . $file_name_new;
        } else {
            $_SESSION['Errors']['move'] = 'Ошибка! обратитесь к разработчику!';
        }
        $_SESSION['temp-array']=NULL;
        Router::redirect('admin/allpatterns/?menu=' . $menu . '&id=' . $file_id);
    }

    //Поиск корпусов по названии.
    public function action_search() {
        // Пункт меню используется в условии меню вьюшки CP 
        $this->viewer->menu = 3;
        $this->viewer->patternSearch = filter_input_array(INPUT_POST)['search'];

        if (!isset($this->viewer->patternSearch)) {
            $this->viewer->patternSearch = filter_input_array(INPUT_GET)['search'];
        }

        if (isset($this->viewer->patternSearch)) {
            $this->viewer->patterns = $this->model->selectPatternsForSearch($this->viewer->patternSearch);
        }
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . 'admin_search_view.php';
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_editpattern() {

        $id = filter_input_array(INPUT_GET)["id"];
        $this->viewer->anchor = filter_input_array(INPUT_GET)["anchor"];
        $this->viewer->search = filter_input_array(INPUT_GET)["search"];
        $this->viewer->menu = filter_input_array(INPUT_GET)["menu"];
        if (isset($id) && strlen($id) != 0 && $id != NULL) {
            $this->viewer->pattern = $this->model->showTableWhere('patterns', 'id', $id);
//            ["id"] => string(1) "1"
//            ["file_id"] => string(3) "264"
//            ["pattern_name"] => string(12) "ONSEMI_567JZ"
//            ["comments"] => string(1015) "13-01-202 nulla pariatur. Equi officia deserunt mollit anim id est laborum."
//            ["completed"] => string(1) "1"
//            ["checked"] => string(1) "0"
//            ["comment_for_adm"] => string(1) "0"
            $this->viewer->file = $this->model->showTableWhere('files', 'id', $this->viewer->pattern['0']['file_id']);
//            ["id"] => string(3) "264"
//            ["file_name"] => string(10) "_bga_p0.35"
//            ["name"] => string(16) "BGA Pitch 0.35mm"
//            ["id_user"] => string(1) "1"
//            ["id_user_check"] => string(1) "2"
//            ["completed"] => NULL
//            ["completed_date"] => NUL
            $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . 'admin_editpattern_view.php';
            $this->viewer->show();
        } else {
            Router::notFoundAction();
        }
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
        $_SESSION['old_file_id'] = null;
    }

    public function action_savenewpattern() {
        $postArrayTemp = filter_input_array(INPUT_POST);
        $menu = filter_input_array(INPUT_POST)['menu'];
//        ["pattern_name"]=> string(3) "qqq" 
//        ["pattern_comments"]=> string(3) "www" 
//        ["file_id"]=> string(3) "280" }


        if ($this->model->insertNewPattern($postArrayTemp)) {
            $_SESSION['message']['insert-new-pattern'] = 'Корпус добавлен!';
            Router::redirect('admin/allpatterns/?menu=' . $menu . '&id=' . $postArrayTemp['file_id']);
        } else {
            $_SESSION['Errors']['insert-new-pattern'] = 'Произошла ошибка корпус с таким именем уже существует!';
            Router::redirect('admin/allpatterns/?menu=' . $menu . '&id=' . $postArrayTemp['file_id']);
        }
    }

    public function action_updatepattern() {
        $postArrayTemp = filter_input_array(INPUT_POST);
        $menu = filter_input_array(INPUT_POST)['menu'];
//        var_dump($postArrayTemp);
//        exit();
//        ["pattern_name"] => string(12) "dfgdfgdfgdfg"
//        ["pattern_comments"] => string(519) "13-01-2020 19:32:22 - umqweqweqwe"
//        ["completed"] => string(1) "1"
//        ["checked"] => string(1) "1"
//        ["id"] => string(1) "2"
//        ["file_id"] => string(3) "264"
        if (isset($postArrayTemp['old_file_id']) && strlen($postArrayTemp['old_file_id']) > 0 && $postArrayTemp['old_file_id'] !== NULL) {
            $postArrayTemp['file_id'] = $postArrayTemp['old_file_id'];
        }
        if (!isset($postArrayTemp['completed']) && strlen($postArrayTemp['completed']) == 0) {
            $postArrayTemp['completed'] = 0;
        }
        if (!isset($postArrayTemp['checked']) && strlen($postArrayTemp['checked']) == 0) {
            $postArrayTemp['checked'] = 0;
        }
        if ($this->model->updatePattern2($postArrayTemp)) {
            $_SESSION['message']['insert-new-pattern'] = 'Корпус сохранен!';
        } else {
            $_SESSION['Errors']['insert-new-pattern'] = 'Произошла ошибка корпус с таким именем уже существует!';
        }
        if ($menu == 3) {
            Router::redirect('admin/editpattern/?menu=' . $menu . '&search=' . $postArrayTemp['search'] . '&anchor=' . $postArrayTemp['anchor'] . '&id=' . $postArrayTemp['id']);
        } else {
            Router::redirect('admin/editpattern/?menu=' . $menu . '&anchor=' . $postArrayTemp['anchor'] . '&id=' . $postArrayTemp['id']);
        }
    }

    public function action_addnewfile() {
        $postArrayTemp = filter_input_array(INPUT_POST);
        if ($postArrayTemp['file_name'] != NULL && $postArrayTemp['name'] != NULL) {
            if ($this->viewer->files = $this->model->insertNewFile($postArrayTemp)) {
                $_SESSION['message']['insert-new-file'] = 'Файл успешно добавлен!';
                Router::redirect('admin/files/');
            } else {
                $_SESSION['Errors']['insert-new-file'] = 'Произошла ошибка. Возможно такой файл уже существует';
                Router::redirect('admin/files/');
            }
        }
    }

    public function action_alltasks() {
//Пункт меню используется в условии меню вьюшки Admin 
        $this->viewer->menu = 2;
        $_SESSION['search'] = NULL;
        $this->viewer->user = filter_input_array(INPUT_POST);
        if ($this->viewer->user['type_user'] == 'user') {
            $_SESSION['type_user']['user-id'] = $this->viewer->user['id'];
            $_SESSION['type_user']['user-snp'] = $this->viewer->user['snp'];
        }
        if ($this->viewer->user['type_user'] == 'checker') {
            $_SESSION['type_user']['checker-id'] = $this->viewer->user['id'];
            $_SESSION['type_user']['checker-snp'] = $this->viewer->user['snp'];
        }
        if ($this->viewer->user['file'] == '1') {
            $_SESSION['file']['id'] = $this->viewer->user['file_id'];
            $_SESSION['file']['name'] = $this->viewer->user['file_name'];
        }
        if (isset($_SESSION['type_user']['user-id'])) {
            $this->viewer->user1 = $_SESSION['type_user']['user-snp'];
        }
        if (isset($_SESSION['type_user']['checker-id'])) {
            $this->viewer->user2 = $_SESSION['type_user']['checker-snp'];
        }
        if (isset($_SESSION['file'])) {
            $this->viewer->file = $_SESSION['file']['name'];
        }
        $this->viewer->tasks = $this->model->showTaskInWork();
        foreach ($this->viewer->tasks as $key => $task_item) {
            if ($task_item['completed_date'] != NULL) {
                $date_arr = $array_url = explode('-', $task_item['completed_date']);
                $this->viewer->tasks["$key"]['completed_date'] = $date_arr[2] . '-' . $date_arr[1] . '-' . $date_arr['0'];
            }
        }
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_alltasks_view.php";
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_cleartask() {
        $_SESSION['type_user'] = null;
        $_SESSION['file'] = null;
        Router::redirect('admin/alltasks');
    }

    public function action_savetask() {
        if (isset($_SESSION['type_user']['user-id']) && isset($_SESSION['type_user']['checker-id']) && isset($_SESSION['file'])) {
            if ($_SESSION['type_user']['user-id'] !== NULL && $_SESSION['type_user']['checker-id'] !== NULL && $_SESSION['file']['id'] !== NULL) {
                if ($this->model->updateFile($_SESSION['type_user']['user-id'], $_SESSION['type_user']['checker-id'], $_SESSION['file']['id'])) {
                    if ($this->model->resetPatternStatus($_SESSION['file']['id'])) {
                        $_SESSION['message']['add-task'] = 'Все ок!!! Задание выдано!';
                        $_SESSION['type_user'] = null;
                        $_SESSION['file'] = null;
                    } else {
                        $_SESSION['Errors']['add-task']['reset-patterns-status'] = 'Произошла ошибка! Обратитесь к разработчику!!';
                    }
                } else {
                    $_SESSION['Errors']['add-task'] = 'Произошла ошибка! Обратитесь к разработчику!!';
                }
            }
        } else {
            $_SESSION['Errors']['add-task'] = 'Недостаточно данных!';
        }
        Router::redirect('admin/alltasks');
    }

    public function action_edittask() {
        $this->viewer->task = filter_input_array(INPUT_POST);
        /**
          ["file_id"]=> string(3) "727"
          ["file_name"]=> string(17) "_qfnpqfn-dual_row"
          ["user_id"]=> string(1) "1"
          ["user_snp"]=> string(25) "Рябушенко К.Г."
          ["user_check_id"]=> string(1) "1"
          ["user_check_snp"]=> string(25) "Рябушенко К.Г."
         * */
        $_SESSION['file']['id'] = $this->viewer->task["file_id"];
        $_SESSION['file']['name'] = $this->viewer->task["file_name"];
        $_SESSION['type_user']['user-id'] = $this->viewer->task["user_id"];
        $_SESSION['type_user']['user-snp'] = $this->viewer->task["user_snp"];
        $_SESSION['type_user']['checker-id'] = $this->viewer->task["user_check_id"];
        $_SESSION['type_user']['checker-snp'] = $this->viewer->task["user_check_snp"];
        Router::redirect('admin/alltasks');
    }

    public function action_canceltask() {
        $taskId = filter_input_array(INPUT_POST)['file_id'];
        /**
          ["file_id"]=> string(3) "727"
         * */
        if ($this->model->cencelTask($taskId)) {
            $_SESSION['message']['cancelTask'] = 'Задание отменено!';
        } else {
            $_SESSION['Errors']['cancelTask'] = 'Произошла ошибка. Обратитесь к разработчику!';
        }

        Router::redirect('admin/alltasks');
    }

    public function action_selectuser() {
//Пункт меню используется в условии меню вьюшки Admin 
        $this->viewer->menu = filter_input_array(INPUT_POST)['menu'];
        $this->viewer->type_user = filter_input_array(INPUT_POST)['type_user'];
        $this->viewer->users = $this->model->showAllUsers();
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_users_view.php";
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_jobdelivery() {
        $postArrayTemp = filter_input_array(INPUT_POST);
        if (isset($postArrayTemp['file_id']) && $postArrayTemp['file_id'] != NULL) {
            if ($this->model->updateFileJobDelivery(1, $postArrayTemp['file_id'])) {
                $_SESSION['message']['insert-new-file'] = 'Файл сдали!';
                if ($postArrayTemp['completed'] == 0) {
                    $this->model->fileCompleted(1, date('Y-m-d'), $postArrayTemp['file_id']);
                }
            } else {
                $_SESSION['Errors']['insert-new-file'] = 'Произошла ошибка. Обратитесь к разработчику!';
            }
        }
        Router::redirect('admin/alltasks/#' . $postArrayTemp['anchor']);
    }

    public function action_db() {
//Пункт меню используется в условии меню вьюшки Admin 
        $this->viewer->menu = 4;
        $this->viewer->emailAdm = $this->model->getEmailAdm()[0];
        $this->viewer->adminList = $this->model->getAdmins();
        $this->viewer->userList = $this->model->getUsers();
        foreach ($this->viewer->userList as $key => $user) {
            if ($this->viewer->userList[$key]['birthday'] != NULL) {
                $this->viewer->userList[$key]['birthday'] = ControlPanel::editBirthday($user['birthday']);
            }
            $this->viewer->userList[$key]['registered'] = ControlPanel::editBirthday($user['registered']);
        }

        //	var_dump($this->viewer->emailAdm);
        //	exit();
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_db_view.php";
        $this->viewer->show();

        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_updateemail() {
        $email = filter_input_array(INPUT_POST)['new-adm-email'];
        if (isset($email) && strlen($email) != 0 && $email != NULL) {
            if ($this->model->updateEmailAdm($email)) {
                $_SESSION['message']['update-email'] = 'Email обновлен.';
            } else {
                $_SESSION['Errors']['update-email'] = 'При обновлении поля Email произошла ошибка.';
            }
        } else {
            $_SESSION['Errors']['update-email'] = 'Поле Email не может быть пустым.';
        }
        Router::redirect('admin/db');
    }

    public function action_edit() {
        $id = filter_input_array(INPUT_GET)["id"];
        $this->viewer->menu = filter_input_array(INPUT_GET)["menu"];
        $this->viewer->file_id = filter_input_array(INPUT_GET)["file_id"];
        $this->viewer->anchor = filter_input_array(INPUT_GET)["anchor"];
        if (isset($id) && strlen($id) != 0 && $id != NULL) {
            $this->viewer->pattern = $this->model->openLibs($id)[0];
            $this->viewer->pattern['pattern_comments'] .= "(Адм) " . $_SESSION['snp'] . " -   </br>";
            $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_edit_view.php";
            $this->viewer->show();
        } else {
            Router::notFoundAction();
        }
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_updatecommentforadm() {
        $this->viewer->pattern = filter_input_array(INPUT_POST);
        if ($this->model->updatePattern('comment_for_adm', $this->viewer->pattern['val'], $this->viewer->pattern['pattern_id'])) {
            $_SESSION['message']['save-comment'] = 'Комментарий обработан!';
            if ($this->viewer->pattern['anchor_i'] != 1) {
                $this->viewer->pattern['anchor_i'] = $this->viewer->pattern['anchor_i'] - 1;
            }
        } else {
            $_SESSION['Errors']['save-comment'] = 'Произошла ошибка, обратитесь к разработчику';
        }
        Router::redirect('admin/commentforadm/?menu=' . $this->viewer->pattern['menu'] . '&file_id=' . $this->viewer->pattern['file_id'] . '#' . $this->viewer->pattern['anchor_i']);
    }

    public function action_savecomment() {
        $this->viewer->pattern = filter_input_array(INPUT_POST);
        $this->viewer->pattern["pattern_comments"] = str_replace(array("\r\n", "\r", "\n", '"'), ' ', $this->viewer->pattern["pattern_comments"]);
        if ($this->model->updatePattern('comments', $this->viewer->pattern['pattern_comments'], $this->viewer->pattern['pattern_id'])) {
            $_SESSION['message']['save-comment'] = 'Комментарий сохранен';
            Router::redirect('admin/edit/?menu=' . $this->viewer->pattern['menu'] . '&anchor=' . $this->viewer->pattern['anchor'] . '&file_id=' . $this->viewer->pattern['file_id'] . '&id=' . $this->viewer->pattern['pattern_id']);
        } else {
            $_SESSION['Errors']['save-comment'] = 'Произошла ошибка, обратитесь к разработчику';
            Router::redirect('admin/edit/?menu=' . $this->viewer->pattern['menu'] . '&anchor=' . $this->viewer->pattern['anchor'] . '&file_id=' . $this->viewer->pattern['file_id'] . '&id=' . $this->viewer->pattern['pattern_id']);
        }
    }

    public function action_savenewpatternname() {
        $this->viewer->pattern = filter_input_array(INPUT_POST);
        if ($this->model->updatePattern('pattern_name', $this->viewer->pattern['new_pattern_name'], $this->viewer->pattern['pattern_id'])) {
            $_SESSION['message']['save-comment'] = 'Имя корпуса сохранено';
            Router::redirect('admin/edit/?menu=' . $this->viewer->pattern['menu'] . '&anchor=' . $this->viewer->pattern['anchor'] . '&file_id=' . $this->viewer->pattern['file_id'] . '&id=' . $this->viewer->pattern['pattern_id']);
        } else {
            $_SESSION['Errors']['save-comment'] = 'Произошла ошибка, обратитесь к разработчику';
            Router::redirect('admin/edit/?menu=' . $this->viewer->pattern['menu'] . '&anchor=' . $this->viewer->pattern['anchor'] . '&file_id=' . $this->viewer->pattern['file_id'] . '&id=' . $this->viewer->pattern['pattern_id']);
        }
    }

    public function action_allfiles() {
        $this->viewer->menu = filter_input_array(INPUT_POST)['menu'];
        $this->viewer->file_id = filter_input_array(INPUT_POST)['file_id'];
        $this->viewer->pattern = filter_input_array(INPUT_POST);
        $this->viewer->files = $this->model->showAllFiles();
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_allfiles_view.php";
        $this->viewer->show();
    }

    public function action_allfiles2() {
        $this->viewer->pattern = filter_input_array(INPUT_POST);
        $this->viewer->menu = filter_input_array(INPUT_POST)['menu'];
        $this->viewer->files = $this->model->showAllFiles();
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_allfiles2_view.php";
        $this->viewer->show();
    }

    public function action_allfiles3() {
        $this->viewer->menu = filter_input_array(INPUT_POST)['menu'];
        $this->viewer->pattern = filter_input_array(INPUT_POST);
        $this->viewer->files = $this->model->showAllFiles();
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_allfiles3_view.php";
        $this->viewer->show();
    }

    public function action_allfiles4() {
        $this->viewer->menu = filter_input_array(INPUT_GET)['menu'];
        $this->viewer->file_id = filter_input_array(INPUT_GET)['id'];
        $this->viewer->files = $this->model->showAllFiles();
        $this->viewer->content_view = 'admin' . DIRECTORY_SEPARATOR . "admin_allfiles4_view.php";
        $this->viewer->show();
    }

    public function action_savepatterninfile() {
        $this->viewer->menu = filter_input_array(INPUT_POST)['menu'];
        $this->viewer->pattern = filter_input_array(INPUT_POST);
        if ($this->model->updatePattern('file_id', $this->viewer->pattern['id'], $this->viewer->pattern['pattern_id'])) {
            $_SESSION['message']['save-comment'] = 'Корпус успешно перемещен!';
            Router::redirect('admin/edit/?menu=' . $this->viewer->menu . '&anchor=' . $this->viewer->pattern['anchor'] . '&file_id=' . $this->viewer->pattern['file_id'] . '&id=' . $this->viewer->pattern['pattern_id']);
        } else {
            Router::redirect('admin/edit/?menu=' . $this->viewer->menu . '&anchor=' . $this->viewer->pattern['anchor'] . '&file_id=' . $this->viewer->pattern['file_id'] . '&id=' . $this->viewer->pattern['pattern_id']);
            $_SESSION['Errors']['save-comment'] = 'Произошла ошибка, обратитесь к разработчику';
        }
    }

    public function action_savepatterninfile2() {
        $this->viewer->pattern = filter_input_array(INPUT_POST);
        $this->viewer->menu = filter_input_array(INPUT_POST)['menu'];
        if ($this->model->updatePattern('file_id', $this->viewer->pattern['id'], $this->viewer->pattern['pattern_id'])) {
            $this->viewer->pattern['anchor'] = $this->viewer->pattern['anchor'] - 1;
            $_SESSION['old_file_id'] = $this->viewer->pattern['old_file_id'];
            $_SESSION['message']['insert-new-file'] = 'Корпус был успешно перемещен!';
            if ($this->viewer->menu == 3) {
                Router::redirect('admin/editpattern/?menu=' . $this->viewer->menu . '&anchor=' . $this->viewer->pattern['anchor'] . '&id=' . $this->viewer->pattern['pattern_id'] . '&search=' . $this->viewer->pattern['search']);
            } else {
                Router::redirect('admin/editpattern/?menu=' . $this->viewer->menu . '&anchor=' . $this->viewer->pattern['anchor'] . '&id=' . $this->viewer->pattern['pattern_id']);
            }
        } else {
            $_SESSION['Errors']['insert-new-file'] = 'Произошла ошибка. обратитесь к разработчику';
            Router::redirect('admin/editpattern/?menu=' . $this->viewer->menu . '&anchor=' . $this->viewer->pattern['anchor'] . '&id=' . $this->viewer->pattern['pattern_id']);
        }
    }

    public function action_resetpassword() {
        $user_id = filter_input_array(INPUT_POST)['id'];
        $user_snp = filter_input_array(INPUT_POST)['snp'];
        $user_reset_pass = password_hash('499949', PASSWORD_DEFAULT);
        if ($this->model->resetpassword($user_id, $user_reset_pass)) {
            $_SESSION['message']['reset-password'] = "Пароль пользователя " . $user_snp . " был успешно сброшен!";
        } else {
            $_SESSION['Errors']['reset-password'] = 'Произошла ошибка. обратитесь к разработчику';
        }

        Router::redirect('admin/db');
    }

    public function action_blockuser() {
        $user_id = filter_input_array(INPUT_POST)['id'];
        $user_snp = filter_input_array(INPUT_POST)['snp'];
        $user_verified = filter_input_array(INPUT_POST)['verified'];
        if ($user_verified == 1) {
            if ($this->model->blockuser($user_id, 2)) {
                $_SESSION['message']['block-user'] = "Пользователь " . $user_snp . " Разблокирован!";
            } else {
                $_SESSION['Errors']['block-user'] = 'Произошла ошибка. обратитесь к разработчику';
            }
        } else {
            if ($this->model->blockuser($user_id, 1)) {
                $_SESSION['message']['block-user'] = "Пользователь " . $user_snp . " Заблокирован!";
            } else {
                $_SESSION['Errors']['block-user'] = 'Произошла ошибка. обратитесь к разработчику';
            }
        }


        Router::redirect('admin/db');
    }

    public function action_changeaccesslevel() {
        $user_id = filter_input_array(INPUT_POST)['id'];
        $user_access_level = filter_input_array(INPUT_POST)['access_level'];
        $user_snp = filter_input_array(INPUT_POST)['snp'];
        if ($user_access_level == 200) {
            if ($this->model->changeaccesslevel($user_id, 100)) {
                $_SESSION['message']['change-access-level'] = "Пользователь " . $user_snp . " получил права Администратора!";
            } else {
                $_SESSION['Errors']['change-access-level'] = 'Произошла ошибка. обратитесь к разработчику';
            }
        } else {
            if ($this->model->changeaccesslevel($user_id, 200)) {
                $_SESSION['message']['change-access-level'] = "Пользователь " . $user_snp . " получил права User!";
            } else {
                $_SESSION['Errors']['change-access-level'] = 'Произошла ошибка. обратитесь к разработчику';
            }
        }
        Router::redirect('admin/db');
    }

    public function action_savecsvfrombd() {
        $arrayTempFromBD = $this->model->saveFromBD();
//        ["file_name"]=> string(3) "ant" 
//        ["name"]=> string(8) "Antennas" 
//        ["pattern_name"]=> string(15) "ANTENOVA_A10340" 
//        ["comments"]=> string(4) "NULL"    
        self::export_csv($arrayTempFromBD);
    }

    public function action_fileinbd() {
//        var_dump($_FILES);
//        ["userfile"]=> array(5) { 
//           ["name"]=> string(157) "torrent" 
//           ["type"]=> string(24) "application/x-bittorrent" 
//           ["tmp_name"]=> string(14) "/tmp/php6zdfiH" 
//           ["error"]=> int(0) 
//           ["size"]=> int(21589) } }
//               var_dump($_FILES);
        $tempfile = self::kama_parse_csv_file($_FILES["CSV"]["tmp_name"]);
//        foreach ($tempfile as $value) {
//            echo $value[0].' - '.$value[1].' - '.$value[2].' - '.$value[3].'</br>';
//        }
//        exit();



        $arrayOnlyFiles = array();
        $presentInTheDatabase = array();

        foreach ($tempfile as $value) {
            array_push($arrayOnlyFiles, ['file_name' => $value[0], 'name' => $value[1]]);
        }



        //Удаляем дубликаты из двумерного массива
        $arrayWithoutDuplicates = array_map("unserialize", array_unique(array_map("serialize", $arrayOnlyFiles)));
        $files_from_bd1 = $this->model->showAllFilesOnlyName();
        foreach ($files_from_bd1 as $files_from_bd1_item) {
            foreach ($arrayWithoutDuplicates as $arrayWithoutDuplicates_item) {
                if ($files_from_bd1_item['file_name'] == $arrayWithoutDuplicates_item['file_name']) {
                    array_push($presentInTheDatabase, ['file_name' => $files_from_bd1_item['file_name'], 'name' => $arrayWithoutDuplicates_item['name']]);
                }
            }
        }

        $arr1_em = array_column($arrayWithoutDuplicates, 'file_name');

        $arr2_em = array_column($presentInTheDatabase, 'file_name');

        $arr3_em = array_diff($arr1_em, $arr2_em);
        $j1 = 0;
        foreach ($arr3_em as $value) {
            foreach ($arrayWithoutDuplicates as $arrayWithoutDuplicates_item) {
                if ($arrayWithoutDuplicates_item['file_name'] == $value) {
                    $j1++;
                    if ($this->model->insertNewFile($arrayWithoutDuplicates_item)) {
                        $_SESSION['message']['save-in-bd' . $j1] = $arrayWithoutDuplicates_item['file_name'] . ' - Успех!';
                    } else {
                        $_SESSION['Errors']['save-in-bd' . $j1] = 'Произошла ошибка файлом ' . $arrayWithoutDuplicates_item['file_name'];
                    }
                }
            }
        }
        //Добавли в базу данных files которые отсутствовали в бд
        //Создаем массив в котором все корпуса с файла вместе с id
        $arrayFilesFromBDWithID = $this->model->showAllFiles();
        $tempFileWithID = array();
        foreach ($tempfile as $value) {
            foreach ($arrayFilesFromBDWithID as $arrayFilesFromBDWithID_item) {
                if ($value[0] == $arrayFilesFromBDWithID_item['file_name']) {
                    if (isset($value[3])) {
                        array_push($tempFileWithID, ['file_id' => $arrayFilesFromBDWithID_item['id'], 'pattern_name' => $value[2], 'comments' => $value[3]]);
                    } else {
                        array_push($tempFileWithID, ['file_id' => $arrayFilesFromBDWithID_item['id'], 'pattern_name' => $value[2]]);
                    }
                }
            }
        }
//                var_dump($tempFileWithID);
//                exit();

        $arrayOnlyPatterns = array();
        $patterns_from_bd1 = $this->model->showAllPatternsOnlyName();
        foreach ($tempfile as $value) {
            array_push($arrayOnlyPatterns, $value[2]);
        }

        $presentInTheDatabase2 = array();

        foreach ($patterns_from_bd1 as $patterns_from_bd1_item) {
            foreach ($arrayOnlyPatterns as $arrayOnlyPatterns_item) {
                if ($patterns_from_bd1_item['pattern_name'] == $arrayOnlyPatterns_item) {
                    array_push($presentInTheDatabase2, $arrayOnlyPatterns_item);
                }
            }
        }
//        var_dump($presentInTheDatabase2);
//        exit();
        if ($presentInTheDatabase2 !== NULL) {
            $arr33_em = array_diff($arrayOnlyPatterns, $presentInTheDatabase2);
//        var_dump($arr33_em);
//        exit();
        } else {
            $arr33_em = $arrayOnlyPatterns;
        }
//        var_dump('exit after if');
//        exit();
        $resultArray = array();

        foreach ($arr33_em as $value_not_in_bd) {
            foreach ($tempFileWithID as $value) {
                if ($value_not_in_bd == $value['pattern_name']) {
                    array_push($resultArray, ['file_id' => $value['file_id'], 'pattern_name' => $value['pattern_name'], 'pattern_comments' => $value['comments']]);
//                    array_push($resultArray, ['file_id' => $files_from_bd1_item['id'], 'pattern_name' => $value[2], 'pattern_comments' => 'NULL']);
                }
            }
        }



        if ($resultArray != NULL) {
            if ($this->model->insertNewPattern3($resultArray)) {
                $_SESSION['message']['save-in-bd' . $j] = 'Корпус успешно перемещен!';
            } else {
                $_SESSION['Errors']['save-in-bd' . $j] = 'Произошла ошибка с корпусом ' . $value['pattern_name'] . ' Строка-' . $j;
            }
        } else {
            $_SESSION['message']['save-in-bd' . $j] = 'Эти корпуса и файлы в базе данных уже есть!';
        }










//        $j = 0;
//        $arrayOneQuery=array();
//        foreach ($resultArray as $value) {
//            foreach ($arr33_em as $arrayOnlyPatterns_item) {
//                if ($arrayOnlyPatterns_item == $value['pattern_name']) {
//                    $j++;
//                    
//                    if ($this->model->insertNewPattern($value)) {
//                        $_SESSION['message']['save-in-bd' . $j] = 'Корпус успешно перемещен!';
//                    } else {
//                        $_SESSION['Errors']['save-in-bd' . $j] = 'Произошла ошибка с корпусом ' . $value['pattern_name'].' Строка-'.$j;
//                    }
//                }
//            }
//        }



        if ($_SESSION['Errors'] == NULL) {
            $_SESSION['message'] = NULL;
            $_SESSION['message']['save-in-bd'] = 'Корпуса отсутствующие в базе данных были успешно добавлнены';
        }
        Router::redirect('admin/db');
    }

## Читает CSV файл и возвращает данные в виде массива.
## @param string $file_path Путь до csv файла.
## string $col_delimiter Разделитель колонки (по умолчанию автоопределине)
## string $row_delimiter Разделитель строки (по умолчанию автоопределине)
## ver 6
//    https://wp-kama.ru/id_9114/csv-fajly-na-php-sozdanie-i-chtenie.html

    function kama_parse_csv_file($file_path, $file_encodings = ['cp1251', 'UTF-8'], $col_delimiter = ';', $row_delimiter = '') {

        if (!file_exists($file_path))
            return false;

        $cont = trim(file_get_contents($file_path));

        $encoded_cont = mb_convert_encoding($cont, 'UTF-8', mb_detect_encoding($cont, $file_encodings));

        unset($cont);
        // определим разделитель
        if (!$row_delimiter) {
            $row_delimiter = "\r\n";
            if (false === strpos($encoded_cont, "\r\n"))
                $row_delimiter = "\n";
        }

        $lines = explode($row_delimiter, trim($encoded_cont));
        $lines = array_filter($lines);
        $lines = array_map('trim', $lines);

        // авто-определим разделитель из двух возможных: ';' или ','. 
        // для расчета берем не больше 30 строк
        if (!$col_delimiter) {
            $lines10 = array_slice($lines, 0, 30);

            // если в строке нет одного из разделителей, то значит другой точно он...
            foreach ($lines10 as $line) {
                if (!strpos($line, ','))
                    $col_delimiter = ';';
                if (!strpos($line, ';'))
                    $col_delimiter = ',';

                if ($col_delimiter)
                    break;
            }

            // если первый способ не дал результатов, то погружаемся в задачу и считаем кол разделителей в каждой строке.
            // где больше одинаковых количеств найденного разделителя, тот и разделитель...
            if (!$col_delimiter) {
                $delim_counts = array(';' => array(), ',' => array());
                foreach ($lines10 as $line) {
                    $delim_counts[','][] = substr_count($line, ',');
                    $delim_counts[';'][] = substr_count($line, ';');
                }

                $delim_counts = array_map('array_filter', $delim_counts); // уберем нули
                // кол-во одинаковых значений массива - это потенциальный разделитель
                $delim_counts = array_map('array_count_values', $delim_counts);

                $delim_counts = array_map('max', $delim_counts); // берем только макс. значения вхождений

                if ($delim_counts[';'] === $delim_counts[','])
                    return array('Не удалось определить разделитель колонок.');

                $col_delimiter = array_search(max($delim_counts), $delim_counts);
            }
        }

        $data = [];
        foreach ($lines as $key => $line) {
            $data[] = str_getcsv($line, $col_delimiter); // linedata
            unset($lines[$key]);
        }

        return $data;
    }

    function export_csv($data) {
// No point in creating the export file on the file-system. We'll stream
// it straight to the browser. Much nicer.
// Open the output stream
        $fh = fopen('php://output', 'w');
// Start output buffering (to capture stream contents)
        ob_start();
// CSV Data
//        ["file_name"]=> string(3) "ant" 
//        ["name"]=> string(8) "Antennas" 
//        ["pattern_name"]=> string(15) "ANTENOVA_A10340" 
//        ["comments"]=> string(4) "NULL"   
        foreach ($data as $value) {
            $line = array($value['file_name'], $value['name'], $value['pattern_name'], str_replace(array("\r\n", "\r", "\n", '"'), '', $value['comments']));
            fputcsv($fh, $line, ';');
        }
// Get the contents of the output buffer
        $string = ob_get_clean();
// Set the filename of the download
        $filename = 'backup_file_' . date('dmY') . '-' . date('His');
// Output CSV-specific headers
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv";');
        header('Content-Transfer-Encoding: binary');
// Stream the CSV data
        exit($string);
    }

}
