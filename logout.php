<?php
session_start();
setcookie("login", "", time() - 3600, "/");
setcookie("name", "", time() + 3600, "/");