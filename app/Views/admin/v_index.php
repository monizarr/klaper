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
            url: '<?= base_url("/siswa/angkatan-sekolah") ?>',
            method: 'GET',
            success: function(response) {
                // Example response structure:
                // {
                //     "SDN 1": {
                //         "2020": { "L": "1", "P": "1" },
                //         "2021": { "L": "2", "P": "1" }
                //     },
                //     "SDN 2": {
                //         "2020": { "L": "1" },
                //         "2022": { "P": "1" }
                //     }
                // }

                // Prepare data for the chart
                const labels = []; // Array to hold unique years
                const datasets = []; // Array to hold datasets for each school

                // Extract data from response
                for (const school in response) {
                    const schoolData = response[school];
                    const schoolDataset = {
                        label: school, // Label for the school
                        data: [], // Data array for the school
                        backgroundColor: getRandomColor(), // Generate random color
                        borderColor: getRandomColor(),
                        borderWidth: 1
                    };

                    // Process data for the school
                    for (const year in schoolData) {
                        // If the year is not already in labels, add it
                        if (!labels.includes(year)) {
                            labels.push(year);
                        }

                        // Calculate total students (L + P) for the year
                        const yearData = schoolData[year];
                        const totalStudents = (parseInt(yearData.L || 0) + parseInt(yearData.P || 0));

                        // Add the total to the school dataset
                        schoolDataset.data.push(totalStudents);
                    }

                    // Add the dataset for the school
                    datasets.push(schoolDataset);
                }

                // Sort labels (years) in ascending order
                labels.sort();

                // Create the chart
                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels, // Years as labels
                        datasets: datasets // School datasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                },
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

        // Helper function to generate random colors
        function getRandomColor() {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            return `rgba(${r}, ${g}, ${b}, 0.5)`; // Semi-transparent color
        }
    });
</script>