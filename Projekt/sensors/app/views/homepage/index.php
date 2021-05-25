<!DOCTYPE html>
<html lang="pl" class="h-100">

<head>
    <title>Czujniki</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="<?= IMG_PATH ?>favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= CSS_PATH ?>bootstrap.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>leaflet.css">
</head>

<body class="d-flex h-100">
    <div class="container d-flex flex-column mx-auto">
        <header class="navbar-light border-bottom mb-auto p-3">
            <span class="float-start">
                <a class="nav-link" href="<?= ROOT_PATH ?>">
                    <h5>Czujniki</h5>
                </a>
            </span>
            <span class="float-end">
                <a class="nav-link" href="#">Autorzy</a>
            </span>
        </header>

        <main>
            <div class="row row row-cols-1 row-cols-lg-2 align-items-center">
                <div class="col p-4">
                    <h2 class="fw-light">Witamy na stronie czym oddycham!</h2>
                    <p class="lead text-muted">
                        Tutaj dowiecie się jakie zanieczyszczenia możecie wdychać w danym rejonie powiatu Jarosławskiego.
                        Jak to zrobić? To proste! Wystarczy że wybierzesz czujnik z poniższej listy a nasza strona przedstawi Ci aktualny stan powietrza na wybranej przestrzeni czasu!
                    </p>

                    <form action="<?= ROOT_PATH ?>sensor" method="POST">
                        <div class="row">
                            <div class="col">
                                <select name="nazwa_czujnika" class="form-select">
                                    <?php $this->printSensorsList() ?>
                                </select>
                            </div>

                            <div class="col">
                                <button type="submit" class="btn btn-primary">Pokaż</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col p-4">
                    <div id="mapid" style="height: 30em;" class="p-3 border rounded"></div>
                </div>
            </div>
        </main>

        <footer class="border-top mt-auto p-3">
            <p class="text-muted">Wykonane przez: Grupa Czujniki</p>
        </footer>
    </div>

    <!-- Skrypty odpowiedzialne za mapę -->
    <script src="<?= JS_PATH ?>leaflet.js"></script>
    <script>
        var mymap = L.map('mapid').setView([50.015, 22.68], 14);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);
    </script>
</body>

</html>