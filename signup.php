<?php
    session_start();
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['<PASSWORD>'] ?? '';
    include_once('storage.php');
    $stor = new Storage(new JsonIO('users.json'));
    $errors = [];
    $error = false;
    if($_POST){
        if($username === ''){
            //error : username required
            $error = true;
            $errors['username'] = "Username is required! :(";
        }
        if($email === ''){
            //error : email required
            $error = true;
            $errors['email'] = "Email is required! :(";
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            //error : invalid email
            $error = true;
            $errors['email'] = "Invalid Email! :(";
        }
        if($password === ''){
            //error : password required
            $error = true;
            $errors['password'] = "Password is required! :(";
        }else if($password !== $passwordConfirm){
            //error : password mismatch
            $error = true;
            $errors['passwordConfirm'] = "Passwords mismatch! :(";
        }
        if(!$error){
            $stor -> add([
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'isAdmin' => false
            ]);
            header('location: login.php');
        }
    }
    $errors = array_map(fn($e) => "<span style='color:red'>$e</span>", $errors);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style01.css">
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>
    <form method="POST" action="signup.php" novalidate>
        Username : <input type="text" name="username" value="<?= $username ?>"> <?= $errors['username'] ?? '' ?><br>
        Email    : <input type="email"  name="email" value="<?= $email ?>"> <?= $errors['email'] ?? '' ?><br>
        Password : <input type="password" name="password" value="<?= $password ?>"> <?= $errors['password'] ?? '' ?><br>
        Confirm password : <input type="password" name="<PASSWORD>" value="<?= $passwordConfirm ?>"> <?= $errors['passwordConfirm'] ?? '' ?><br><br>
        <button type="submit">Sign up</button>
    </form>
</body>
</html>