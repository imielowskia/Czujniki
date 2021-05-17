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
                            <th scope="col">id_czujnika</th>
                            <th scope="col">nazwa</th>
                            <th scope="col">opis</th>
                            <th scope="col">wspolrzedne</th>
                            <th scope="col">wysokosc_npm</th>
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
                <h3>Nowy czujnik</h1>
                    <form action=" <?= ROOT_PATH ?>sensors/addSensor" method="POST" class="mb-3">
                        <input type="text" name="nazwa" class="form-control" placeholder="Nazwa"><br>
                        <input type="text" name="opis" class="form-control" placeholder="Opis"><br>
                        <input type="text" name="wspolrzedne" class="form-control" placeholder="Współrzędne"><br>
                        <input type="text" name="wysokosc_npm" class="form-control" placeholder="Wysokość npm."><br>

                        <button type="submit" class="btn btn-primary">Dodaj</button>
                    </form>
            </div>

            <!-- Wyświetla formularz usuwania czujnika -->
            <div class="col">
                <h3>Usuń czujnik</h1>
                    <form action="<?= ROOT_PATH ?>sensors/deleteSensor" method="POST">
                        <input type="number" name="id_czujnik" class="form-control" placeholder="ID czujnika"><br>

                        <button type="submit" class="btn btn-primary">Usuń</button>
                    </form>
            </div>
        </div>

    </div>
    <script src="<?= JS_PATH ?>bootstrap.js"></script>
</body>

</html>