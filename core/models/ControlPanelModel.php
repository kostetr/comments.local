<?php

namespace core\models;

class ControlPanelModel extends AbstractModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'users';
    }

    public function selectAllFiles($field, $id_user) {
        $query = "SELECT files.id, files.file_name, files.name FROM `files` LEFT JOIN users ON files.id_user=users.id WHERE `job_delivery` IS null AND `" . $field . "`=" . $id_user;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function selectPatterns($arrayId) {
        $query = "SELECT * FROM `patterns` WHERE `id` in (";

        $i = 1;
        foreach ($arrayId as $value) {
            if ($i == 1) {
                $query .= $value;
                $i++;
            } else {
                $query .= ', ' . $value;
            }
        }
        $query .= ')';
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function selectPatternsForSearch($searchPatternName) {
        $query = "SELECT patterns.id as pattern_id, patterns.file_id, files.file_name, patterns.pattern_name, patterns.completed, patterns.checked, patterns.comments FROM `patterns` LEFT JOIN files ON files.id=patterns.file_id WHERE patterns.pattern_name LIKE '%" . $searchPatternName . "%'";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function countPatterns($file_id) {
        $query = "SELECT COUNT(patterns.id) FROM `patterns` WHERE patterns.file_id=" . $file_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function countCompletedAndChecked($file_id) {
        $query = "SELECT COUNT(patterns.id) FROM `patterns` WHERE patterns.completed<>0 and patterns.checked<>0 AND patterns.file_id=" . $file_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function openLibs($file_id) {
        $query = "SELECT `id` AS `pattern_id`,`file_id`,`pattern_name`,`comments`,`completed`,`checked`,`comment_for_adm` FROM `patterns` WHERE `file_id`=" . $file_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    /*
     * Проверка есть ли id пользователя в поле id_user
     */

    public function checkEditRightsPattern($patterns_id, $users_id) {
        $query = "SELECT patterns.id, users.id, patterns.pattern_name FROM `patterns` LEFT JOIN files ON files.id=patterns.file_id LEFT JOIN users on users.id=files.id_user WHERE patterns.id=" . $patterns_id . " AND  users.id=" . $users_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_object();
        }
        return false;
    }

    /*
     * Проверка есть ли id пользователя в поле id_user_check
     */

    public function checkEditRightsPattern2($patterns_id, $users_id) {
        $query = "SELECT patterns.id, users.id, patterns.pattern_name FROM `patterns` LEFT JOIN files ON files.id=patterns.file_id LEFT JOIN users on users.id=files.id_user_check WHERE patterns.id=" . $patterns_id . " AND  users.id=" . $users_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_object();
        }
        return false;
    }

    /*
     * $field - поле таблици pattern, $value - значение string, $pattern_id - id записи.
     */

    public function updatePattern($field, $value, $pattern_id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `patterns` SET `" . $field . "`=" . $value . " WHERE `id`=" . $pattern_id;
            return $this->db->query($query);
        }
    }

    public function completedPatterns($arrayId, $action, $type) {
        if ($this->db->connect_errno === 0) {
            if ($type == 'user') {
                if ($action == 1) {
                    $query = "UPDATE `patterns` SET `completed`=1 WHERE `id` IN (";
                } elseif ($action == 0) {
                    $query = "UPDATE `patterns` SET `completed`=0, `checked`=0 WHERE `id` IN (";
                }
            } elseif ($type == 'checker') {
                if ($action == 1) {
                    $query = "UPDATE `patterns` SET `checked`=1 WHERE `completed`=1 and `id` IN (";
                } elseif ($action == 0) {
                    $query = "UPDATE `patterns` SET `checked`=0 WHERE `id` IN (";
                }
            }


            $i = 1;
            foreach ($arrayId as $value) {
                if ($i == 1) {
                    $query .= $value;
                    $i++;
                } else {
                    $query .= ', ' . $value;
                }
            }
            $query .= ')';
            return $this->db->query($query);
        }
    }

    public function updateManyPatterns($comment_for_adm, $arrayPatterns) {
        if ($this->db->connect_errno === 0) {
            $i = 0;
            foreach ($arrayPatterns as $value) {
                $query = "UPDATE `patterns` SET `comment_for_adm`=" . $comment_for_adm . ",`completed`=0,`checked`=0, `comments`='" . $value['comments'] . "' WHERE `id`=" . $value['id'];

                if ($this->db->query($query)) {
                    $i++;
                }
            }

            if (count($arrayPatterns) == $i) {
                return TRUE;
            }
            return FALSE;
        }
    }

    public function getCommentsForBd($pattern_id) {
        $query = "SELECT `comments` FROM `patterns` WHERE `id`=" . $pattern_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function getNotes($user_id) {
        $query = "SELECT `id`,`notes`, `date` FROM `notes` WHERE `user_id`=" . $user_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function createNotes($user_id) {
        if ($this->db->connect_errno === 0) {
            $query = "INSERT INTO `notes`(`id`, `user_id`, `notes`, `date`) VALUES (null," . $user_id . ",null,null)";
            return $this->db->query($query);
        }
    }

    public function updateNotes($user_id, $notes, $date) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `notes` SET `notes` = '" . $notes . "', `date` = '" . $date . "' WHERE `notes`.`user_id` =" . $user_id;
            return $this->db->query($query);
        }
    }

    public function updatePatternComments($value, $pattern_id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `patterns` SET `comments`='" . $value . "' WHERE id=" . $pattern_id;
            return $this->db->query($query);
        }
    }

    public function fileCompleted($value, $date, $file_id) {
        if ($this->db->connect_errno === 0) {
            if ($value == 'NULL') {
                $query = "UPDATE `files` SET `completed`=" . $value . ", `completed_date`=" . $date . "  WHERE id=" . $file_id;
            } else {
                $query = "UPDATE `files` SET `completed`='" . $value . "', `completed_date`='" . $date . "'  WHERE id=" . $file_id;
            }

            return $this->db->query($query);
        }
    }

    public function selectUserById($user_id) {
        $query = "SELECT `surname`,`name`,`patronymic`,`birthday`,`phone`,`gender_id` FROM `users` WHERE id=" . $user_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function selectGender() {
        $query = "SELECT * FROM `gender`";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function selectEmail() {
        $query = "SELECT email_to_activate.email FROM `email_to_activate` WHERE id=1 LIMIT 1";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function updateProfileUser($user) {
//        ["surname"]=> string(18) "Рябушенко" 
//        ["name"]=> string(20) "Константин" 
//        ["patronymic"]=> string(22) "Григорьевич" 
//        ["birthday"]=> string(10) "1988-04-28" 
//        ["phone"]=> string(17) "+38(068)448-67-40" 
//        ["gender_id"]=> string(1) "1" 
//        ["snp"]=> string(25) "Рябушенко К.Г." 
//        ["id"]=> string(1) "1"
        if ($this->db->connect_errno === 0) {
            if ($user['phone'] !== 'NULL') {
                $user['phone'] = "'" . $user['phone'] . "'";
            }
            if ($user['birthday'] !== 'NULL') {
                $user['birthday'] = "'" . $user['birthday'] . "'";
            }
            $query = "UPDATE `users` SET `name`='" . $user['name'] . "',`surname`='" . $user['surname'] . "',`patronymic`='" . $user['patronymic'] . "',`phone`=" . $user['phone'] . ",`gender_id`=" . $user['gender_id'] . ",`birthday`=" . $user['birthday'] . ",`snp`='" . $user['snp'] . "' WHERE id=" . $user['id'];
            return $this->db->query($query);
        }
    }

    public function updatePassword($user_id, $password) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `users` SET `password`='" . $password . "' WHERE `id`=" . $user_id;
//            var_dump($query);
//            exit();
            return $this->db->query($query);
        }
    }

    public function saveFromBDwithId($file_id) {
        $query = "SELECT files.file_name, files.name, patterns.pattern_name, patterns.comments FROM `files`LEFT JOIN  patterns ON files.id=patterns.file_id where files.id=" . $file_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

}
