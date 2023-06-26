<?php
    session_start();
    include_once('storage.php');
    $search = $_GET['search'] ?? '';
    $stor = new Storage(new JsonIO('playlists.json'));
    $data = $stor -> findAll();
    $filter_data = [];
    if(isset($_SESSION['user_id'])){
        include_once('storage.php');
        $stor = new Storage(new JsonIO('users.json'));
        $user = $stor -> findById($_SESSION['user_id']);
        if($user){
            foreach($data as $d){
                if(strpos($d['name'], $search) !== false){
                    $filter_data[] = [
                        'name' => $d['name'],
                        'public' => count($d['tracks']),
                        'created_by' => $d['created_by'],
                    ];
                }
            }
        }
    }else{
        foreach($data as $d){
            if($d['public'] === true){
                if(strpos($d['name'], $search) !== false){
                    $filter_data[] = [
                        'name' => $d['name'],
                        'public' => count($d['tracks']),
                        'created_by' => $d['created_by'],
                    ];
                }
            }
        }
    }
    echo json_encode($filter_data, JSON_PRETTY_PRINT);
?>