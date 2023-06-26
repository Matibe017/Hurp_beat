<?php
    session_start();
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $error = false;
    if($_POST){
        include_once('storage.php');
        $stor = new Storage(new JsonIO('users.json'));
        $user = $stor -> findOne(['username' => $username, 'password' => $password]);
        if(!$user){
            $error = true;
        }else{
            $_SESSION['user_id'] = $user['id'];
            header('location: index.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style01.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="login.php" novalidate>
        Username : <input type="text" name="username"><br>
        Password : <input type="password" name="password"><br><br>
        <button type="submit">Login</button>
    </form>
    <?php if ($error): ?>
        <span style="color:red">Inavlid username and/or password!</span>
    <?php endif; ?>
</body>
</html>