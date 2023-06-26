<?php
    include_once('storage.php');
    $stor = new Storage(new JsonIO('tracks.json'));
    $data = $stor -> findAll();
    $totalTime = 0;
    $filter_data = [];
    foreach($_GET as $key => $value){
        $filter_data[] = [
            'title' => $data[$value]['title'],
            'artist' => $data[$value]['artist'],
            'length' => $data[$value]['length'],
            'year' => $data[$value]['year'],
            'genres' => $data[$value]['genres']
        ];
        $totalTime += $data[$value]['length'];
    }
    //echo json_encode($filter_data, JSON_PRETTY_PRINT);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style01.css">
    <title>DETAILS</title>
</head>
<body>
    <h2>TOTAL PLAYING TIME: <?=$totalTime?></h2>
    <table id="trackDetails"></table>
    <script>
        const trackDetails = document.getElementById('trackDetails');
        const data = <?php echo json_encode($filter_data); ?>

        trackDetails.innerHTML = "<tr><th>TITLE</th><th>ARTIST</th><th>LENGTH</th><th>YEAR</th><th>GENRES</th></tr>"
        for(const track of data){
            let row = document.createElement('tr');
            let title = document.createElement('td');
            title.innerText = track.title;
            row.appendChild(title);
            let artist = document.createElement('td');
            artist.innerText = track.artist;
            row.appendChild(artist);
            let length = document.createElement('td');
            length.innerText = track.length;
            row.appendChild(length);
            let year = document.createElement('td');
            year.innerText = track.year;
            row.appendChild(year);
            //needs work
            let genres = document.createElement('td');
            genres.innerHTML += `<ul>`;
            if (typeof track.genres === "string"){
                //console.log("String");
                genres.innerHTML += `<li>${track.genres}</li>`;
            }else{
                //console.log("Array");
                for(let genre of track.genres) {
                    genres.innerHTML += `<li>${genre}</li>`;
                }
            }
            genres.innerHTML+=`</ul>`;
            row.appendChild(genres);
            trackDetails.appendChild(row);
        }

    </script>
</body>
</html>