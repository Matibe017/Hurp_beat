<?php
    session_start();
    include_once('storage.php');
    $search = $_GET['search'] ?? '';
    $stor = new Storage(new JsonIO('playlists.json'));
    $data = $stor -> findAll();
    echo json_encode($data, JSON_PRETTY_PRINT);
?>