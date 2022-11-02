<?php

require_once "crud.php";

$post_data = json_decode(file_get_contents("php://input", true));

$db = new CRUD("db.json");
$error = [];

if (isset($post_data->login)) {
    if (strlen($post_data->login) < 6) {
        array_push($error, ["login" => "login must be > 5 letters"]);
    } elseif ($db->isUnique($post_data->login, "login")) {
        array_push($error, ["login" => "login must be unique"]);
    }
} 
if (isset($post_data->password1)) {
    if (!preg_match( "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $post_data->password1 )) {
        array_push($error, ["password1" => "password must contain numbers and letters nad must be > 5 letters"]);
    }
} 
if (isset($post_data->password2)) {
    if($post_data->password1 != $post_data->password2) {
        array_push($error, ["password2" => "wrong"]);
    }
} 
if (isset($post_data->name)) {
    if (!preg_match( "/^[A-Za-z]{2,}$/", $post_data->name )) {
        array_push($error, ["name" => "name must contain letters nad must be > 1 letters"]);
    }
} 
if (isset($post_data->email)) {
    if (!filter_var($post_data->email, FILTER_VALIDATE_EMAIL)) {
        array_push($error, ["email" => "Invalid email format"]);
    } elseif ($db->isUnique($post_data->email, "email")) {
        array_push($error, ["email" => "email must be unique"]);
    }
} 

if (empty($error)) {
    $db->update($post_data);
}

echo json_encode($error);