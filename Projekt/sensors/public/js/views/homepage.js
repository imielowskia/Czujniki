var mymap = L.map('mapid').setView([ 50.01628836750675,22.677583694458008 ], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a> href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a> href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiZHVkYTEzMTMzIiwiYSI6ImNrcDJwdmQ2dDFwMTUycW1jY2w4aHM0d2cifQ.jkBf9aZmMU6QUS9wHtoGBQ'
    }).addTo(mymap);
    $.ajax({
        type:"Point",
        url: 'https://github.com/imielowskia/Czujniki/blob/master/Projekt/sensors/public/js/views/map.geojson',
        dataType: 'json',
        success: console.log("Dane załadowane pomyślnie"),
        error: function (xhr) {
            alert(xhr.statusText)
        }
    }).addTo(mymap);
