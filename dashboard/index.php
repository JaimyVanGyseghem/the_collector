<?php 
    require '../app.php';
    $sql = 'SELECT * 
            FROM `collections` 
            INNER JOIN `users` ON `collections` . `user_id` = `users` . `user_id`
            WHERE `collections` . `user_id` = :id
            ORDER BY `creared_on` ASC';

    $sql_statement = $db->prepare($sql);
    $sql_statement->execute(
        [
            ':id'=> $_SESSION['user_id']
        ]
    );
    $collections = $sql_statement->fetchAll();

    $sql = 'SELECT * 
    FROM `users`';
  
// print_r($collections);
$sql_statement = $db->prepare($sql);
$sql_statement->execute();
$users = $sql_statement->fetchAll();

$sql = 'SELECT `photo`
    FROM `users`
    WHERE `user_id` = :id';
  
// print_r($collections);
$sql_statement = $db->prepare($sql);
$sql_statement->execute([
    ':id'=> $_SESSION['user_id']
]);
$userPhoto = $sql_statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Collection</title>
    <link rel="stylesheet" type="text/css" href="../scss/dashboard/index.css">
</head>

<body>
    <div class="dashboardCollectie">
        <div class="profile">
            <div>
                <!-- <img src="../images/profile_pics/bluh small.jpg"> -->
                <img src="<?="../images/profile_pic/" . $userPhoto[0]['photo']?>">
            </div>
            <div>
                <?= "<p>" . $_SESSION['first_name'] . "</p>"?>
                <a href="../user/log_out.php">Uitloggen</a>
            </div>
        </div>
        <nav>
            <h1> LOGO </h1>
            <div>
                <div class="relative">
                    <h2 class="add">+</h2>
                    <p>Add collectie</p>

                    <div class="addCollection">
                        <form action="../api/add_collection.php" method="POST" enctype="multipart/form-data">
                            <input type="file" accept="image/png, image/jpeg, image/svg+xml, image/webp"
                                name="fileToUpload" id="fileToUpload" required>
                            <input type="text" id="collectionName" name="collectionName"
                                placeholder="Collectie naam" required><br>
                            <button type="submit" name="postit">Add collectie</button>
                        </form>
                    </div>
                </div>
                <div class="relative">
                    <h2 class="delete">-</h2>
                    <p>Delete collectie</p>
                    <div class="deleteCollection">
                        <form action="../api/delete_collection.php" method="POST">
                            <input type="text" id="deletecollectionName" name="deletecollectionName"
                                placeholder="welke collectie wil je verwijderen" required><br>
                            <button type="submit">Delete collectie</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="dashboard">
            <div class="welcome">
                <?= "<p> Welkom " . $_SESSION['first_name'] . "</p>"?>

                <hr>
            </div>

            <div>
                <div class="filter">
                    <h2>Collectie</h2>
                    <img src="../images/dashboard/sliders-h-solid.svg" alt="filter" title="filter">
                </div>
            </div>

            <div class="collection">

                <?php 
               
               foreach($collections as $item) {
                   include '../views/collection.php';
               }
               
               ?>

            </div>
        </div>

    </div>

    <script src="../scripts/index.js"></script>
</body>

</html>