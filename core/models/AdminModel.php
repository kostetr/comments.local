<?php

namespace core\models;

use mysqli;

class AdminModel extends AbstractModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'users';
    }

    public function showAllLibsWithCommentsForAdm() {
        $query = "SELECT files.file_name, files.name as library_name, files.id_user, files.id_user_check,files.completed as file_completed, files.completed_date as file_completed_date,
patterns.id as pattern_id, patterns.file_id, patterns.pattern_name, patterns.comments as pattern_comments, patterns.completed as pattern_completed, patterns.checked as pattern_checked, patterns.comment_for_adm,
u1.login as user_login, u1.snp as user_snp, u2.login as user_check_login, u2.snp as user_check_snp
FROM patterns 
LEFT JOIN files ON files.id=patterns.file_id 
LEFT JOIN users u1 ON u1.id=files.id_user
LEFT JOIN users u2 ON u2.id=files.id_user_check
WHERE patterns.comment_for_adm=1";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function showAllLibsWithCommentsForAdmByFileId($file_id) {
        $query = "SELECT files.file_name, files.name as library_name, files.id_user, files.id_user_check,files.completed as file_completed, files.completed_date as file_completed_date,
patterns.id as pattern_id, patterns.file_id, patterns.pattern_name, patterns.comments as pattern_comments, patterns.completed as pattern_completed, patterns.checked as pattern_checked, patterns.comment_for_adm,
u1.login as user_login, u1.snp as user_snp, u2.login as user_check_login, u2.snp as user_check_snp
FROM patterns 
LEFT JOIN files ON files.id=patterns.file_id 
LEFT JOIN users u1 ON u1.id=files.id_user
LEFT JOIN users u2 ON u2.id=files.id_user_check
WHERE patterns.comment_for_adm=1 and patterns.file_id=" . $file_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function getEmailAdm() {
        $query = "SELECT email_to_activate.email AS email FROM `email_to_activate` WHERE id=1";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
            //return $result->fetch_row();
        }
        return false;
    }

    public function getAdmins() {
        $query = "SELECT * FROM `users` WHERE `access_level`<=100";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
            //return $result->fetch_row();
        }
        return false;
    }

    public function getUsers() {
        $query = "SELECT * FROM `users` WHERE `verified` = 1 or `verified` = 2";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
            //return $result->fetch_row();
        }
        return false;
    }

    public function updatePattern($field, $value, $pattern_id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `patterns` SET `" . $field . "`='" . $value . "' WHERE `id`=" . $pattern_id;
            return $this->db->query($query);
        }
    }

    public function updateEmailAdm($email) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `email_to_activate` SET `email`='" . $email . "' WHERE id=1";
            return $this->db->query($query);
        }
    }

    public function resetpassword($user_id, $user_reset_pass) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `users` SET `password`='" . $user_reset_pass . "' WHERE `id`=" . $user_id;
            return $this->db->query($query);
        }
    }

    public function changeaccesslevel($user_id, $user_access_level) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `users` SET  `access_level`=" . $user_access_level . " WHERE `id`=" . $user_id;
            return $this->db->query($query);
        }
    }

    public function blockuser($user_id, $verified) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `users` SET `verified`=" . $verified . " WHERE `id`= " . $user_id;
            return $this->db->query($query);
        }
    }

//        ["pattern_name"] => string(12) "dfgdfgdfgdfg"
//        ["pattern_comments"] => string(519) "13-01-2020 19:32:22t qweqweqwe"
//        ["completed"] => string(1) "1"
//        ["id"] => string(1) "2"
//        ["checked"] => int(0)
    public function updatePattern2($patternArray) {
        $patternArray["pattern_comments"] = str_replace(array("\r\n", "\r", "\n", '"'), ' ', $patternArray["pattern_comments"]);
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `patterns` SET `pattern_name`='" . $patternArray['pattern_name'] . "',`comments`='" . $patternArray['pattern_comments'] . "',
`completed`=" . $patternArray['completed'] . ",`checked`=" . $patternArray['checked'] . " WHERE `id`=" . $patternArray['id'];
//            var_dump($query);
//            exit();
            return $this->db->query($query);
        }
    }

    public function updateFileName($file_name, $name, $id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `files` SET `file_name`='" . $file_name . "',`name`='" . $name . "' WHERE `id`='" . $id . "'";
            return $this->db->query($query);
        }
    }

    public function updateFileJobDelivery($value, $id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `files` SET `job_delivery`='" . $value . "' WHERE `id`='" . $id . "'";
            return $this->db->query($query);
        }
    }

    public function updateFile($id_user, $id_user_check, $file_id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `files` SET `id_user`='" . $id_user . "',`id_user_check`='" . $id_user_check . "', `completed`=null ,`completed_date`=null, `job_delivery`=null WHERE `id`='" . $file_id . "'";
            return $this->db->query($query);
        }
    }

    public function resetPatternStatus($file_id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `patterns` SET  `completed`=0 ,`checked`=0 WHERE `file_id`=" . $file_id;
            return $this->db->query($query);
        }
    }

    public function insertNewFile($array) {
        if ($this->db->connect_errno === 0) {
            $query = "INSERT INTO `files`(`id`, `file_name`, `name`, `id_user`, `id_user_check`, `completed`, `completed_date`)VALUES 
        (null,'" . $array["file_name"] . "','" . $array["name"] . "',null,null,null,null);";
            return $this->db->query($query);
        }
    }

    public function insertNewPattern($array) {
        if ($this->db->connect_errno === 0) {
            $array['pattern_comments'] = str_replace(array("\r\n", "\r", "\n", '"'), ' ', $array['pattern_comments']);
            if ($array['pattern_comments'] == null) {
                $query = "INSERT INTO `patterns`(`id`, `file_id`, `pattern_name`, `comments`, `completed`, `checked`, `comment_for_adm`) 
VALUES (null," . $array['file_id'] . ",'" . $array['pattern_name'] . "',null,0,0,0)";
            } else {
                $query = "INSERT INTO `patterns`(`id`, `file_id`, `pattern_name`, `comments`, `completed`, `checked`, `comment_for_adm`) 
VALUES (null," . $array['file_id'] . ",'" . $array['pattern_name'] . "','" . $array['pattern_comments'] . "',0,0,0)";
            }
            return $this->db->query($query);
        }
    }

    public function insertNewPattern3($array) {
        if ($this->db->connect_errno === 0) {
            $query = "INSERT INTO `patterns`(`id`, `file_id`, `pattern_name`, `comments`, `completed`, `checked`, `comment_for_adm`) 
VALUES ";
            $i = 0;
            foreach ($array as $value) {
                if ($i == 0) {
                    $i++;
                    $query .= "(null," . $value['file_id'] . ",'" . $value['pattern_name'] . "','" . $value['pattern_comments'] . "',0,0,0)";
                } else {
                    $query .= ", (null," . $value['file_id'] . ",'" . $value['pattern_name'] . "','" . $value['pattern_comments'] . "',0,0,0)";
                }
            }
//            var_dump($query);
//            exit();
            return $this->db->query($query);
        }
    }

    public function openLibs($pattern_id) {
        $query = "SELECT patterns.id as pattern_id, patterns.pattern_name, patterns.comments as pattern_comments, files.file_name
FROM `patterns` LEFT JOIN files ON files.id=patterns.file_id WHERE patterns.id=" . $pattern_id;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function showAllFiles() {
        $query = "SELECT * FROM `files`";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function showAllFilesOnlyName() {
        $query = "SELECT `id`,`file_name`,`name` FROM `files`";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function showAllPatternsOnlyName() {
        $query = "SELECT `file_id`,`pattern_name` FROM `patterns`";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function showAllUsers() {
        $query = "SELECT `id`,`surname`,`name`,`patronymic`,`snp` FROM `users` ";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    /*
     * Возвращает все поля из таблицы
     * $table - 
     * $field - 
     * $value - 
     */

    public function showTableWhere($table, $field, $value) {
        $query = "SELECT * FROM `" . $table . "` WHERE `" . $field . "`='" . $value . "'";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

// TO DO можно совместить  с  showTableWhere через forich
    public function showTaskInWork() {
        $query = "SELECT files.id, files.file_name, files.name, files.completed, files.completed_date, files.job_delivery, u1.snp as user_snp, u2.snp as user_check_snp, u1.id as user_id, u2.id as user_check_id FROM `files` LEFT JOIN users u1 ON u1.id=files.id_user
LEFT JOIN users u2 ON u2.id=files.id_user_check WHERE files.id_user IS NOT NULL AND files.id_user_check IS NOT NULL AND files.job_delivery IS NULL ORDER BY files.completed";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function cencelTask($id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `files` SET `id_user`=null,`id_user_check`=null,`job_delivery`=null WHERE `id`=" . $id;
            return $this->db->query($query);
        }
    }

    public function deletePatterns($arrayId) {
        if ($this->db->connect_errno === 0) {
            $query = "DELETE FROM `patterns` WHERE `id` IN (";
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
        }

        return $this->db->query($query);
    }
    public function deleteFiles($arrayId) {
        if ($this->db->connect_errno === 0) {
            $query1 = "DELETE FROM `files` WHERE `id` IN (";
            $query2 = "DELETE FROM `patterns` WHERE `file_id` IN (";
            $i = 1;
            foreach ($arrayId as $value) {
                if ($i == 1) {
                    $query1 .= $value;
                    $query2 .= $value;
                    $i++;
                } else {
                    $query1 .= ', ' . $value;
                    $query2 .= ', ' . $value;
                }
            }
            $query1 .= ')';
            $query2 .= ')';
        }
        if($this->db->query($query1) && $this->db->query($query2)){
            return TRUE;
        } else {
            return FALSE;    
        }
    }


    public function movepaterns($file_id_new, $arrayId) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `patterns` SET `file_id`=" . $file_id_new . " WHERE `id` IN (";
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
        }
        return $this->db->query($query);
    }

    public function moveallpaterns($file_id_new, $file_id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `patterns` SET `file_id`=" . $file_id_new . " WHERE `file_id`=" . $file_id;
        }
        return $this->db->query($query);
    }

    public function saveFromBD() {
        $query = "SELECT files.file_name, files.name, patterns.pattern_name, patterns.comments FROM `files`LEFT JOIN  patterns ON files.id=patterns.file_id";
       // $query = "SELECT files.file_name, files.name, patterns.pattern_name, patterns.comments FROM `files`LEFT JOIN  patterns ON files.id=patterns.file_id ORDER BY files.file_name ASC";
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

}
