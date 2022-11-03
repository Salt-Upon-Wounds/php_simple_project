<?php

class CRUD {
    private $db;

    public function __construct($db_adress)
    {
        if(isset($db_adress)) {
            $this->db = $db_adress;
        }
        else {
            $this->db = "";
        }
    }

    public function create($data) {
        return file_put_contents($this->db, json_encode($data, JSON_PRETTY_PRINT));
    }
    public function read() {
        return json_decode(file_get_contents($this->db, true));
    }
    public function update($data) {
        $db_data = $this->read();
        array_push($db_data, $data);
        $this->create($db_data);
    }
    public function delete() {
        $this->create([]);
    }

    public function isUnique($data, $field_name) {
        return in_array($data, array_column($this->read(), $field_name));
    }

    public static function hash($data) {
        return password_hash($data, PASSWORD_BCRYPT, ["cost" => 12]);
    }
}