<?php
session_start();
require '../app.php';
$message = '';
$collectionName = $_POST['collectionName'];
$photo = '';
$user_id = $_SESSION['user_id'];
// print_r($_SESSION['user_id']);
// print_r($_FILES);
if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {

    $upload_dir = '../images/' . $user_id . "/";

    if (! is_dir($upload_dir)) {
        mkdir ($upload_dir);
    }

    $tmp_location = $_FILES['fileToUpload']['tmp_name'];
    $old_name = $_FILES['fileToUpload']['name'];
    $file_info = pathinfo($old_name);
    $file_type = $_FILES['fileToUpload']['type'];
    $extension = $file_info['extension'];

    if( in_array($file_type, ['image/jpeg', 'image/png', 'image/gif']) ) {
        $photo = uniqid() . '.' . $file_info['extension'];
        $new_locataion = $upload_dir . $photo;
        move_uploaded_file($tmp_location, $new_locataion);
     } else {
         print_r("fout bestand");
     }

}

if( isset($_POST['postit'] ) ) {

$sql = 'SELECT COUNT(`name`) as total from `collections` WHERE `name` = :name';
$pdo_statement = $db->prepare($sql);
$pdo_statement->execute( [ 
':name' => $collectionName
]);
$total = (int) $pdo_statement->fetchColumn();

if($total > 0) {
    $message = "Name bestaat al...";
} else {
    $sql = 'INSERT INTO `collections` (`user_id`, `name`, `photo`)
    VALUES (:user_id, :name, :photo)';
    
    $sql_statement = $db->prepare($sql);
    $sql_statement->execute(
        [
            ':user_id' => $user_id,
            ':name' => $collectionName,
            ':photo' => $photo,
        ]
        );
    
    }
}
print_r($total);
header('location: ../dashboard/index.php'. $itemId);
die();