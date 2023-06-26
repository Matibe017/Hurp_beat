<?php
    session_start();
    $isLogin = false;
    $isAdmin = false;
    if(isset($_SESSION['user_id'])){
        $isLogin = true;
        include_once('storage.php');
        $stor = new Storage(new JsonIO('users.json'));
        $user = $stor -> findById($_SESSION['user_id']);
        if($user['isAdmin']){
            $isAdmin = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style01.css">
    <title>HURP BEAT</title>
</head>
<body>
    <h1>HURP BEAT</h1>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z"/>
    </svg>
    <span style="color: #aa4c4cc5">Welcome to Hurp Beat, a place you can create music playlists of your choosing. Music for evryone and every mood. View and share your playlists with other users.</span>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z"/>
    </svg>
    <br>
    <?php if($isLogin): ?>
        <h2>Hello, <?= $user['username'] ?></h2>
    <?php endif; ?>
    Search: <input type="text" id="search" placeholder="Enter tack title."><br>
    <?php if(!$isLogin): ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Sign up</a>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
    <?php if($isLogin): ?>
        <a href="myPlaylists.php">Create new playlist</a>
        <?php if($isAdmin):?>
            <a href="createTrack.php">Create new Track</a>
        <?php endif; ?>
    <?php endif; ?>
    <table id="public"></table><br>
    <script src="ajax.js"></script>
</body>
</html>