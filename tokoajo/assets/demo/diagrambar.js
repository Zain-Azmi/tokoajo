// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Fungsi untuk mengambil data dari get_data.php
// Fungsi untuk mengambil data dari get_data.php
function loadData() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'ambildata.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var data_combined = JSON.parse(xhr.responseText);
                console.log('Data received:', data_combined); // Debugging: Log data yang diterima

                // Menggunakan data bulan dari data_combined
                var bulanData = data_combined.bulan;

                var labels = bulanData.map(function(item) { return item.bulan; });
                var totalPembelian = bulanData.map(function(item) { return item.total_pembelian; });

                // Membuat diagram batang
                var ctx = document.getElementById("DiagramBar").getContext("2d");
                var DiagramBar = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Total Pembelian per Bulan",
                            backgroundColor: "rgba(2,117,216,1)",
                            borderColor: "rgba(2,117,216,1)",
                            data: totalPembelian,
                            fill:true
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
