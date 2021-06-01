<?php

namespace core\models;

use mysqli;

abstract class AbstractModel {

    /**
     *
     * @var mysqli
     */
    protected $db;

    /**
     *
     * @var string 
     */
    public $table;

    public function __construct() {
        $this->db = new mysqli('qqq', 'qqq', 'qqq', 'qqq');
        $this->db->set_charset("utf8");
    }

    public function all() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

}
