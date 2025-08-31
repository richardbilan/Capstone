@extends('layouts.user')

@section('content')
<!-- Support Tickets -->
<div class="card disaster-card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="card-title mb-0"><i class="fas fa-ticket-alt me-2"></i>Support Tickets</h5>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newTicketModal"><i class="fas fa-plus me-1"></i>New Ticket</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="tickets-list">
                    <div class="ticket-item p-3 border rounded mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-1">Map not loading properly</h6>
                                <p class="mb-1 text-muted small">Ticket #001 | Created: 2 hours ago</p>
                                <p class="mb-0 text-muted small">The disaster map is not showing hazard layers correctly...</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-warning mb-2">IN PROGRESS</span><br>
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>

                    <div class="ticket-item p-3 border rounded mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-1">Location services not working</h6>
                                <p class="mb-1 text-muted small">Ticket #002 | Created: 1 day ago</p>
                                <p class="mb-0 text-muted small">Unable to get current location when clicking the Location button...</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-success mb-2">RESOLVED</span><br>
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>

                    <div class="ticket-item p-3 border rounded mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-1">Add new evacuation center</h6>
                                <p class="mb-1 text-muted small">Ticket #003 | Created: 3 days ago</p>
                                <p class="mb-0 text-muted small">Request to add new community center as evacuation facility...</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-info mb-2">OPEN</span><br>
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="tickets-summary p-3 bg-light rounded">
                    <h6><i class="fas fa-chart-bar me-2"></i>Tickets Summary</h6>
                    <div class="summary-item d-flex justify-content-between mb-2"><span>Total Tickets:</span><strong>3</strong></div>
                    <div class="summary-item d-flex justify-content-between mb-2"><span>Open:</span><strong>1</strong></div>
                    <div class="summary-item d-flex justify-content-between mb-2"><span>In Progress:</span><strong>1</strong></div>
                    <div class="summary-item d-flex justify-content-between mb-2"><span>Resolved:</span><strong>1</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Ticket Modal -->
<div class="modal fade" id="newTicketModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Create New Support Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="newTicketForm">
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-control" required>
                            <option value="">Select category...</option>
                            <option value="technical">Technical Issue</option>
                            <option value="feature">Feature Request</option>
                            <option value="bug">Bug Report</option>
                            <option value="general">General Inquiry</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select class="form-control" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="4" required placeholder="Please describe your issue or request in detail..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="newTicketForm" class="btn btn-primary">Submit Ticket</button>
            </div>
        </div>
    </div>
</div>
@endsection
