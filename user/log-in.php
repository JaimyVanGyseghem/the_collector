<?php
include '../app.php';
$message = '';
if( isset($_POST['login'] ) ) {

    $user = User::getUserByEmail( $_POST['email'] );
    
    //controle of er een user inzit
    if( isset($user->email) ) {
        //controle of wachtwoord juist is
        if( password_verify ( $_POST['password'], $user->password) )
        {
            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['first_name'] = $user->first_name;
            header('location: ../dashboard/index.php');
        }
        else {
            $message = 'E-mail en/of wachtwoord is verkeerd';
        }
    }else {
        $message = 'E-mail en/of wachtwoord is verkeerd';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../scss/user/log-in/index.css">
    <script src="https://kit.fontawesome.com/c61f609cc1.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <a class="close" href="../index.php"><i class="fas fa-times"></i></a>
        <div class="form">
            <?php if($message) : ?>
            <div class="alert"><?= $message; ?></div>
            <?php endif; ?>
            <form method="POST">
            <div>
            <h1>Welkom!</h1>
            <p>Log in je account.</p>
            </div>
                <p>
                    <input type="email" name="email" id="email" placeholder="email">
                </p>
                <p>
                    <input type="password" name="password" id="password" placeholder="password">
                </p>
                <button type="submit" name="login">Login</button>
                <p class="link">Heb je geen account? <a href="./register.php">Maak hier één</a></p>
            </form>
        </div>

        <div class="info">
            <div>
                <h1> Log in!</h1>
                <p>Welkom terug! Je collecties wachten op u.</p>
            </div>
        </div>
    </div>

</div>
</body>

</html>