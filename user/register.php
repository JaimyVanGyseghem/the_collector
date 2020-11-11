<?php

include '../app.php';
$message = '';
if( isset($_POST['register'] ) ) {

    //TODO: validatie op velden... (bv lengte van wachtwoord)
    //TODO: Controle of email adres reeds gebruikt wordt

    $photo = '';
    $sql = 'SELECT COUNT(`email`) as total from `users` WHERE `email` = :email';
    $pdo_statement = $db->prepare($sql);
    $pdo_statement->execute( [ 
    ':email' => $_POST['email'] ?? '',
    ] );
    $total = (int) $pdo_statement->fetchColumn();

    if($total > 0) {
        $message = "email bestaat al...";
    } else {
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {

            $upload_dir = '../images/profile_pic/';
        
            if (! is_dir($upload_dir)) {
                mkdir ($upload_dir,0777, true);
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
        //SQL om all info op te vragen van de huidige page_id ($v_id)
        $sql = 'INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `photo`)
                VALUES (:first_name, :last_name, :email, :password, :photo)';
        $pdo_statement = $db->prepare($sql);
        $pdo_statement->execute( [ 
            ':first_name' => $_POST['first_name'] ?? '',
            ':last_name' => $_POST['last_name'] ?? '',
            ':email' => $_POST['email'] ?? '',
            ':password' => password_hash( $_POST['password'], PASSWORD_DEFAULT ),
            ':photo' => $photo
        ] );

        $user_id = $db->lastInsertId();
        
        $_SESSION['user_id'] = $user_id;
        print_r($_FILES);
        header('location: ../user/log-in.php');

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../scss/user/register/index.css">
    <script src="https://kit.fontawesome.com/c61f609cc1.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
    <a class="close" href="../index.php"><i class="fas fa-times"></i></a>
        <div class="form">
            <?php if($message) : ?>
            <div class="alert"><?= $message; ?></div>
            <?php endif; ?>
            <output id="list"><img src="../images/dummy.png"></output>
            <form method="POST" enctype="multipart/form-data">
                <p class="fileupload">
                    <input type="file" accept="image/png, image/jpeg, image/JPEG, image/svg+xml, image/webp" name="fileToUpload"
                        id="fileToUpload" require>
                    <input type="button" value="Kies je profielfoto"
                        onclick="document.getElementById('fileToUpload').click();" />
                </p>
                <p>
                    <input type="text" name="first_name" id="first_name" placeholder="Voornaam" required>
                </p>
                <p>
                    <input type="text" name="last_name" id="last_name" placeholder="Familienaam" required>
                </p>
                <p>
                    <input type="email" name="email" id="email" placeholder="E-mail" required>
                </p>
                <p>
                    <input type="password" name="password" id="password" placeholder="Wachtwoord" pattern=".{6,}"   required title="6 characters minimum">
                </p>
                <button type="submit" name="register">Registreer</button>
                <p class="link">Heb je al een account? <a href="./log-in.php">Log hier in</a></p>
            </form>
        </div>

        <div class="info">
            <div>
                <h1> Registreer je nu!</h1>
                <p>Je collecties wachten op je.</p>
            </div>
        </div>

    </div>

    <script src="../scripts/upload.js"></script>
</body>

</html>