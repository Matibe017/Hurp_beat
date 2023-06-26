<?php
    session_start();
    include_once('storage.php');
    $stor = new Storage(new JsonIO('playlists.json'));
    $stor2 = new Storage(new JsonIO('tracks.json'));
    $tracks = $stor2 -> findAll();
    $error = false;
    $trackList = [];
    if($_POST){
        if(isset($_POST['submit'])){
            if(!empty($_POST['songs'])){
                $id = null;
                $selected = $_POST['songs'];
                foreach($tracks as $key => $d){
                    if($d['title'] == $_POST['songs']){
                        $id = intval($key);
                        $trackList[] = $id;
                    }
                }    
                $stor -> add([
                    'name' => $_POST['playlistName'],
                    'public' => isset($_POST['public']),
                    'created_by' => $_SESSION['user_id'],
                    'tracks' => $trackList
                ]);
                header('location: index.php');
            }else{
                $error = true;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CREATE NEW PLAYLIST</title>
</head>
<body>
    <form action="myPlaylists.php" method="POST">
        Enter name of playlist: <input type="text" name="playlistName"><br>
        Public: <input type="checkbox" name="public"><br>
        <select name="songs">
            <option value="" disabled selected>--choose option--</option>
            <?php foreach($tracks as $d):?>
                <option value="<?=$d['title']?>"><?=$d['title']?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="submit">ADD</button>
    </form>
    <?php if($error): ?>
        <span style="color: red">Please select a song.</span>
    <?php endif; ?>
</body>
</html>