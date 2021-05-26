// TODO: dodać aktualizowanie zawartości wykresów przy zmianie zakresu czasu, dodać wczytywanie danych z bieżącego dnia

// 1: wilgotność, 2: temperatura, 3: pm10, 4: pm2.5
var parameterID = document.getElementById("ChartParameter");
var parameterValue = parameterID.options[parameterID.selectedIndex].value;

// 1: średnie godzinne w bieżącym dniu, 2: średnie dzienne w bieżącym tygodniu, 3: średnie tygodniowe w bieżącym miesiącu
var timeRangeID = document.getElementById("ChartTimeRange");
var timeRangeValue = timeRangeID.options[timeRangeID.selectedIndex].value;

// wykresy
var humidCanvas = document.getElementById('humidChart').getContext('2d');
var tempCanvas = document.getElementById('tempChart').getContext('2d');
var pm10Canvas = document.getElementById('pm10Chart').getContext('2d');
var pm25Canvas = document.getElementById('pm25Chart').getContext('2d');

var humidChart, tempChart, pm10Chart, pm25Chart;

drawChart();

function updateChart() {
    timeRangeValue = timeRangeID.options[timeRangeID.selectedIndex].value;
    parameterValue = parameterID.options[parameterID.selectedIndex].value;

    openChart();
    removeData(humidCanvas);
    removeData(tempCanvas);
    removeData(pm10Canvas);
    removeData(pm25Canvas);
}

function openChart() {
    var charts;
    charts = document.getElementsByClassName("chart");

    for (var i = 0; i < charts.length; i++) {
        charts[i].style.display = "none";
    }

    charts[parameterValue - 1].style.display = "block";
}

function drawChart() {
    humidChart = new Chart(humidCanvas, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Wilgotność',
                data: [1],
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

    tempChart = new Chart(tempCanvas, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Temperatura',
                data: [2],
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

    pm10Chart = new Chart(pm10Canvas, {
        type: 'line',
        data: {
            datasets: [{
                label: 'PM10',
                data: [3],
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

    pm25Chart = new Chart(pm25Canvas, {
        type: 'line',
        data: {
            datasets: [{
                label: 'PM2.5',
                data: [4],
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
}

function removeData(chart) {
    chart.data.labels.pop();

    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });

    chart.update();
}