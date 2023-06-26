<?php
    include_once('storage.php');
    $stor = new Storage(new JsonIO('tracks.json'));
    $title = $_POST['title'] ?? '';
    $artist = $_POST['artist'] ?? '';
    $length = intval($_POST['length']) ?? -1;
    $year = intval($_POST['year']) ?? -1;
    $genres = explode(" ", $_POST['genres']) ?? [];
    $errors = [];
    if($_POST){
        if($title == ""){
            $errors['title'] = "Enter name of song. :(";
        }else if($artist == ""){
            $errors['artist'] = "Enter name of artist. :(";
        }else if($length == -1){
            $errors['length'] = "Enter length of song. :(";
        }else if($year == -1){
            $errors['year'] = "Enter year of release. :(";
        }else if(count($genres) == 0){
            $errors['genres'] = "Enter genre/genres of the song. :(";
        }else{
            $stor -> add([
                'title' => $_POST['title'],
                'artist' => $_POST['artist'],
                'length' => intval($_POST['length']),
                'year' => intval($_POST['year']),
                'genres' => explode(" ", $_POST['genres'])
            ]);
            header('location: index.php');
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
    <title>NEW TRACK</title>
</head>
<body>
    <h1>NEW SONG</h1>
    <form action="createTrack.php" method="POST">
        Title: <input type="text" name="title" value="<?=$title?>"><?=$errors['title'] ?? '' ?><br>
        Artist: <input type="text" name="artist" value="<?=$artist?>"><?=$errors['artist'] ?? '' ?><br>
        Length: <input type="number" name="length" value="<?=$length?>"><?=$errors['length'] ?? '' ?><br>
        Year: <input type="number" name="year" value="<?=$year?>"><?=$errors['year'] ?? '' ?><br>
        Genres: <input type="text" name="genres"><?=$errors['genres'] ?? '' ?><br><br>
        <button type="submit">Create</button>
    </form>
</body>
</html>