<?php
session_start();

require 'includes/db.php';


require 'models/BaseModel.php';
require 'models/User.php';



//Get User from session
$user_id = $_SESSION['user_id'] ?? 0;
$user = ($user_id) ? User::getById($user_id) : false;