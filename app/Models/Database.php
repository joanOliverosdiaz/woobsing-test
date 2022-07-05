<?php

namespace App\Models;

class Database {

    protected $db;


    public function __construct()
    {
        $this->db = new \mysqli('127.0.0.1', 'root', '123456', 'test_woobsing');
    }

    public function __desctruct()
    {
        $this->db->close();
    }

}
