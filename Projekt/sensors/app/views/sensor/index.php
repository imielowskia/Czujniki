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

<?php if (isset($_SESSION['sensorName'])) : ?>
    <?php
    $humidData = $this->jsonCurrentDay("Humid");
    $tempData = $this->jsonCurrentDay("Temp");
    ?>

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
                        <h2 class="fw-light">Bieżące parametry czujnika <?php echo $this->getCurrentSensorName() ?></h2>
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
                                <select id="ChartParameter" class="form-select mb-3" onclick="updateChart()">
                                    <option value="1">Wilgotność</option>
                                    <option value="2">Temperatura</option>
                                    <option value="3">PM10</option>
                                    <option value="4">PM2.5</option>
                                </select>
                            </div>

                            <div class="col">
                                <p class="m-0">Wybierz zakres czasu:</p>
                                <select id="ChartTimeRange" class="form-select" onclick="updateChart()">
                                    <option value="1">Wykres dzienny</option>
                                    <option value="2">Wykres tygodniowy</option>
                                    <option value="3">Wykres miesięczny</option>
                                </select>
                            </div>
                        </div>
                        <canvas id="humidChart" class="chart" style="display: block;"></canvas>
                        <canvas id="tempChart" class="chart" style="display: none;"></canvas>
                        <canvas id="pm10Chart" class="chart" style="display: none;"></canvas>
                        <canvas id="pm25Chart" class="chart" style="display: none;"></canvas>
                    </div>
                </div>
            </main>

            <footer class="border-top mt-auto p-3">
                <p class="text-muted">Wykonane przez: Grupa Czujniki</p>
            </footer>
        </div>

        <!-- Skrypty odpowiedzialne za wykresy -->
        <script>
            // dzienne
            var jsonDayHumid = <?php echo $this->jsonCurrentDay("Humid"); ?>;
            var jsonDayTemp = <?php echo $this->jsonCurrentDay("Temp"); ?>;
            var jsonDayPM10 = <?php echo $this->jsonCurrentDay("PM10"); ?>;
            var jsonDayPM25 = <?php echo $this->jsonCurrentDay("PM25"); ?>;

            // tygodniowe
            var jsonWeekNightHumid = <?php echo $this->getWeeklyAvgValues("wilgotnosc", 0) ?>;
            var jsonWeekNightTemp = <?php echo $this->getWeeklyAvgValues("temperatura", 0) ?>;
            var jsonWeekNightPM10 = <?php echo $this->getWeeklyAvgValues("pm10", 0) ?>;
            var jsonWeekNightPM25 = <?php echo $this->getWeeklyAvgValues("pm2_5", 0) ?>;

            var jsonWeekDayHumid = <?php echo $this->getWeeklyAvgValues("wilgotnosc", 1) ?>;
            var jsonWeekDayTemp = <?php echo $this->getWeeklyAvgValues("temperatura", 1) ?>;
            var jsonWeekDayPM10 = <?php echo $this->getWeeklyAvgValues("pm10", 1) ?>;
            var jsonWeekDayPM25 = <?php echo $this->getWeeklyAvgValues("pm2_5", 1) ?>;

            // miesięczne
            var jsonMonthHumid;
            var jsonMonthTemp;
            var jsonMonthPM10;
            var jsonMonthPM25;
        </script>
        <script src="<?= JS_PATH ?>chart.js"></script>
        <script src="<?= JS_PATH ?>views/sensor.js"></script>
    </body>
<?php endif ?>

</html>
