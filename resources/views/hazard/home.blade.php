
@extends('layouts.app')
@section('hideSidebar', true)

@section('content')
<style>
    .content-wrapper {
        padding-top: 48px;
        width: 100%;
        height: calc(100vh - 48px);
        background-color: #f8f9fa;
        overflow-y: auto;
    }

    /* Banner section */
    .banner-section {
        background: #0066cc;
        padding: 0.75rem;
        height: auto;
        max-height: 30vh;
    }

    .banner-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .banner-text {
        color: white;
        flex: 1;
    }

    .banner-title {
        font-size: min(1.1rem, 3vw);
        font-weight: bold;
        margin-bottom: 0.25rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .banner-subtitle {
        font-size: min(0.85rem, 2.5vw);
        opacity: 0.9;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .banner-image {
        width: min(100px, 20vw);
        height: auto;
        border-radius: 6px;
        object-fit: cover;
    }

    /* Types of Disaster Button */
    .disaster-btn {
        background-color: #0066cc;
        color: white;
        border: 1px solid white;
        padding: 0.35rem 0.75rem;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: min(0.85rem, 2.5vw);
    }

    .disaster-btn:hover {
        background-color: white;
        color: #0066cc;
    }

    /* Overview Cards */
    .overview-container {
        max-width: 1200px;
        margin: 0.75rem auto;
        padding: 0 0.75rem;
        height: calc(70vh - 48px);
        overflow-y: auto;
    }

    .overview-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 0.75rem;
        color: #333;
    }

    .alert-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        height: auto;
        margin-bottom: 0.75rem;
    }

    .alert-header {
        padding: 0.5rem 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .alert-header.danger {
        background-color: #dc3545;
        color: white;
    }

    .alert-header.warning {
        background-color: #ffc107;
        color: #000;
    }

    .alert-body {
        padding: 0.75rem;
    }

    .alert-title {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.35rem;
        font-size: 0.9rem;
    }

    .alert-time {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .alert-description {
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        color: #333;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: normal;
        margin-right: 0.35rem;
    }

    .badge-medical {
        background-color: #17a2b8 !important;
        color: white;
    }

    /* Grid adjustments */
    .row {
        margin-right: -0.375rem;
        margin-left: -0.375rem;
    }

    .col-md-6 {
        padding-right: 0.375rem;
        padding-left: 0.375rem;
    }

    /* Ilawod styles */
    .view-toggle {
        margin-bottom: 20px;
    }
    .stats-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .stats-number {
        font-size: 2rem;
        font-weight: bold;
        color: #0066cc;
    }
    .download-info {
        background: #e3f2fd;
        border: 1px solid #2196f3;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        text-align: center;
    }
    .download-btn {
        background: #2196f3;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .download-btn:hover {
        background: #1976d2;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .banner-section {
            max-height: 35vh;
        }

        .banner-container {
            flex-direction: column;
            text-align: center;
        }

        .banner-image {
            width: 80px;
            margin: 0.5rem auto 0;
        }

        .overview-container {
            height: calc(65vh - 48px);
        }

        .alert-title {
            flex-direction: column;
            gap: 0.25rem;
        }
    }

    @media (max-width: 576px) {
        .content-wrapper {
            height: 100vh;
        }

        .banner-section {
            padding: 0.5rem;
        }

        .overview-container {
            padding: 0 0.5rem;
            margin: 0.5rem auto;
        }

        .alert-card {
            margin-bottom: 0.5rem;
        }
    }
</style>

<div class="content-wrapper">
    <!-- Banner Section -->
    <div class="banner-section">
        <div class="banner-container">
            <div class="banner-text">
                <h1 class="banner-title">GIS-Based Disaster Risk Mapping for identifying Disaster Prone Areas in Brgy. Ilawod, Camalig, Albay.</h1>
                <p class="banner-subtitle">Stay informed and prepared for natural disasters with real-time alerts and comprehensive hazard mapping.</p>
                <button class="disaster-btn" id="showDisasterTypesBtn">
                    <i class="fas fa-layer-group"></i>
                    Types of Disaster
                </button>
            </div>
            <img src="{{ asset('assets/img/disaster_banner.jpg') }}" alt="Disaster Banner" class="banner-image">
        </div>
    </div>

    <!-- Disaster Types Section (Initially Hidden) -->
    <div id="disasterTypesSection" style="display: none;">
        <div class="overview-container">
            <h2 class="overview-title">Common Disaster Types</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="alert-card">
                        <div class="alert-header danger"><i class="fas fa-house-damage"></i> Earthquake</div>
                        <div class="alert-body">
                            <p class="alert-description">Sudden shaking of the ground caused by the passage of seismic waves through Earth's rocks.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="alert-card">
                        <div class="alert-header warning"><i class="fas fa-cloud-showers-heavy"></i> Flood</div>
                        <div class="alert-body">
                            <p class="alert-description">An overflow of a large amount of water beyond its normal limits, especially over what is normally dry land.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="alert-card">
                        <div class="alert-header danger"><i class="fas fa-wind"></i> Typhoon / Hurricane</div>
                        <div class="alert-body">
                            <p class="alert-description">A mature tropical cyclone that develops between 180° and 100°E in the Northern Hemisphere.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="alert-card">
                        <div class="alert-header warning"><i class="fas fa-fire"></i> Fire</div>
                        <div class="alert-body">
                            <p class="alert-description">A process in which substances combine chemically with oxygen from the air and typically give out bright light, heat, and smoke.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="alert-card">
                        <div class="alert-header danger"><i class="fas fa-volcano"></i> Volcanic Eruption</div>
                        <div class="alert-body">
                            <p class="alert-description">The expulsion of gases, rock fragments, and molten lava from a volcano.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="alert-card">
                        <div class="alert-header warning"><i class="fas fa-smog"></i> Landslide</div>
                        <div class="alert-body">
                            <p class="alert-description">The movement of a mass of rock, debris, or earth down a slope.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Section -->
    <div class="overview-container">
        <h2 class="overview-title">Disaster Risk Overview</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="alert-card">
                    <div class="alert-header danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        Active Alerts
                    </div>
                    <div class="alert-body">
                        <div class="alert-title">
                            <strong>Flood Watch</strong>
                            <span class="alert-time">1 minute ago</span>
                        </div>
                        <p class="alert-description">
                            Increased water levels in the Ilawod River due to rainfall. Residents should prepare for possible evacuation.
                        </p>
                        <div>
                            <span class="badge bg-primary">Missing</span>
                            <span class="badge badge-medical">Medical</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert-card">
                    <div class="alert-header warning">
                        <i class="fas fa-exclamation-circle"></i>
                        High Risk Areas
                    </div>
                    <div class="alert-body">
                        <div class="alert-title">
                            <strong>Ilawod RiverBank Area</strong>
                            <span class="badge bg-danger">High Risk</span>
                        </div>
                        <p class="alert-description">
                            Highly flood prone areas with historical flood depths 1-2 meters during typhoons.
                        </p>
                        <div>
                            <span class="badge bg-primary">Missing</span>
                            <span class="badge badge-medical">Medical</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barangay Selection Buttons -->
        <div class="mt-4">
            <!-- ILAWOD DEMOGRAPHIC SECTION START -->
            <h3 class="overview-title">Ilawod Barangay - Demographic Data</h3>
            <div class="container-fluid px-0">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stats-card text-center">
                            <div class="stats-number">3,825</div>
                            <div class="text-muted">Total Population</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card text-center">
                            <div class="stats-number">853</div>
                            <div class="text-muted">No. of Households</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card text-center">
                            <div class="stats-number">1,126</div>
                            <div class="text-muted">No. of Families</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card text-center">
                            <div class="stats-number">138</div>
                            <div class="text-muted">PWD (89 F, 49 M)</div>
                        </div>
                    </div>
                </div>

                <div class="view-toggle">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary" id="tableViewBtn">
                            <i class="fas fa-download me-2"></i>Download CSV Data
                        </button>
                        <button type="button" class="btn btn-primary" id="chartViewBtn">Visualization View</button>
                    </div>
                </div>

                <div id="downloadInfo" class="download-info" style="display: none;">
                    <h5><i class="fas fa-info-circle me-2"></i>CSV Download</h5>
                    <p>Click the button below to download the complete demographic and household data for Ilawod Barangay in CSV format.</p>
                    <button class="download-btn" id="downloadCsvBtn">
                        <i class="fas fa-file-csv me-2"></i>Download Demographic Data CSV
                    </button>
                    <div class="mt-3">
                        <small class="text-muted">
                            The CSV file includes: Demographic data by Sitio/Purok, PWD details, and Household data.
                        </small>
                    </div>
                </div>

                <div id="chartView">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header"><h5>Population by Age Group</h5></div>
                                <div class="card-body"><canvas id="ageGroupChart"></canvas></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header"><h5>Household Types Distribution</h5></div>
                                <div class="card-body"><canvas id="householdChart"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header"><h5>Population by Sitio/Purok</h5></div>
                                <div class="card-body"><canvas id="sitioChart"></canvas></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header"><h5>PWD by Type</h5></div>
                                <div class="card-body"><canvas id="pwdChart"></canvas></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ILAWOD DEMOGRAPHIC SECTION END -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showDisasterTypesBtn = document.getElementById('showDisasterTypesBtn');
        const disasterTypesSection = document.getElementById('disasterTypesSection');

        if (showDisasterTypesBtn && disasterTypesSection) {
            showDisasterTypesBtn.addEventListener('click', function() {
                if (disasterTypesSection.style.display === 'none') {
                    disasterTypesSection.style.display = 'block';
                    disasterTypesSection.scrollIntoView({ behavior: 'smooth' });
                } else {
                    disasterTypesSection.style.display = 'none';
                }
            });
        }

        // Ilawod Demographic JS
        const tableViewBtn = document.getElementById('tableViewBtn');
        const chartViewBtn = document.getElementById('chartViewBtn');
        const downloadInfo = document.getElementById('downloadInfo');
        const chartView = document.getElementById('chartView');
        const downloadCsvBtn = document.getElementById('downloadCsvBtn');

        let charts = {};

        if (chartView && downloadInfo && tableViewBtn && chartViewBtn && downloadCsvBtn) {
            chartView.style.display = 'block';
            downloadInfo.style.display = 'none';

            tableViewBtn.addEventListener('click', function() {
                downloadInfo.style.display = 'block';
                chartView.style.display = 'none';
                tableViewBtn.classList.add('btn-primary');
                tableViewBtn.classList.remove('btn-outline-primary');
                chartViewBtn.classList.add('btn-outline-primary');
                chartViewBtn.classList.remove('btn-primary');
            });

            chartViewBtn.addEventListener('click', function() {
                downloadInfo.style.display = 'none';
                chartView.style.display = 'block';
                chartViewBtn.classList.add('btn-primary');
                chartViewBtn.classList.remove('btn-outline-primary');
                tableViewBtn.classList.add('btn-outline-primary');
                tableViewBtn.classList.remove('btn-primary');

                if (Object.keys(charts).length === 0) {
                    initializeCharts();
                }
            });

            downloadCsvBtn.addEventListener('click', function() {
                const csvContent = generateCSV();
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'ilawod_demographic_data.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });

            function generateCSV() {
                let csv = 'Category,Subcategory,Male,Female,Total\n';

                // Age Group
                csv += 'Age Group,Infants (0-11 mos),14,26,40\n';
                csv += 'Age Group,Children (17 & below),508,533,1041\n';
                csv += 'Age Group,Adults (18-59),1249,1097,2346\n';
                csv += 'Age Group,Elderly (60+),0,0,0\n\n';

                // Household Types
                csv += 'Household Type,Concrete,, ,343\n';
                csv += 'Household Type,Semi-Concrete,, ,276\n';
                csv += 'Household Type,Light-weight,, ,134\n';
                csv += 'Household Type,Salvaged house,, ,100\n\n';

                // Sitio Population
                csv += 'Sitio,1,, ,473\n';
                csv += 'Sitio,2,, ,693\n';
                csv += 'Sitio,3,, ,700\n';
                csv += 'Sitio,4,, ,645\n';
                csv += 'Sitio,5,, ,939\n';
                csv += 'Sitio,Relocation,, ,375\n\n';

                // PWD Types
                csv += 'PWD Type,Pandinig,, ,20\n';
                csv += 'PWD Type,Pananalita,, ,12\n';
                csv += 'PWD Type,Paningin,, ,17\n';
                csv += 'PWD Type,Pagiisip,, ,21\n';
                csv += 'PWD Type,Autism,, ,6\n';
                csv += 'PWD Type,Physical Skills,, ,25\n';
                csv += 'PWD Type,Others,, ,37\n';

                return csv;
            }

            function initializeCharts() {
                const ageCtx = document.getElementById('ageGroupChart').getContext('2d');
                charts.ageGroup = new Chart(ageCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Infants (0-11 mos)', 'Children (17 & below)', 'Adults (18-59)', 'Elderly (60+)'],
                        datasets: [
                            {
                                label: 'Male',
                                data: [14, 508, 1249, 0],
                                backgroundColor: '#0066cc'
                            },
                            {
                                label: 'Female',
                                data: [26, 533, 1097, 0],
                                backgroundColor: '#66b3ff'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                const householdCtx = document.getElementById('householdChart').getContext('2d');
                charts.household = new Chart(householdCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Concrete', 'Semi-Concrete', 'Light-weight', 'Salvaged house'],
                        datasets: [{
                            data: [343, 276, 134, 100],
                            backgroundColor: ['#0066cc', '#66b3ff', '#99ccff', '#ccddff']
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });

                const sitioCtx = document.getElementById('sitioChart').getContext('2d');
                charts.sitio = new Chart(sitioCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Sitio 1', 'Sitio 2', 'Sitio 3', 'Sitio 4', 'Sitio 5', 'Relocation'],
                        datasets: [{
                            label: 'Population',
                            data: [473, 693, 700, 645, 939, 375],
                            backgroundColor: '#0066cc'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                const pwdCtx = document.getElementById('pwdChart').getContext('2d');
                charts.pwd = new Chart(pwdCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Pandinig', 'Pananalita', 'Paningin', 'Pagiisip', 'Autism', 'Physical Skills', 'Others'],
                        datasets: [{
                            data: [20, 12, 17, 21, 6, 25, 37],
                            backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40', '#ff6384']
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }

            initializeCharts();
        }
    });

    function navigateToBarangay(barangay) {
        window.location.href = '/' + barangay;
    }
</script>
@endsection