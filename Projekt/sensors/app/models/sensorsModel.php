<?php

use InfluxDB2\Client;

class SensorsModel
{
    private $database;
    private $client;
    private $bucket;
    private $queryApi;
    private $currentSensorName;

    public function __construct()
    {
        // Connecting the mySQL database
        $dbhost = 'localhost';
        $dbuser = 'SENSOR';
        $dbpass = 'haslosensora';
        $dbname = 'sensors';

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

    public function setCurrentSensorName($currentSensorName)
    {
        $this->currentSensorName = $currentSensorName;
    }

    public function getCurrentSensorName()
    {
        return $this->currentSensorName;
    }

    public function getInfluxParameter($sensorName, $parameter)
    {
        $query = "from(bucket: \"" . $this->bucket . "\")
        |> range(start: -1h)
        |> filter(fn: (r) => r[\"_measurement\"] == \"" . $sensorName . "\")
        |> filter(fn: (r) => r[\"_field\"] == \"" . $parameter . "\")
        |> last()";

        $result = $this->queryApi->query($query);

        return round($result[0]->records[0]->getValue());
    }

    // Zwraca wybrany parametr z aktualnie wybranego czujnika
    public function getCurrentInfluxParameter($parameter)
    {
        $query = "from(bucket: \"" . $this->bucket . "\")
        |> range(start: -1h)
        |> filter(fn: (r) => r[\"_measurement\"] == \"" . $this->currentSensorName . "\")
        |> filter(fn: (r) => r[\"_field\"] == \"" . $parameter . "\")
        |> last()";

        $result = $this->queryApi->query($query);

        return round($result[0]->records[0]->getValue());
    }

    public function jsonCurrentDay($parameter)
    {
        $startDate = date("Y-m-d") . "T00:00:00Z";
        $stopDate = date("Y-m-d") . "T" . date("H") . ":00:00Z";
        $chartArrayData = array();

        $query = "import \"date\"
            from(bucket: \"" . $this->bucket . "\")
             |> range(start: " . $startDate . ", stop: " . $stopDate . ")
             |> filter(fn: (r) => date.truncate(t: r._time, unit: 1d) == date.truncate(t: now(), unit: 1d))
             |> filter(fn: (r) => r[\"_measurement\"] == \"" . $this->currentSensorName . "\")
             |> filter(fn: (r) => r[\"_field\"] == \"" . $parameter . "\")
             |> aggregateWindow(every: 1h, fn: mean)
             |> hourSelection(start: 0, stop: 23)";
        $parser = $this->queryApi->queryStream($query);

        $i = 0;
        foreach ($parser->each() as $record) {
            $parameterValue = round($record->getValue($parameter));
            $chartArrayData[$i++] = $parameterValue;
        }

        array_pop($chartArrayData);
        return json_encode($chartArrayData);
    }

    public function addSensor($data)
    {
        $nazwa = $data['nazwa'];
        $opis = $data['opis'];
        $szerokosc = $data['szerokosc'];
        $dlugosc = $data['dlugosc'];
        $wysokosc_npm = $data['wysokosc_npm'];

        if (!empty($nazwa) && !empty($opis) && !empty($szerokosc) && !empty($dlugosc) && !empty($wysokosc_npm)) {
            $query = "INSERT INTO rejestr_czujnikow (id_czujnika, nazwa, opis, szerokosc, dlugosc, wysokosc_npm) 
                        VALUES (NULL, '$nazwa', '$opis', '$szerokosc', '$dlugosc','$wysokosc_npm');";
            $this->database->runQuery($query);

            header('Location: ' . ROOT_PATH . 'sensors');
        } else echo "Pola nie mogą być puste";
    }

    public function deleteSensor($id_czujnik)
    {
        if (!empty($id_czujnik)) {
            $query = "DELETE FROM rejestr_czujnikow WHERE id_czujnika=" . $id_czujnik . ";";
            $this->database->runQuery($query);

            header('Location: ' . ROOT_PATH . 'sensors');
        } else echo "Pole nie może być puste";
    }

    public function editSensor($data)
    {
        $parametry = "";
        $nazwa = $data['nazwa'];
        $opis = $data['opis'];
        $szerokosc = $data['szerokosc'];
        $dlugosc = $data['dlugosc'];
        $wysokosc_npm = $data['wysokosc_npm'];
        $id_czujnik = $data['id_czujnik'];

        if (!empty($id_czujnik)) {
            if (!empty($nazwa)) {
                $parametry .= "nazwa = \"" . $nazwa . "\",";
            }

            if (!empty($opis)) {
                $parametry .= "opis = \"" . $opis . "\",";
            }

            if (!empty($szerokosc)) {
                $parametry .= "szerokosc = \"" . $szerokosc . "\",";
            }

            if (!empty($dlugosc)) {
                $parametry .= "dlugosc = \"" . $dlugosc . "\",";
            }

            if (!empty($wysokosc_npm)) {
                $parametry .= "wysokosc_npm = " . $wysokosc_npm . ",";
            }

            $query = "UPDATE rejestr_czujnikow SET " . substr($parametry, 0, -1) . " WHERE rejestr_czujnikow.id_czujnika = " . $id_czujnik . ";";
            $this->database->runQuery($query);

            header('Location: ' . ROOT_PATH . 'sensors');
        } else echo "Pole nie może być puste";
    }

    public function printSensorsTable()
    {
        $query = "SELECT * FROM rejestr_czujnikow";
        $result = $this->database->runQuery($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_czujnika"] . "</td>" .
                    "<td>" . $row["nazwa"] . "</td>" .
                    "<td>" . $row["opis"] . "</td>" .
                    "<td>" . $row["szerokosc"] . "</td>" .
                    "<td>" . $row["dlugosc"] . "</td>" .
                    "<td>" . $row["wysokosc_npm"] . "</td>";
                echo "</tr>";
            }
        } else echo "Brak danych";
    }

    public function printDataTable()
    {
        $query = "SELECT * FROM rejestr_czujnikow";
        $result = $this->database->runQuery($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nazwa"] . "</td>" .
                    "<td>" . $this->getInfluxParameter($row["nazwa"], "Humid") . "</td>" .
                    "<td>" . $this->getInfluxParameter($row["nazwa"], "PM10") . "</td>" .
                    "<td>" . $this->getInfluxParameter($row["nazwa"], "PM25") . "</td>" .
                    "<td>" . $this->getInfluxParameter($row["nazwa"], "Temp") . "</td>";
                echo "</tr>";
            }
        } else echo "Brak danych";
    }

    public function printSensorsList()
    {
        $query = "SELECT * FROM rejestr_czujnikow";
        $result = $this->database->runQuery($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value=" . $row["nazwa"] . ">" . $row["nazwa"] . "</option>";
            }
        } else echo "Brak danych";
    }

    public function getSensorInfo($info)
    {
        $query = "SELECT $info FROM rejestr_czujnikow WHERE nazwa = \"" . $this->currentSensorName . "\"";
        return $this->database->runQuery($query)->fetch_array()[0] ?? '';
    }

    // Funkcja po uruchomieniu przepisuje dane średnie godzinne z dnia poprzedniego z bazy Influx do bazy MySQL
    public function toMySQL()
    {
        $startDate = date("Y-m-d", strtotime("-2 days")) . "T23:00:00Z";
        $stopDate = date("Y-m-d", strtotime("-1 days")) . "T23:00:00Z";

        foreach ($this->getSensors() as $id_czujnik => $sensorName) {
            $count = 0;

            $dataPM10 = array();
            $dataPM25 = array();
            $dataHumid = array();
            $dataTemp = array();
            $dateDate = array();

            $query = "import \"date\"
            from(bucket: \"" . $this->bucket . "\")
            |> range(start: " . $startDate . ", stop: " . $stopDate . ")
            |> filter(fn: (r) => r[\"_measurement\"] == \"" . $sensorName . "\")
            |> filter(fn: (r) => r[\"_field\"] == \"Humid\" or r[\"_field\"] == \"PM10\" or r[\"_field\"] == \"PM25\" or r[\"_field\"] == \"Temp\")
            |> aggregateWindow(every: 1h, fn: mean)";

            $parser = $this->queryApi->queryStream($query);

            foreach ($parser->each() as $record) {
                $date = $record->getTime();
                $date = str_replace("T", " ", substr($date, 0, -1));
                $data = round($record->getValue("_"));

                if ($count < 24) {
                    // Humid
                    array_push($dataHumid, $data);
                    array_push($dateDate, $date);
                } else if ($count < 24 * 2) {
                    // PM10
                    array_push($dataPM10, $data);
                } else if ($count < 24 * 3) {
                    // PM25
                    array_push($dataPM25, $data);
                } else if ($count < 24 * 4) {
                    // Temp
                    array_push($dataTemp, $data);
                }

                $count++;
            }

            for ($hour = 0; $hour <= 23; $hour++) {
                $this->addSqlRecord($id_czujnik, $dateDate[$hour], $dataHumid[$hour], $dataPM10[$hour], $dataPM25[$hour], $dataTemp[$hour]);
            }
        }
    }

    private function addSqlRecord($id_czujnik, $data, $pm2_5, $pm10, $wilgotnosc, $temperatura)
    {
        $query = "INSERT INTO dane_dzienne (id_czujnika, data, pm2_5, pm10, wilgotnosc, temperatura) 
        VALUES ('$id_czujnik', '$data', '$pm2_5', '$pm10', '$wilgotnosc', '$temperatura');";

        $this->database->runQuery($query);
    }

    private function getSensors()
    {
        $query = "SELECT * FROM rejestr_czujnikow";
        $result = $this->database->runQuery($query);
        $sensors = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sensors += [$row["id_czujnika"] => $row["nazwa"]];
            }
        } else echo "Brak danych";

        return $sensors;
    }
}
