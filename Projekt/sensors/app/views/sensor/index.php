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
<?php if (isset($_SESSION['nazwa_czujnika'])) : ?>

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
                <div class="row row-cols-1 row-cols-lg-2 align-items-center">
                    <div class="col p-4">
                        <h2 class="fw-light">Bieżące parametry czujnika <?php echo $this->getCurrentSensor() ?></h2>
                        <p class="lead text-muted"><?php echo $this->getSensorInfo("opis") ?></p>
                        <table class="table">
                            <tr>
                                <th scope="row">Wilgotność</th>
                                <td><?php echo $this->getCurrentInfluxParameter("Humid") ?></td>
                            </tr>
                            <tr>
                                <th scope="row">PM10</th>
                                <td><?php echo $this->getCurrentInfluxParameter("PM10") ?></td>
                            </tr>
                            <tr>
                                <th scope="row">PM2.5</th>
                                <td><?php echo $this->getCurrentInfluxParameter("PM25") ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Temperatura</th>
                                <td><?php echo $this->getCurrentInfluxParameter("Temp") ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col p-4">
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p class="m-0">Wybierz parametr:</p>
                                <select name="Wykres_typ" class="form-select mb-3">
                                    <option value="1">Wilgotność</option>
                                    <option value="2">Temperatura</option>
                                    <option value="3">PM10</option>
                                    <option value="4">PM2.5</option>
                                </select>
                            </div>

                            <div class="col">
                                <p class="m-0">Wybierz zakres czasu:</p>
                                <select name="Wykres_okres" class="form-select">
                                    <option value="1">Wykres dzienny</option>
                                    <option value="2">Wykres tygodniowy</option>
                                    <option value="3">Wykres miesięczny</option>
                                </select>
                            </div>
                        </div>

                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </main>

            <footer class="border-top mt-auto p-3">
                <p class="text-muted">Wykonane przez: Grupa Czujniki</p>
            </footer>
        </div>

        <!-- Skrypty odpowiedzialne za wykresy -->
        <!--
            Należy stworzyć 4 wykresy dla poszczególnych parametrów + 3 zakresy czasowe,
            znaczniki canvas o określonych "id" powinny być aktualizowane przy wyborze parametru oraz zakresu czasu
            z list "select" o nazwie "Wykres_czasu" oraz "Wykres_typ"
        -->
        <script src="<?= JS_PATH ?>chart.js"></script>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: ' pm10',
                        data: [1, 4, 3, 5, 2, 3, 6, 7, 20],
                        backgroundColor: [
                            'rgba(68, 193, 193, 0.2)'
                        ],
                        borderColor: [
                            'rgba(68, 193, 193, 1)'
                        ],
                        borderWidth: 2,
                        responsive: true,
                        maintainAspectRatio: false,
                        fill: 'origin',
                        tension: 0.5
                    }, {
                        label: 'pm2,5',
                        data: [3, 6, 9, 5, 6, 12, 3, 1, 3, 4],
                        backgroundColor: [
                            'rgba(219, 52, 235, 0.2)'
                        ],
                        borderColor: [
                            'rgba(219, 52, 235, 1)'
                        ],
                        borderWidth: 2,
                        responsive: true,
                        maintainAspectRatio: false,
                        fill: 'origin',
                        tension: 0.5

                    }],
                    labels: ['0:00', '1:00', '2:00', '3:00', '4:00', '5:00', '6:00', '7:00', '8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00']
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

    </body>
<?php endif ?>

</html>