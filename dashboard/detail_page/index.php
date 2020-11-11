<?php 

require '../../app.php';

$search_string = $_GET['search_string'] ?? '';
$id = $_GET['id'];

$sql = 'SELECT items.*, collections.user_id, collections.id, collections.name AS "collectionName"
        FROM `items` 
        INNER JOIN `collections` ON `items` . `collection_id` = `collections` . `id`
        WHERE `collection_id` = :id AND `items` . `name`LIKE :search_string
        ORDER BY `created_on` DESC';

    $sql_statement = $db->prepare($sql);
    $sql_statement->execute([
        ':id'=>$id,
        ':search_string'=>'%' . $search_string . '%',
    ]);
    $collections = $sql_statement->fetchAll();


    $sql = 'SELECT *
        FROM `collections`
        WHERE `user_id` = :id';
        

    $sql_statement = $db->prepare($sql);
    $sql_statement->execute([
        ':id'=>$_SESSION['user_id']
    ]);
    $collectionPhoto = $sql_statement->fetchAll();

    $sql = 'SELECT `photo`
    FROM `users`
    WHERE `user_id` = :id';
  
// print_r($collections);
$sql_statement = $db->prepare($sql);
$sql_statement->execute([
    ':id'=> $_SESSION['user_id']
]);
$userPhoto = $sql_statement->fetchAll();

$sql = 'SELECT collections.name, collections.id
        FROM `collections` 
        WHERE `id` = :id';

    $sql_statement = $db->prepare($sql);
    $sql_statement->execute([
        ':id'=>$id,
    ]);
    $collectionName = $sql_statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Collection</title>
    <link rel="stylesheet" type="text/css" href="../../scss/dashboard/detail_page/index.css">
</head>

<body>

    <div class="dashboardCollectie">
        <div class="profile">
            <div>
                <!-- <img src="../images/profile_pics/bluh small.jpg"> -->
                <img src="<?="../../images/profile_pic/" . $userPhoto[0]['photo']?>">
            </div>
            <div>
                <?= "<p>" . $_SESSION['first_name'] . "</p>"?>
                <a href="../../user/log_out2.php">Uitloggen</a>
            </div>
        </div>
        <nav>
            <h1> LOGO </h1>
            <div class="collectionImage">
                <?php 
               
               foreach($collectionPhoto as $item) {
                   include '../../views/photoCollection.php';
               }
               
               ?>
            </div>
        </nav>

        <div class="dashboard">
            <div class="addItem">
                <form action="../../api/add_item.php" method="POST" enctype="multipart/form-data">
                    <input type="file" accept="image/png, image/jpeg, image/svg+xml, image/webp" name="fileToUpload"
                        id="fileToUpload" require><br>
                    <input type="text" id="collectionName" name="itemName" placeholder="Item naam" require><br>
                    <input type="text" id="AP" name="AP" placeholder="Aankoop prijs" require><br>
                    <input type="text" id="VP" name="VP" placeholder="Verkoop prijs"><br>
                    <input type="hidden" id="custId" name="itemId" value=<?= $id?>>
                    <button type="submit">Add item</button>
                </form>
            </div>
            <div class="welcome">
                <div class="head">
                    <a href="../index.php">
                        <img class="arrow" src="../../images/dashboard/detail_page/arrow.svg">
                        <?php 
               
                         foreach($collectionName as $item) {
                            echo "<p>" . $item['name'] . "</p>";
                        }
               
                        ?>
                    </a>
                </div>
                <hr>
            </div>

            <div>
                <div class="filter">
                    <div class="buttons">
                        <p class="add">+ Add</p>
                        <p> - Delete </p>
                    </div>

                    <div>
                        <h1 class="ap">0</h1>
                    </div>

                    <div class="filterOptions">
                        <form>
                            <input class="search" name="search_string" type="text" placeholder="Zoeken.."
                                value="<?= $search_string ?>">
                            <input type="hidden" id="custId" name="id" value=<?= $id?>>
                        </form>
                        <div>
                            <img class="filterImage" src="../../images/dashboard/sliders-h-solid.svg" alt="filter"
                                title="filter">
                        </div>
                    </div>
                </div>
            </div>


            <div class="collections">

                <?php 
               
               foreach($collections as $item) {
                   include '../../views/item.php';
               }
               
               ?>

            </div>

        </div>
    </div>

    <script src="../../scripts/items.js"></script>
</body>

</html>