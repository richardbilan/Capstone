@extends('layouts.user')

@section('content')
<div class="card disaster-card">
    <div class="card-header">
        <h5 class="card-title mb-0"><i class="fas fa-home me-2"></i>Evacuation Centers</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="center-card mb-3 p-3 border rounded">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-1"><i class="fas fa-school me-2 text-primary"></i>Barangay Ilawod Elementary School</h6>
                            <p class="mb-1 text-muted small">Capacity: 200 | Current: 45</p>
                            <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-1"></i>Main Road, Purok 2</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-success mb-2">OPEN</span><br>
                            <button class="btn btn-sm btn-outline-primary">View Details</button>
                        </div>
                    </div>
                </div>

                <div class="center-card mb-3 p-3 border rounded">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-1"><i class="fas fa-building me-2 text-primary"></i>Barangay Hall</h6>
                            <p class="mb-1 text-muted small">Capacity: 100 | Current: 25</p>
                            <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-1"></i>Government Center, Purok 3</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-success mb-2">OPEN</span><br>
                            <button class="btn btn-sm btn-outline-primary">View Details</button>
                        </div>
                    </div>
                </div>

                <div class="center-card mb-3 p-3 border rounded">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-1"><i class="fas fa-church me-2 text-primary"></i>Community Chapel</h6>
                            <p class="mb-1 text-muted small">Capacity: 150 | Current: 120</p>
                            <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-1"></i>Central Area, Purok 4</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-warning mb-2">NEAR FULL</span><br>
                            <button class="btn btn-sm btn-outline-primary">View Details</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="evacuation-summary p-3 bg-light rounded">
                    <h6><i class="fas fa-chart-pie me-2"></i>Centers Summary</h6>
                    <div class="summary-item d-flex justify-content-between mb-2">
                        <span>Total Centers:</span><strong>3</strong>
                    </div>
                    <div class="summary-item d-flex justify-content-between mb-2">
                        <span>Available Capacity:</span><strong>260</strong>
                    </div>
                    <div class="summary-item d-flex justify-content-between mb-2">
                        <span>Currently Occupied:</span><strong>190</strong>
                    </div>
                    <hr>
                    <div class="status-indicators">
                        <div class="mb-2"><span class="badge bg-success me-2">2</span>Open Centers</div>
                        <div class="mb-2"><span class="badge bg-warning me-2">1</span>Near Full</div>
                        <div class="mb-2"><span class="badge bg-danger me-2">0</span>Full Centers</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
