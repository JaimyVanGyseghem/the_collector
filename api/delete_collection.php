<?php
require '../app.php';
$name = $_POST['deletecollectionName'];
print_r($name);
$user_id = $_SESSION['user_id'];
$sql = 'DELETE FROM `collections` WHERE `user_id` = :user_id AND `name` = :name';

$sql_statement = $db->prepare($sql);
$sql_statement->execute(
    [
        ':user_id' => $user_id, 
        ':name' => $name
    ]
    );

header('location: ../dashboard/index.php'. $itemId);