<?php
    require './app.php';
    $id = $_GET['id'] ?? 0;
    $user_id = $_SESSION['user_id'];
    if( isset($_POST['update']) ) {
        
        //waarden uit post halen
        $collectionName = $_POST['name'] ?? '';
        
        if( $id ) {
            //Update sql schrijven
            $sql = 'UPDATE `collections` 
                    SET `name` = :name
                    WHERE `id` = :id';
            $update_statement = $db->prepare($sql);
            $update_statement->execute(
                [
                    ':name' => $collectionName,
                    ':id' => $id,
                ]
            );
        } else {
            //INSERT ITEM
            $sql = 'INSERT INTO `collections` (`name`, `user_id`)
                    VALUES (:name, :user_id)';
            $insert_statement = $db->prepare($sql);
            $insert_statement->execute(
                [
                    ':name' => $collectionName,
                    'user_id' => $user_id
                ]
            );

            $new_id = $db->lastInsertId();

            header('location: ./dashboard/index.php'. $$new_id);
            die();
        }
        
    }

    if ( $id ) {
        //SQL om page_id, slug en name op te vragen van alle paginas
        $sql = 'SELECT * FROM `collections` WHERE `id` = :id';
        $pdo_statement = $db->prepare($sql);
        $pdo_statement->execute( [ ':id' => $id ] );
        $page = $pdo_statement->fetchObject();
    } 
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
    <link rel="stylesheet" href="css/main.min.css">
</head>

<body>
    <div class="container">

        <form method="POST">
            <input type="text" id="collectionName" name="collectionName" placeholder="Collectie naam" required><br>

            <button type="submit" class="btn btn-primary" name="update">Aanpassen</button>
            <a href="index.php" class="btn btn-outline-secondary">Terug</a>

        </form>


    </div>


</body>

</html>