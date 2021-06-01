<?php

namespace core\controllers;

use core\controllers\AbstractController;
use core\models\ControlPanelModel;
use core\Router;

class ControlPanel extends AbstractController {

    public function __construct() {
        if (!Auth::checkValidation()) {
            Router::redirect('auth/');
        }
        parent::__construct();
        $this->model = new ControlPanelModel();
    }

// Перечень файлов в которых задействован пользователь.
    public function action_index() {
//Пункт меню используется в условии меню вьюшки CP 
        $this->viewer->menu = 0;
        $this->viewer->files = $this->model->selectAllFiles("id_user", $_SESSION['id']);
        $this->viewer->content_view = 'CP' . DIRECTORY_SEPARATOR . 'cp_index_view.php';
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_check() {
//Пункт меню используется в условии меню вьюшки CP 
        $this->viewer->menu = 1;
        $this->viewer->files = $this->model->selectAllFiles("id_user_check", $_SESSION['id']);
        $this->viewer->content_view = 'CP' . DIRECTORY_SEPARATOR . 'cp_index_view.php';
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

//Поиск корпусов по названии.
    public function action_search() {
//Пункт меню используется в условии меню вьюшки CP 
        $this->viewer->menu = 2;
        $this->viewer->patternSearch = filter_input_array(INPUT_POST)['search'];
        if (!isset($this->viewer->patternSearch)) {
            $this->viewer->patternSearch = filter_input_array(INPUT_GET)['search'];
        }
        if (isset($this->viewer->patternSearch)) {
            $this->viewer->patterns = $this->model->selectPatternsForSearch($this->viewer->patternSearch);
        }
        $this->viewer->content_view = 'CP' . DIRECTORY_SEPARATOR . 'cp_search_view.php';
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

//Пометки пользователя
    public function action_notes() {
//Пункт меню используется в условии меню вьюшки CP 
        $this->viewer->menu = 3;
        $this->viewer->notes = $this->model->getNotes($_SESSION['id']);
        if ($this->viewer->notes == null) {
            $this->model->createNotes($_SESSION['id']);
            $this->viewer->notes = $this->model->getNotes($_SESSION['id']);
//array(1) { [0]=> array(3) { ["id"]=> string(1) "1" ["notes"]=> NULL ["date"]=> NULL } }
        }
        $this->viewer->content_view = 'CP' . DIRECTORY_SEPARATOR . 'cp_notes_view.php';
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

//Профиль пользователя
    public function action_profile() {
//Пункт меню используется в условии меню вьюшки CP 
        $this->viewer->menu = 4;
        $this->viewer->gender = $this->model->selectGender();
//        [0]=> array(2) { ["id"]=> string(1) "1" ["name"]=> string(14) "Мужской" } 
//        [1]=> array(2) { ["id"]=> string(1) "2" ["name"]=> string(14) "Женский" } 
        $this->viewer->user = $this->model->selectUserById($_SESSION['id'])[0];
//        ["surname"] => string(18) "Рябушенко"
//        ["name"] => string(20) "Константин"
//        ["patronymic"] => string(22) "Григорьевич"
//        ["birthday"] => string(10) "1988-04-28"
//        ["phone"] => string(17) "+38(068)448-67-40"
//        ["gender_id"] => string(1) "1"
        $this->viewer->user['birthday'] = self::editBirthday($this->viewer->user['birthday']);
        $this->viewer->content_view = 'CP' . DIRECTORY_SEPARATOR . 'cp_user_profile_view.php';
        $this->viewer->show();
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    public function action_saveprofile() {
        $tempPostArray = filter_input_array(INPUT_POST);
//["surname"]=> string(18) "Рябушенко" 
//["name"]=> string(20) "Константин" 
//["patronymic"]=> string(22) "Григорьевич" 
//["birthday"]=> string(10) "28-04-1988" 
//["phone"]=> string(17) "+38(068)448-67-40" 
//["gender_id"]=> string(1) "1" 
        $email_to_activate = $this->model->selectEmail()[0]['email'];
        $tempPostArray['snp'] = ucfirst(strtolower($tempPostArray['surname'])) . " " . ucfirst(mb_substr($tempPostArray['name'], 0, 1)) . "." . ucfirst(mb_substr($tempPostArray['patronymic'], 0, 1)) . ".";
        $tempPostArray['id'] = $_SESSION['id'];



        if (empty($tempPostArray['phone'])) {
            $tempPostArray['phone'] = "NULL";
            $phone = "";
        }
        if (empty($tempPostArray['birthday'])) {
            $tempPostArray['birthday'] = "NULL";
            $birthdayNotEdit = "";
        } else {
            $birthdayNotEdit = $tempPostArray['birthday'];
            $tempPostArray['birthday'] = self::editBirthday($tempPostArray['birthday']);
        }

        $message = <<<CONTENT
Пользователь {$_SESSION['login']}, новое ФИО - {$tempPostArray['snp']} Отредактировал профиль.
Фамилия - {$tempPostArray['surname']}
Имя - {$tempPostArray['name']}
Отчество - {$tempPostArray['patronymic']}
Телефон - {$phone}
Дата рождения - {$birthdayNotEdit}
CONTENT;
        $headers = 'From: admin@qqq.zzz.com.ua' . "\r\n";
        if ($this->model->updateProfileUser($tempPostArray)) {
            mail($email_to_activate, "Изменения в профиле пользователя {$_SESSION['login']}", $message, $headers);
            $_SESSION['surname'] = $tempPostArray['surname'];
            $_SESSION['name'] = $tempPostArray['name'];
            $_SESSION['patronymic'] = $tempPostArray['patronymic'];
            $_SESSION['snp'] = $tempPostArray['snp'];
            $_SESSION['message']['update-profile'] = 'Информация успешно сохранена.';
        } else {
            $_SESSION['Errors']['update-profile'] = 'Произошла ошибка! Обратитесь к разработчику';
        }
        Router::redirect('CP/profile');
    }

    public function action_savenewpassword() {
        $tempPostArray = filter_input_array(INPUT_POST);
//        ["password"]=> string(6) "494949" 
//        ["password_confirm"]=> string(6) "494949"

        if ($tempPostArray['password'] !== $tempPostArray['password_confirm']) {
            $_SESSION['Errors']['save-new-pass'] = 'Пароли не совпадают';
        } else {
            $password = password_hash($tempPostArray['password'], PASSWORD_DEFAULT);
            if ($this->model->updatePassword($_SESSION['id'], $password)) {
                $_SESSION['message']['save-new-pass'] = "Пароль успешно сохранен!";
            } else {
                $_SESSION['Errors']['save-new-pass'] = 'Ошибка! Обратитесь к разработчику!';
            }
        }
        Router::redirect('CP/profile');
    }

    public function editBirthday($date) {
        $temparray = explode("-", $date);
        return $temparray[2] . '-' . $temparray[1] . '-' . $temparray[0];
    }

    public function action_savenotes() {
        $notes = filter_input_array(INPUT_POST)['notes'];
        $date = date('Y-m-d H:i:s');
        if ($this->model->updateNotes($_SESSION['id'], $notes, $date)) {
            $_SESSION['message']['notes'] = 'Заметки успешно сохранены!';
        } else {
            $_SESSION['Errors']['notes'] = 'Ошибка при сохранении заметок! Обратитесь к разработчику!';
        }
        Router::redirect('CP/notes');
    }

    public function action_actionForm() {
        $menu = filter_input_array(INPUT_POST)['menu'];
        $file_id = filter_input_array(INPUT_POST)['file_id'];
        $postArrayTemp = filter_input_array(INPUT_POST);
        unset($postArrayTemp['menu']);
        unset($postArrayTemp['file_id']);
        if (count($postArrayTemp) > 1) {
            if (isset($postArrayTemp['completed'])) {
                unset($postArrayTemp['completed']);
                if ($this->model->completedPatterns($postArrayTemp, 1, 'user')) {
                    $_SESSION['message']['completed-Patterns'] = 'Выбранные корпуса были завершены!';
                } else {
                    $_SESSION['Errors']['completed-Patterns'] = 'Ошибка! Обратитесь к разработчику!';
                }
            }
            if (isset($postArrayTemp['notCompleted'])) {
                unset($postArrayTemp['notCompleted']);
                if ($this->model->completedPatterns($postArrayTemp, 0, 'user')) {
                    $_SESSION['message']['not-completed-patterns'] = 'Выбранные корпуса не завершены!!';
                } else {
                    $_SESSION['Errors']['not-completed-patterns'] = 'Ошибка! Обратитесь к разработчику!';
                }
            }
            if (isset($postArrayTemp['checked'])) {
                unset($postArrayTemp['checked']);
                if ($this->model->completedPatterns($postArrayTemp, 1, 'checker')) {
                    $_SESSION['message']['checked-patterns'] = 'Выбранные корпуса были проверены!';
                } else {
                    $_SESSION['Errors']['checked-patterns'] = 'Ошибка! Обратитесь к разработчику!';
                }
            }
            if (isset($postArrayTemp['notChecked'])) {
                unset($postArrayTemp['notChecked']);
                if ($this->model->completedPatterns($postArrayTemp, 0, 'checker')) {
                    $_SESSION['message']['not-checked-patterns'] = 'Выбранные корпуса не проверены!';
                } else {
                    $_SESSION['Errors']['not-checked-patterns'] = 'Ошибка! Обратитесь к разработчику!';
                }
            }
            //Начало проверки готовности библиотеки.
            $countPatterns = $this->model->countPatterns($file_id);
            $countCompletedAndChecked = $this->model->countCompletedAndChecked($file_id);
            if ($countPatterns == $countCompletedAndChecked) {
                $date = date('Y-m-d');
                if ($this->model->fileCompleted(1, $date, $file_id)) {
                    $_SESSION['message']['file-comleted-in-actionForm'] = 'Библиотека готова к сдачи!';
                    Router::redirect('CP/check');
                } else {
                    $_SESSION['Errors']['file-comleted-in-actionForm'] = 'Произошла ошибка обратитесь к разработчику!';
                    Router::redirect('CP/library/?menu=' . $menu . '&id=' . $file_id);
                }
            } else {
                if (!$this->model->fileCompleted('NULL', 'NULL', $file_id)) {
                    $_SESSION['Errors']['cancel-file-comleted-in-actionForm'] = 'Произошла ошибка обратитесь к разработчику!';
                    Router::redirect('CP/library/?menu=' . $menu . '&id=' . $file_id);
                }
            }


            if (isset($postArrayTemp['addCommentToAll'])) {
                unset($postArrayTemp['addCommentToAll']);
                $_SESSION['temp-array'] = NULL;
                $_SESSION['temp-array'] = $postArrayTemp;
                Router::redirect('CP/addCommentToAll/?menu=' . $menu . '&file_id=' . $file_id);
            }
        } else {
            if (isset($postArrayTemp['saveCsvFile'])) {
                $arrayTempFromBD = $this->model->saveFromBDwithId($file_id);
//        ["file_name"]=> string(3) "ant" 
//        ["name"]=> string(8) "Antennas" 
//        ["pattern_name"]=> string(15) "ANTENOVA_A10340" 
//        ["comments"]=> string(4) "NULL"    
                self::export_csv($arrayTempFromBD);
            } else {
                $_SESSION['Errors']['actionForm'] = 'Ошибка! Выберите корпус!';
            }
        }

        Router::redirect('CP/library/?menu=' . $menu . '&id=' . $file_id);
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
        $filename = $data[0]['name'] . '-' . date('dmY') . '-' . date('His');
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

    public function action_addCommentToAll() {
        $this->viewer->patterns = $this->model->selectPatterns($_SESSION['temp-array']);
        $this->viewer->menu = filter_input_array(INPUT_GET)["menu"];
        $this->viewer->file_id = filter_input_array(INPUT_GET)["file_id"];
        $this->viewer->content_view = 'CP' . DIRECTORY_SEPARATOR . 'cp_addcomenttoallt_view.php';
        $this->viewer->show();
    }

//следующий этап после выбора файла. отображает содержимое файла. все корпуса и коментарии.
    public function action_library() {
        $id = filter_input_array(INPUT_GET)["id"];
        $this->viewer->file_id = $id;
        $menu = filter_input_array(INPUT_GET)["menu"];
        if (isset($id) && isset($menu) && strlen($id) != 0 && $id != NULL) {
            if ($menu >= 0 && $menu <= 2) {
                $this->viewer->menu = $menu;
            }
            $this->viewer->library = $this->model->openLibs($id);
            $this->viewer->content_view = 'CP' . DIRECTORY_SEPARATOR . 'cp_library_view.php';
            $this->viewer->show();
            $_SESSION['Errors'] = null;
            $_SESSION['message'] = null;
        } else {
            Router::notFoundAction();
        }
    }

//add_coment добавляем коментарий
    public function action_addcoment() {
        $this->viewer->pattern = filter_input_array(INPUT_POST);
        $this->viewer->menu = $this->viewer->pattern['menu'];
//["pattern_id"]=> string(1) "5" 
//["file_id"]=> string(3) "265" 
//["pattern_name"]=> string(15) "ANALOG_CB-12-10" 
//["completed"]=> string(1) "1" 
//["checked"]=> string(1) "0" 
//["coments"]=> string(0) "" 
        $this->viewer->content_view = 'CP' . DIRECTORY_SEPARATOR . 'cp_addcoment_view.php';
        $this->viewer->show();
    }

//add_coment добавляем коментарий
    public function action_savecoment() {
        $pattern = filter_input_array(INPUT_POST);
        $comments = $this->model->getCommentsForBd($pattern['pattern_id'])[0]['comments'];
        $fullName = $_SESSION['snp'];
        if ($pattern['menu'] == 0) {
            $fullName = '(Исполнитель) ' . $fullName;
        } elseif ($pattern['menu'] == 1) {
            $fullName = '(Проверяющий) ' . $fullName;
        }

        $comments .= $fullName . " - " . str_replace(array("\r\n", "\r", "\n", '"'), ' ', strip_tags($pattern['coments'])) . "</br>";
        if ($pattern['many'] == 'false') {
            // TO DO тут можно сократить количество запросов в один
            if ($this->model->updatePatternComments($comments, $pattern['pattern_id'])) {
                if ($pattern['menu'] == 0) {
                    $this->model->updatePattern("checked", 0, $pattern['pattern_id']);
                }
                if ($pattern['menu'] == 1) {
                    $this->model->updatePattern("completed", 0, $pattern['pattern_id']);
                }
                if (array_key_exists("comment_for_adm", $pattern)) {
                    if ($pattern['comment_for_adm'] == 1) {
                        $this->model->updatePattern("comment_for_adm", 1, $pattern['pattern_id']);
                    }
                }
            }
        } elseif ($pattern['many'] == true) {
            $all_patterns = $this->model->selectPatterns($_SESSION['temp-array']);
            $_SESSION['temp-array'] = NULL;
            foreach ($all_patterns as $key => $value) {
                $all_patterns[$key]['comments'] = $value['comments'] . ' ' . $comments;
            }
            if (array_key_exists("comment_for_adm", $pattern)) {
                if ($pattern['comment_for_adm'] == 1) {
                    if ($this->model->updateManyPatterns(1, $all_patterns)) {
                        $_SESSION['message']['many-comments-add-and-com-for-adm'] = 'Комментарии успешно добавлены!';
                    } else {
                        $_SESSION['Errors']['many-comments-add-and-com-for-adm'] = 'Ошибка! Обратитесь к разработчику!';
                    }
                }
            } else {
                if ($this->model->updateManyPatterns(0, $all_patterns)) {
                    $_SESSION['message']['many-comments-add'] = 'Комментарии успешно добавлены!';
                } else {
                    $_SESSION['Errors']['many-comments-add'] = 'Ошибка! Обратитесь к разработчику!';
                }
            }
        }



        if ($pattern['menu'] == 2) {
            Router::redirect('CP/search/?search=' . $pattern['search'] . '#' . $pattern['anchor']);
        } else {
            // TO DO Сделать перенаправлние на страничку CP/addCommentToAll конгда много корпусов
//            if ($pattern['many'] == true) {
//                Router::redirect('CP/addCommentToAll/?menu=' . $pattern['menu']  . '&file_id=' . $pattern['file_id']);
//            } else {
//                Router::redirect('CP/library/?menu=' . $pattern['menu'] . '&id=' . $pattern['file_id'] . '#' . $pattern['anchor']);
//            }
            Router::redirect('CP/library/?menu=' . $pattern['menu'] . '&id=' . $pattern['file_id'] . '#' . $pattern['anchor']);
        }
    }

    public function action_completed() {
        $pattern = filter_input_array(INPUT_POST);
        if ($pattern['menu'] == 0) {
            if ($this->model->checkEditRightsPattern($pattern['pattern_id'], $_SESSION['id'])) {
                if ($pattern['completed'] == 0) {
                    $this->model->updatePattern("completed", 1, $pattern['pattern_id']);
                    Router::redirect('CP/library/?menu=' . $pattern['menu'] . '&id=' . $pattern['file_id'] . '#' . $pattern['anchor']);
                } else {
                    $this->model->updatePattern("completed", 0, $pattern['pattern_id']);
                    $this->model->updatePattern("checked", 0, $pattern['pattern_id']);
                    if ($this->model->fileCompleted('NULL', 'NULL', $pattern['file_id'])) {
                        Router::redirect('CP/library/?menu=' . $pattern['menu'] . '&id=' . $pattern['file_id'] . '#' . $pattern['anchor']);
                    } else {
                        $_SESSION['Errors']['file-comleted'] = 'Произошла ошибка обратитесь к разработчику!';
                        Router::redirect('CP/library/?menu=' . $pattern['menu'] . '&id=' . $pattern['file_id'] . '#' . $pattern['anchor']);
                    }
                }
            }
        }
        if ($pattern['menu'] == 1) {
            if ($this->model->checkEditRightsPattern2($pattern['pattern_id'], $_SESSION['id'])) {
                if ($pattern['checked'] == 0) {
                    if ($pattern['completed'] == 1) {
                        $this->model->updatePattern("checked", 1, $pattern['pattern_id']);
                        //Начало проверки готовности библиотеки.
                        $countPatterns = $this->model->countPatterns($pattern['file_id']);
                        $countCompletedAndChecked = $this->model->countCompletedAndChecked($pattern['file_id']);
                        if ($countPatterns == $countCompletedAndChecked) {
                            $date = date('Y-m-d');
                            if ($this->model->fileCompleted(1, $date, $pattern['file_id'])) {
                                $_SESSION['message']['file-comleted'] = 'Библиотека готова к сдачи!';
                                Router::redirect('CP/check');
                            } else {
                                $_SESSION['Errors']['file-comleted'] = 'Произошла ошибка обратитесь к разработчику!';
                                //   Router::redirect('admin/allpatterns/?id=' . $pattern['file_id']);
                            }
                        } else {
                            //  Router::redirect('CP/library/?id=' . $pattern['file_id']);
                        }
                    } else {
                        $_SESSION['Errors']['comleted!=1'] = 'Ошибка! Пользователь еще не завершил работу с файлом!';
                    }
                } else {
                    $this->model->updatePattern("checked", 0, $pattern['pattern_id']);
                    if ($this->model->fileCompleted('NULL', 'NULL', $pattern['file_id'])) {
                        //   Router::redirect('CP/library/?id=' . $pattern['file_id'].'#'. $pattern['anchor']);
                    } else {
                        $_SESSION['Errors']['file-comleted'] = 'Произошла ошибка обратитесь к разработчику!';
                        //    Router::redirect('CP/library/?id=' . $pattern['file_id'].'#'. $pattern['anchor']);
                    }
                }
            } else {
                $_SESSION['Errors']['file-comleted'] = 'Недостаточно прав';
                // Router::redirect('CP/library/?id=' . $pattern['file_id'].'#'. $pattern['anchor']);
            }
        }
        if ($_SESSION['Errors'] == null) {
            Router::redirect('CP/library/?menu=' . $pattern['menu'] . '&id=' . $pattern['file_id'] . '#' . $pattern['anchor']);
        } else {
            Router::redirect('CP/library/?menu=' . $pattern['menu'] . '&id=' . $pattern['file_id']);
        }
    }

}
