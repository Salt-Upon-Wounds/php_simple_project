<!DOCTYPE html>
<?php
session_start();
if (isset($_COOKIE["login"])) {
    header("Location: profile.php");
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>My Website</title>
</head>
<body>
<main>
    <div class="container mt-4">
        <h1>Регистрация</h1>  
        <form id="regForm" novalidate>
            <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин">
            <p><span id="loginMes" style="color:red"></span></p>
            <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">
            <p><span id="passwordMes1" style="color:red"></span></p>
            <input type="password" class="form-control" name="password2" id="password2" placeholder="Введите пароль еще раз">
            <p><span id="passwordMes2" style="color:red"></span></p>
            <input type="text" class="form-control" name="name" id="name" placeholder="Имя">
            <p><span id="nameMes" style="color:red"></span></p>
            <input type="email" class="form-control" name="email" id="email" placeholder="эл. почта">
            <p><span id="emailMes" style="color:red"></span></p>
            <button class="btn btn-success" type="submit">Завершить регистрацию</button>
        </form><br>
        <h1>Авторизация</h1>  
        <form id="authForm" novalidate>
            <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин">
            <p><span id="loginMes" style="color:red"></span></p>
            <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">
            <p><span id="passwordMes" style="color:red"></span></p>
            <button class="btn btn-success" type="submit">Завершить авторизацию</button>
        </form>
    </div>
</main>

<script>
    $(document).ready(function() {
        $("#regForm").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var user = {
                login: $("#regForm > #login").val(),
                password: $("#regForm > #password").val(),
                password2: $("#regForm > #password2").val(),
                name: $("#regForm > #name").val(),
                email: $("#regForm > #email").val(),
            };
            $.ajax({
                type: "POST",
                url: "php/registration.php",
                data: JSON.stringify(user), // serializes the form's elements.
                success: function(data) {
                    //alert(data); // show response from the php script.
                    //console.log(data);
                    var response = JSON.parse(data);
                    if(response.length == 0) window.location.href = "./profile.php";
                    //console.log(response);
                    $("#regForm span").each(function( index ) {
                        $( this ).text("");
                    });
                    $("#regForm #loginMes").text(response["login"]);
                    $("#regForm #passwordMes1").text(response["password"]);
                    $("#regForm #passwordMes2").text(response["password2"]);
                    $("#regForm #nameMes").text(response["name"]);
                    $("#regForm #emailMes").text(response["email"]);
                },
                caches:false,
            });

        });

        $("#authForm").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var user = {
                login: $("#authForm > #login").val(),
                password: $("#authForm > #password").val(),
            };
            $.ajax({
                type: "POST",
                url: "php/login.php",
                data: JSON.stringify(user), // serializes the form's elements.
                success: function(data) {
                    //alert(data); // show response from the php script.
                    //console.log(data);
                    var response = JSON.parse(data);
                    if(response.length == 0) window.location.href = "./profile.php";
                    //console.log(response);
                    $("#authForm span").each(function( index ) {
                        $( this ).text("");
                    });
                    $("#authForm #loginMes").text(response["login"]);
                    $("#authForm #passwordMes").text(response["password"]);
                },
                caches:false,
            });

        });
    });
</script>
</body>

