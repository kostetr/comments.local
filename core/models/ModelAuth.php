<?php

namespace core\models;

use mysqli;

class ModelAuth extends AbstractModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'users';
    }

    public function addUser($user) {
        if ($this->db->connect_errno === 0) {
            $query = "INSERT INTO `users`(`id`, `login`, `password`, `name`, `surname`, `patronymic`, `phone`, `gender_id`, `birthday`, `verified`, `token`, `registered`, `access_level`,`snp`) VALUES (NULL,'" . $user['login'] . "','" . $user['password'] . "','" . $user['name'] . "','" . $user['surname'] . "','" . $user['patronymic'] . "',null ," . $user['gender_id'] . ",null ,0,'" . $user['token'] . "','" . $user['registered'] . "'," . $user['access_level'] . ",'" . $user['snp'] . "')";
            return $this->db->query($query);
        }
    }

    public function selectByLogin($login) {
        $query = "SELECT * FROM " . $this->table . " WHERE login='" . $login . "' LIMIT 1";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_object();
        }
        return false;
    }

    public function selectByToken($token) {
        $query = "SELECT * FROM " . $this->table . " WHERE token='" . $token . "' LIMIT 1";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_object();
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
    
    public function updateVerified($id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `users` SET `verified`=1,`token`=null WHERE `id`=" . $id . "";
            return $this->db->query($query);
        }
    }   
}
