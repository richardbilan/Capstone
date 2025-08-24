@extends('layouts.user')

@section('content')
<!-- Notifications & Alerts -->
<div class="card disaster-card">
    <div class="card-header">
        <h5 class="card-title mb-0"><i class="fas fa-bell me-2"></i>Notifications & Alerts</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- Alerts List -->
                <div class="notifications-list">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Weather Advisory</h6>
                        <p class="mb-1">Heavy rainfall expected in the next 6 hours. Residents in flood-prone areas are advised to prepare for possible evacuation.</p>
                        <small class="text-muted">2 hours ago | Provincial Weather Office</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>System Update</h6>
                        <p class="mb-1">Disaster management dashboard has been updated with new features. Location services are now more accurate.</p>
                        <small class="text-muted">1 day ago | System Administrator</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Evacuation Update</h6>
                        <p class="mb-1">Barangay Hall evacuation center is now fully operational with additional supplies and medical staff.</p>
                        <small class="text-muted">2 days ago | Barangay Emergency Team</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>

                    <!-- Regular notifications -->
                    <div class="notification-item p-3 border rounded mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <h6 class="mb-1"><i class="fas fa-calendar me-2 text-primary"></i>Emergency Preparedness Training</h6>
                                <p class="mb-1 text-muted small">Community training scheduled for next weekend at the Barangay Hall.</p>
                                <small class="text-muted">3 days ago</small>
                            </div>
                            <div class="col-md-2 text-end"><span class="badge bg-primary">Event</span></div>
                        </div>
                    </div>
                    <div class="notification-item p-3 border rounded mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <h6 class="mb-1"><i class="fas fa-tools me-2 text-warning"></i>System Maintenance</h6>
                                <p class="mb-1 text-muted small">Scheduled maintenance on mapping services this Sunday 2:00 AM - 4:00 AM.</p>
                                <small class="text-muted">1 week ago</small>
                            </div>
                            <div class="col-md-2 text-end"><span class="badge bg-warning">Maintenance</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="emergency-contacts p-3 bg-danger text-white rounded">
                    <h6><i class="fas fa-phone me-2"></i>Emergency Contacts</h6>
                    <div class="contact-item mb-2">
                        <strong>Barangay Emergency:</strong><br>
                        <a href="tel:+631234567890" class="text-white text-decoration-none"><i class="fas fa-phone me-1"></i>(+63) 123-456-7890</a>
                    </div>
                    <div class="contact-item mb-2">
                        <strong>Fire Department:</strong><br>
                        <a href="tel:116" class="text-white text-decoration-none"><i class="fas fa-phone me-1"></i>116</a>
                    </div>
                    <div class="contact-item">
                        <strong>National Emergency:</strong><br>
                        <a href="tel:911" class="text-white text-decoration-none"><i class="fas fa-phone me-1"></i>911</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
