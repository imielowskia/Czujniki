// 1: wilgotność, 2: temperatura, 3: pm10, 4: pm2.5
var parameterID = document.getElementById("ChartParameter");

// 1: średnie godzinne w bieżącym dniu, 2: średnie dzienne w bieżącym tygodniu, 3: średnie tygodniowe w bieżącym miesiącu
var timeRangeID = document.getElementById("ChartTimeRange");

var humidCanvas = document.getElementById('humidChart').getContext('2d');
var tempCanvas = document.getElementById('tempChart').getContext('2d');
var pm10Canvas = document.getElementById('pm10Chart').getContext('2d');
var pm25Canvas = document.getElementById('pm25Chart').getContext('2d');

var humidChart, tempChart, pm10Chart, pm25Chart;

updateChart();

function updateChart() {
    timeRangeValue = parseInt(timeRangeID.options[timeRangeID.selectedIndex].value);
    parameterValue = parseInt(parameterID.options[parameterID.selectedIndex].value);
    openChart();

    switch (parameterValue) {
        case 1:
            if (humidChart != null) humidChart.destroy();
            humidChart = createChart(humidCanvas, "Wilgotność");
            break;
        case 2:
            if (tempChart != null) tempChart.destroy();
            tempChart = createChart(tempCanvas, "Temperatura");
            break;
        case 3:
            if (pm10Chart != null) pm10Chart.destroy();
            pm10Chart = createChart(pm10Canvas, "PM10");
            break;
        case 4:
            if (pm25Chart != null) pm25Chart.destroy();
            pm25Chart = createChart(pm25Canvas, "PM2.5");
            break;
    }
}

function openChart() {
    var charts;
    charts = document.getElementsByClassName("chart");

    for (var i = 0; i < charts.length; i++) {
        charts[i].style.display = "none";
    }

    charts[parameterValue - 1].style.display = "block";
}

function createChart(chartCanvas, label) {
    var labels, data, dataDay, dataNight;
    var jsonHumid, jsonTemp, jsonPM10, jsonPM25;
    var jsonHumidNight, jsonTempNight, jsonPM10Night, jsonPM25Night;
    var jsonHumidDay, jsonTempDay, jsonPM10Day, jsonPM25Day;

    switch (timeRangeValue) {
        case 1:
            labels = ['01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'];
            jsonHumid = jsonDayHumid;
            jsonTemp = jsonDayTemp;
            jsonPM10 = jsonDayPM10;
            jsonPM25 = jsonDayPM25;
            break;

        case 2:
            labels = ['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela'];
            jsonHumidNight = jsonWeekNightHumid;
            jsonTempNight = jsonWeekNightTemp;
            jsonPM10Night = jsonWeekNightPM10;
            jsonPM25Night = jsonWeekNightPM25;

            jsonHumidDay = jsonWeekDayHumid;
            jsonTempDay = jsonWeekDayTemp;
            jsonPM10Day = jsonWeekDayPM10;
            jsonPM25Day = jsonWeekDayPM25;
            break;

        case 3:
            labels = ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
            jsonHumid = jsonMonthHumid;
            jsonTemp = jsonMonthTemp;
            jsonPM10 = jsonMonthPM10;
            jsonPM25 = jsonMonthPM25;
            break;
    }

    switch (parameterValue) {
        case 1:
            data = jsonHumid;
            dataDay = jsonHumidDay;
            dataNight = jsonHumidNight;
            break;

        case 2:
            data = jsonTemp;
            dataDay = jsonTempDay;
            dataNight = jsonTempNight;
            break;

        case 3:
            data = jsonPM10;
            dataDay = jsonPM10Day;
            dataNight = jsonPM10Night;
            break;

        case 4:
            data = jsonPM25;
            dataDay = jsonPM25Day;
            dataNight = jsonPM25Night;
            break;
    }

    switch (timeRangeValue) {
        case 2:
            return new Chart(chartCanvas, {
                type: "bar",
                data: {
                    datasets: [{
                        /* wartosci dla dnia */
                        data: dataDay,
                        label: "Dzień",
                        backgroundColor: [
                            'rgba(245, 221, 66, 0.25)'
                        ],
                        borderColor: [
                            'rgba(245, 221, 66, 0.75)'
                        ],

                    }, {
                        /* wartosci dla nocy */
                        data: dataNight,
                        label: "Noc",
                        backgroundColor: [
                            'rgba(10, 88, 202, 0.25)'
                        ],
                        borderColor: [
                            'rgba(10, 88, 202, 0.75)'
                        ],
                    }],
                    labels: labels,
                },
                options: {
                    scales: {},
                },
            });

        default:
            return new Chart(chartCanvas, {
                type: 'line',
                data: {
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: [
                            'rgba(10, 88, 202, 0.25)'
                        ],
                        borderColor: [
                            'rgba(10, 88, 202, 0.75)'
                        ],
                        borderWidth: 2,
                        responsive: true,
                        maintainAspectRatio: false,
                        fill: 'origin',
                        tension: 0.5
                    }],
                    labels: labels
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
    }
}
