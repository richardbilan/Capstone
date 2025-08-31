@extends('layouts.user')

@section('content')
<!-- MOU/MOA Private Home Evacuation Centers -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-home me-2"></i>Private Home Evacuation Centers (MOU/MOA)
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Left Column: Form -->
            <div class="col-md-8">
                <div class="alert alert-info mb-4">
                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>About the MOU/MOA Program</h6>
                    <p class="mb-0">
                        Large, sturdy homes can serve as potential evacuation centers under a Memorandum of Agreement (MOU/MOA) between the homeowner and the Barangay. This program provides decision support only and does not guarantee activation without formal inspection.
                    </p>
                </div>

                <form id="mouRequestForm" action="{{ route('user.mou.store') }}" method="POST">
                    @csrf
                    <!-- Homeowner Information -->
                    <h6 class="mb-3"><i class="fas fa-user-circle me-2"></i>Homeowner Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-user me-1"></i>Full Name</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-phone me-1"></i>Contact Number</label>
                            <input type="tel" class="form-control" name="contact_number" required>
                        </div>
                    </div>

                    <!-- Property Information -->
                    <h6 class="mb-3 mt-4"><i class="fas fa-home me-2"></i>Property Information</h6>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Complete Address</label>
                        <input type="text" class="form-control" name="address" required placeholder="House number, street, Purok, Barangay">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-building me-1"></i>House Type/Structure</label>
                            <select class="form-control" name="house_type" required>
                                <option value="">Select house type...</option>
                                <option value="concrete">Concrete/Solid Structure</option>
                                <option value="mixed">Mixed Materials (Concrete & Wood)</option>
                                <option value="reinforced">Reinforced Concrete</option>
                                <option value="multi-story">Multi-Story Building</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-users me-1"></i>Estimated Capacity</label>
                            <select class="form-control" name="capacity" required>
                                <option value="">Select capacity...</option>
                                <option value="10-20">10-20 people</option>
                                <option value="21-50">21-50 people</option>
                                <option value="51-100">51-100 people</option>
                                <option value="100+">100+ people</option>
                            </select>
                        </div>
                    </div>

                    <!-- Facilities -->
                    <h6 class="mb-3 mt-4"><i class="fas fa-clipboard-check me-2"></i>Available Facilities</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="toilet" name="facilities[]" value="toilet"><label class="form-check-label" for="toilet">Toilet/Restroom</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="water" name="facilities[]" value="water"><label class="form-check-label" for="water">Clean Water Access</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="electricity" name="facilities[]" value="electricity"><label class="form-check-label" for="electricity">Electricity/Generator</label></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="kitchen" name="facilities[]" value="kitchen"><label class="form-check-label" for="kitchen">Kitchen/Cooking Area</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="parking" name="facilities[]" value="parking"><label class="form-check-label" for="parking">Parking/Vehicle Access</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" id="firstaid" name="facilities[]" value="first_aid"><label class="form-check-label" for="firstaid">First Aid Supplies</label></div>
                        </div>
                    </div>

                    <!-- Other Facilities -->
                    <div class="mt-2">
                        <label class="form-label" for="other_facilities"><i class="fas fa-plus-circle me-1"></i>Other Facilities (optional)</label>
                        <input type="text" class="form-control" id="other_facilities" name="other_facilities" placeholder="e.g., Wi-Fi, laundry area, pet-friendly">
                        <small class="text-muted">Separate multiple items with commas. These will be saved along with the checked facilities.</small>
                    </div>

                    <!-- Additional Notes -->
                    <div class="mb-3 mt-4">
                        <label class="form-label"><i class="fas fa-comment me-1"></i>Additional Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Add any additional facilities, features, or important notes..."></textarea>
                    </div>

                    <!-- Agreement -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agreement" name="agreement" required>
                            <label class="form-check-label" for="agreement"><strong>I agree to participate in the MOU/MOA program. Approval requires barangay inspection and formal agreement signing.</strong></label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-file-contract me-1"></i>Submit Application</button>
                </form>
            </div>

            <!-- Right Column: Info Panels -->
            <div class="col-md-4">
                <!-- Requirements -->
                <div class="p-3 bg-light rounded mb-3 border">
                    <h6><i class="fas fa-clipboard-list me-2"></i>Requirements</h6>
                    <ul class="small text-muted mb-0">
                        <li>Large, sturdy house structure</li>
                        <li>Safe location (not in high-risk areas)</li>
                        <li>Basic facilities (toilet, water access)</li>
                        <li>Homeowner willingness to participate</li>
                        <li>Barangay inspection and approval</li>
                        <li>Formal agreement signing</li>
                    </ul>
                </div>

                <!-- Process -->
                <div class="p-3 mb-3 bg-info bg-opacity-10 border border-info rounded">
                    <h6><i class="fas fa-list-ol me-2 text-info"></i>Process Steps</h6>
                    <ol class="small text-muted mb-0">
                        <li>Submit application form</li>
                        <li>Barangay inspection</li>
                        <li>Safety and capacity assessment</li>
                        <li>Community consultation</li>
                        <li>MOU/MOA preparation</li>
                        <li>Agreement signing</li>
                        <li>Activation during emergencies</li>
                    </ol>
                </div>

                <!-- Emergency Contacts -->
                <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded">
                    <h6><i class="fas fa-phone me-2 text-warning"></i>For Inquiries</h6>
                    <div class="small">
                        <div class="mb-2"><strong>Barangay Office:</strong><br><a href="tel:+631234567890" class="text-decoration-none"><i class="fas fa-phone me-1"></i>(+63) 123-456-7890</a></div>
                        <div class="mb-0"><strong>Emergency Management:</strong><br><a href="tel:+631234567891" class="text-decoration-none"><i class="fas fa-phone me-1"></i>(+63) 123-456-7891</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
