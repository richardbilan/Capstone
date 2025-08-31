@extends('layouts.layout')
@section('hideSidebar', true)

@section('title', 'Ilawod Barangay - Demographic Data')

@section('additional_styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
    <style>
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
    </style>
@endsection

@section('additional_scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableViewBtn = document.getElementById('tableViewBtn');
        const chartViewBtn = document.getElementById('chartViewBtn');
        const downloadInfo = document.getElementById('downloadInfo');
        const chartView = document.getElementById('chartView');
        const downloadCsvBtn = document.getElementById('downloadCsvBtn');

        let charts = {};

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
    });
    </script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ilawod Barangay - Demographic Data</h2>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Home
        </a>
    </div>

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
@endsection
