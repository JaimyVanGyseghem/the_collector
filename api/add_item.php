<?php
session_start();
require '../includes/db.php';

$itemName = $_POST['itemName'];
$AP = $_POST['AP'];
$VP = $_POST['VP'];
$itemId = $_POST['itemId'];
$photo = '';

$user_id = $_SESSION['user_id'];

if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {

    $upload_dir = '../images/' . $user_id . "/items" . "/";

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

$sql = 'INSERT INTO `items` (`collection_id`, `name`, `ap`, `vp`, `photo`)
VALUES (:collection_id, :name, :ap, :vp, :photo)';

$sql_statement = $db->prepare($sql);
$sql_statement->execute(
    [
        ':collection_id' => $itemId,
        ':name' => $itemName,
        ':ap' => $AP,
        ':vp'=> (int) $VP,
        ':photo' => $photo,
    ]
    );


header('location: ../dashboard/detail_page/index.php?id=' . $itemId);
die();