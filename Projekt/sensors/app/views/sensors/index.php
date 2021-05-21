<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <title>Czujniki</title>
    <meta charset="UTF-8">

    <link rel="icon" href="<?= IMG_PATH ?>favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= CSS_PATH ?>bootstrap.css">
</head>

<body>
    <div class="container">
        <!-- Wyświetla tablicę z czujnikami -->
        <div class="p-4">
            <h3>Lista czujników</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Czujnika</th>
                            <th scope="col">Nazwa</th>
                            <th scope="col">Opis</th>
                            <th scope="col">Współrzędne</th>
                            <th scope="col">Wysokosc npm.</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php echo $this->printSensorsTable(); ?>
                    </tbody>
                </table>
        </div>

        <div class="row align-items-start p-4">
            <!-- Wyświetla formularz tworzenia nowego czujnika -->
            <div class="col">
                <h3>Dodawanie czujnika</h1>
                    <form action=" <?= ROOT_PATH ?>sensors/addSensor" method="POST" class="mb-3">
                        <input type="text" name="nazwa" class="form-control" placeholder="Nazwa"><br>
                        <input type="text" name="opis" class="form-control" placeholder="Opis"><br>
                        <input type="text" name="wspolrzedne" class="form-control" placeholder="Współrzędne"><br>
                        <input type="number" step="any" name="wysokosc_npm" class="form-control" placeholder="Wysokość npm."><br>

                        <button type="submit" class="btn btn-primary">Dodaj</button>
                    </form>
            </div>

            <!-- Wyświetla formularz usuwania czujnika -->
            <div class="col">
                <h3>Usuwanie czujnika</h1>
                    <form action="<?= ROOT_PATH ?>sensors/deleteSensor" method="POST">
                        <input type="number" name="id_czujnik" class="form-control" placeholder="ID czujnika"><br>

                        <button type="submit" class="btn btn-primary">Usuń</button>
                    </form>
            </div>

            <!-- Wyświetla formularz edycji czujnika -->
            <div class="col">
                <h3>Edytowanie czujnika</h1>
                    <form action=" <?= ROOT_PATH ?>sensors/editSensor" method="POST" class="mb-3">
                        <input type="number" name="edit_id_czujnik" class="form-control" placeholder="ID czujnika"><br>
                        <input type="text" name="edit_nazwa" class="form-control" placeholder="Nazwa"><br>
                        <input type="text" name="edit_opis" class="form-control" placeholder="Opis"><br>
                        <input type="text" name="edit_wspolrzedne" class="form-control" placeholder="Współrzędne"><br>
                        <input type="number" step="any" name="edit_wysokosc_npm" class="form-control" placeholder="Wysokość npm."><br>

                        <button type="submit" class="btn btn-primary">Edytuj</button>
                    </form>
            </div>
        </div>

        <div class="p-4">
            <h3>Parametry czujników</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Czujnik</th>
                        <th scope="col">Wilgotność</th>
                        <th scope="col">PM10</th>
                        <th scope="col">PM2.5</th>
                        <th scope="col">Temperatura</th>
                    </tr>
                </thead>

                <tbody>
                    <?php echo $this->printDataTable(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pobranie bieżącego parametru PM10 z czujnika S09 z bazy Influx -->
        <?php $this->getCurrentInfluxParameter("S09", "PM10") ?>

    </div>
    <script src="<?= JS_PATH ?>bootstrap.js"></script>
</body>

</html>