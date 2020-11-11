<?php 
header('Content-Type: application/json');

require '../app.php';

$id = $_GET['id'];
$sql = 'SELECT `ap`, `vp`, `collection_id`
FROM `items`
INNER JOIN `collections` ON `items` . `collection_id` = `collections` . `id`
WHERE `collection_id` = :id';
// print_r($collections);
$sql_statement = $db->prepare($sql);
$sql_statement->execute([
':id'=> $id
]);
$calculator = $sql_statement->fetchAll();

print_r(json_encode($calculator));