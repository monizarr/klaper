<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Overview
                </div>
                <h2 class="page-title">
                    Dashboard Sekolah
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Fetch data from the API
        $.ajax({
            url: '<?= base_url('/siswa/angkatan-sekolah') ?>',
            method: 'GET',
            success: function(response) {
                // Process data to group by 'masuk'
                const yearCounts = {};
                response.forEach(siswa => {
                    const year = siswa.masuk;
                    if (year) {
                        yearCounts[year] = (yearCounts[year] || 0) + 1;
                    }
                });

                // Prepare data for Chart.js
                const labels = Object.keys(yearCounts);
                const data = Object.values(yearCounts);

                // Create the chart
                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Siswa per Tahun Masuk',
                            data: data,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Siswa'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tahun Masuk'
                                }
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    });
</script>