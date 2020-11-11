<?php
session_start();
//session_destroy();

$_SESSION['user_id'] = 0;

header ('location: ../index.php');