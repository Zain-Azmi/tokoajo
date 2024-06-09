// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Fungsi untuk mengambil data dari get_data.php
function loadData() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'function.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var data = JSON.parse(xhr.responseText);
                console.log('Data received:', data); // Debugging: Log data yang diterima

                if (data.error) {
                    console.error('Error:', data.error);
                    return;
                }

                var labels = data.map(function(item) { return item.bulan; });
                var totalPembelian = data.map(function(item) { return item.total_pembelian; });

                // Membuat diagram batang
                var ctx = document.getElementById("DiagramGaris").getContext("2d");
                var DiagramGaris = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Total Pembelian per Hari",
                            lineTension: 0.3,
                            backgroundColor: "rgba(2,117,216,0.2)",
                            borderColor: "rgba(2,117,216,1)",
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(2,117,216,1)",
                            pointBorderColor: "rgba(255,255,255,0.8)",
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(2,117,216,1)",
                            pointHitRadius: 50,
                            pointBorderWidth: 2,

                            data: totalPembelian,
                            
                        }],
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 10
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: Math.max.apply(null, totalPembelian) + 50000, // Sesuaikan maksimum dengan data
                                    maxTicksLimit: 5
                                },
                                gridLines: {
                                    display: true
                                }
                            }],
                        },
                        legend: {
                            display: false
                        }
                    }
                });
            } catch (e) {
                console.error('Failed to parse JSON:', e);
            }
        } else if (xhr.readyState === 4) {
            console.error('Failed to load data:', xhr.status, xhr.statusText);
        }
    };
    xhr.send();
}

// Memuat data setelah halaman selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadData();
});
