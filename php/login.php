<?php
session_start();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Если к нам идёт Ajax запрос, то ловим его
    require_once "crud.php";

    $post_data = json_decode(file_get_contents("php://input", true));

    $db = new CRUD("db.json");
    $error = [];

    //проверка существования пользователя
    //если есть, то создаем куки
    if (isset($post_data->login) && isset($post_data->password)) {
        $all = $db->read();
        foreach ($all as $val) {
            if ($val->login == $post_data->login) {
                if (password_verify($post_data->password, $val->password)) {
                    setcookie("login", $post_data->login, time() + 36000, "/");
                    setcookie("name", $val->name, time() + 36000, "/");
                    echo json_encode($error);
                    exit(0);
                } else {
                    $error['password'] = 'wrong password';
                }
            }
        }
    } 

    if (!isset($error['password'])) {
        $error['login'] = 'login doesnt exist';
    }
    echo json_encode($error);
}


