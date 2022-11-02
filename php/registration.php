<?php

require_once "crud.php";

$post_data = json_decode(file_get_contents("php://input", true));
$db = new CRUD("db.json");

//$db->delete();
$db->update($post_data);