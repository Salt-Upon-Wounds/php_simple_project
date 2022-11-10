<?php
session_start();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Если к нам идёт Ajax запрос, то ловим его
    require_once "crud.php";

    $post_data = json_decode(file_get_contents("php://input", true));

    $db = new CRUD("db.json");
    $error = [];

    //валидация данных
    if (isset($post_data->login)) {
        $post_data->login = trim($post_data->login);
        if (strlen($post_data->login) < 6) {
            $error["login"] = "login must be > 5 letters";
        } elseif ($db->isUnique($post_data->login, "login")) {
            $error["login"] = "login must be unique";
        }
    } 
    if (isset($post_data->password)) {
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $post_data->password )) {
            $error["password"] = "password must contain numbers and letters and must be > 5 letters\nwithout spaces and special characters";
        }
    } 
    if (isset($post_data->password2)) {
        if ($post_data->password != $post_data->password2) {
            $error["password2"] = "wrong";
        }
    } 
    if (isset($post_data->name)) {
        if (!preg_match("/^[A-Za-z]{2,}$/", $post_data->name )) {
            $error["name"] = "name must contain letters and must be > 1 letters";
        }
    } 
    if (isset($post_data->email)) {
        if (!filter_var($post_data->email, FILTER_VALIDATE_EMAIL)) {
            $error["email"] = "Invalid email format";
        } elseif ($db->isUnique($post_data->email, "email")) {
            $error["email"] = "email must be unique";
        }
    } 

    //если данные верные, то заносим их и создаем куки
    if (empty($error)) {
        $post_data->password = $db::hash($post_data->password);
        unset($post_data->password2);
        $db->update($post_data);
        setcookie("login", $post_data->login, time() + 36000, "/");
        setcookie("name", $post_data->name, time() + 36000, "/");
    }

    echo json_encode($error);
}


