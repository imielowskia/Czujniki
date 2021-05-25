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
                        <canvas id="myChart"></canvas>
                        <select name="Wykres" class="form-select">
                            <option value="1">Wykres dzienny</option>
                            <option value="2">Wykres tygodniowy</option>
                            <option value="3">Wykres miesięczny</option>
                        </select>
                    </div>
                </div>
            </main>

            <footer class="border-top mt-auto p-3">
                <p class="text-muted">Wykonane przez: Grupa Czujniki</p>
            </footer>
        </div>

        <!-- Skrypty odpowiedzialne za wykresy -->
        <script src="<?= JS_PATH ?>chart.js"></script>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
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