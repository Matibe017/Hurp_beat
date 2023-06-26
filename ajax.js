const table = document.querySelector('#public')
const searchInput = document.getElementById('search')

async function viewDetails(playlistName) {
    //console.log(playlistName)
    let resp = await fetch('table01.php')
    let data = await resp.json()
    let tracks = await fetch('tracks.php')
    let trackData = await tracks.json()
    //console.log(data)
    //console.log(trackData)
    let queryParams = []
    for(const key in data){
        console.log(key)
        if(data[key].name == playlistName){
            let t = data[key].tracks
            for(const num in t){
                // console.log(data[key].tracks[num])
                //console.log(trackData[data[key].tracks[num]].artist)
                console.log(t[num])
                let trackId = t[num]
                console.log(trackData[trackId])
                queryParams.push(`track=${encodeURIComponent(trackId)}`)
            }
        }
    }
    let queryString = queryParams.join('&')
    window.location.href = `details.php?${queryString}`;
}


async function refresh(){
    let resp = await fetch('table.php?search='+searchInput.value)
    let data = await resp.json()
    console.log(data)
    table.innerHTML = "<tr><th>Playlist name</th><th>Number of tracks</th><th>User</th><th>Details</th></tr>"
    for(const key in data){
        console.log(data[key])
        let tr = document.createElement('tr')
        for(const field in data[key]){
            let td = document.createElement('td')
            td.innerText = data[key][field]
            tr.appendChild(td)
        }
        let buttonCell = document.createElement('td')
        let button = document.createElement('button')
        button.innerText = 'View Details'
        button.addEventListener('click', ()=>{
            viewDetails(data[key].name);
        });
        buttonCell.appendChild(button)
        tr.appendChild(buttonCell)
        table.appendChild(tr)
    }
}

refresh()
searchInput.addEventListener('input', refresh)