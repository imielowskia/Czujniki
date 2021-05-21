<?php

use InfluxDB2\Client;

class Sensor
{
    private $database;
    private $client;
    private $bucket;
    private $queryApi;

    public function __construct()
    {
        // Connecting the mySQL database
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'czujniki';

        $this->database = new Database($dbhost, $dbuser, $dbpass, $dbname);

        // Connecting the influx database
        $token = 'uFBkGDJmzZRI1VQBKRgSlAsScRyhHamHmSopRDy2fFsANkEisxLUhGaAUcl0pkdJl6jYNX27_qdm2XXUa0EjnA==';
        $org = 'IIT';
        $this->bucket = 'Czujniki';

        $this->client = new Client([
            "url" => "http://89.188.221.231:8086",
            "token" => $token,
            "org" => $org,
            "bucket" => $this->bucket
        ]);

        $this->queryApi = $this->client->createQueryApi();
    }

    // Przesyła dane z wybranego zakresu ostatnich minut z bazy Influx do MySQL
    public function toMySQL($minutes, $id_czujnik, $nazwa_czujnika)
    {
        $query = "from(bucket: \"$this->bucket\")
        |> range(start: -" . $minutes . "m, stop: now())
        |> filter(fn: (r) => r[\"_measurement\"] == \"$nazwa_czujnika\")
        |> last()";

        $parser = $this->queryApi->queryStream($query);

        foreach ($parser->each() as $record) {
            $data = $record->getTime();
            $data = str_replace("T", " ", substr($data, 0, -1));
            $pm2_5 = $record->getValue("PM25");
            $pm10 = $record->getValue("PM10");
            $wilgotnosc = $record->getValue("Humid");
            $temperatura = $record->getValue("Temp");

            $this->addSqlRecord($id_czujnik, $data, $pm2_5, $pm10, $wilgotnosc, $temperatura);
        }
    }

    public function getCurrentInfluxParameter($nazwa_czujnika, $parametr)
    {
        $query = "from(bucket: \"$this->bucket\")
        |> range(start: -1h)
        |> filter(fn: (r) => r[\"_measurement\"] == \"$nazwa_czujnika\")
        |> filter(fn: (r) => r[\"_field\"] == \"$parametr\")
        |> last()
        |> toString()";

        $result = $this->queryApi->queryRaw($query);

        return substr($result, strrpos($result, ',') + 1);
    }

    public function addSensor($data)
    {
        $nazwa = $data['nazwa'];
        $opis = $data['opis'];
        $wspolrzedne = $data['wspolrzedne'];
        $wysokosc_npm = $data['wysokosc_npm'];

        if (!empty($nazwa) && !empty($opis) && !empty($wspolrzedne) && !empty($wysokosc_npm)) {
            $query = "INSERT INTO czujniki.rejestr_czujnikow (id_czujnika, nazwa, opis, wspolrzedne, wysokosc_npm) 
                        VALUES (NULL, '$nazwa', '$opis', '$wspolrzedne', '$wysokosc_npm');";
            $this->database->runQuery($query);

            header('Location: ' . ROOT_PATH . 'sensors');
        } else echo "Pola nie mogą być puste";
    }

    public function deleteSensor($id_czujnik)
    {
        if (!empty($id_czujnik)) {
            $query = "DELETE FROM czujniki.rejestr_czujnikow WHERE id_czujnika=" . $id_czujnik . ";";
            $this->database->runQuery($query);

            header('Location: ' . ROOT_PATH . 'sensors');
        } else echo "Pole nie może być puste";
    }

    public function editSensor($data)
    {
        $parametry = "";
        $nazwa = $data['nazwa'];
        $opis = $data['opis'];
        $wspolrzedne = $data['wspolrzedne'];
        $wysokosc_npm = $data['wysokosc_npm'];
        $id_czujnik = $data['id_czujnik'];

        if (!empty($id_czujnik)) {
            if (!empty($nazwa)) {
                $parametry .= "nazwa = \"" . $nazwa . "\",";
            }

            if (!empty($opis)) {
                $parametry .= "opis = \"" . $opis . "\",";
            }

            if (!empty($wspolrzedne)) {
                $parametry .= "wspolrzedne = \"" . $wspolrzedne . "\",";
            }

            if (!empty($wysokosc_npm)) {
                $parametry .= "wysokosc_npm = " . $wysokosc_npm . ",";
            }

            $query = "UPDATE czujniki.rejestr_czujnikow SET " . substr($parametry, 0, -1) . " WHERE rejestr_czujnikow.id_czujnika = " . $id_czujnik . ";";
            $this->database->runQuery($query);

            header('Location: ' . ROOT_PATH . 'sensors');
        } else echo "Pole nie może być puste";
    }

    public function printSensorsTable()
    {
        $query = "SELECT * FROM czujniki.rejestr_czujnikow";
        $result = $this->database->runQuery($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_czujnika"] . "</td>" .
                    "<td>" . $row["nazwa"] . "</td>" .
                    "<td>" . $row["opis"] . "</td>" .
                    "<td>" . $row["wspolrzedne"] . "</td>" .
                    "<td>" . $row["wysokosc_npm"] . "</td>";
                echo "</tr>";
            }
        } else echo "Brak danych";
    }

    public function printDataTable()
    {
        $query = "SELECT * FROM czujniki.rejestr_czujnikow";
        $result = $this->database->runQuery($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nazwa"] . "</td>" .
                    "<td>" . $this->getCurrentInfluxParameter($row["nazwa"], "Humid") . "</td>" .
                    "<td>" . $this->getCurrentInfluxParameter($row["nazwa"], "PM10") . "</td>" .
                    "<td>" . $this->getCurrentInfluxParameter($row["nazwa"], "PM25") . "</td>" .
                    "<td>" . $this->getCurrentInfluxParameter($row["nazwa"], "Temp") . "</td>";
                echo "</tr>";
            }
        } else echo "Brak danych";
    }

    private function addSqlRecord($id_czujnik, $data, $pm2_5, $pm10, $wilgotnosc, $temperatura)
    {
        $query = "INSERT INTO czujniki.dane_dzienne (id_czujnika, data, pm2_5, pm10, wilgotnosc, temperatura) 
        VALUES ('$id_czujnik', '$data', '$pm2_5', '$pm10', '$wilgotnosc', '$temperatura');";

        $this->database->runQuery($query);
    }
}
