<?php

namespace core\models;

use mysqli;

class VerificationModel extends AbstractModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'users';
    }

    public function selectByToken($token) {
        $query = "SELECT * FROM users WHERE token='" . $token . "' LIMIT 1";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_object();
        }
        return false;
    }

    public function updateVerified($id) {
        if ($this->db->connect_errno === 0) {
            $query = "UPDATE `users` SET `verified`=2,`token`=null WHERE `id`=" . $id . "";
            return $this->db->query($query);
        }
    }

}
