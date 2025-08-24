@extends('layouts.app')

@section('hideSidebar', true)

@section('content')
<!-- Google Fonts: Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700&display=swap" rel="stylesheet">

<div class="container mt-4 text-center">
    <h2 class="directory-header">Emergency Contacts Directory</h2>
    <p class="directory-subtitle">Important contact information for emergency services and officials in Camalig, Albay</p>

    <!-- Filter/Search Row -->
    <div class="row mb-3 align-items-end">
        <div class="col-auto mb-2 mb-md-0">

            <select class="form-select" id="contactFilter" onchange="filterContacts()" style="width:200px;">
                <option value="all">View All Contacts</option>
                <option value="mdrrmo">MDRRMO</option>
                <option value="pnp">PNP</option>
                <option value="fire">Fire</option>
                <option value="health">Health</option>
                <option value="relief">Relief</option>
                <option value="lgu">LGU</option>
                <option value="volunteer">Volunteer</option>
                <option value="mayor">Mayor's Office</option>
                <option value="barangay">Barangay Officials</option>
            </select>
        </div>
        <div class="col d-flex flex-wrap align-items-end justify-content-end gap-2">
            <!-- Search input with 3D icon buttons -->
            <div class="input-group" style="max-width:300px;">
                <input type="text" class="form-control" id="contactSearch" placeholder="Search contacts...">
                <button class="btn btn-3d-search" type="button" onclick="filterContacts()" title="Search">
                    <i class="bi bi-search"></i>
                </button>
                <button class="btn btn-3d-clear" id="clearSearchBtn" type="button" onclick="clearSearch()" title="Clear" style="display:none;">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>

            <!-- Add Contact Button -->
            <button class="btn btn-success" onclick="openAddModal()">Add Contact</button>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="table-responsive" id="emergencyContactsTable">
        <table class="table table-bordered table-hover" id="contactsTable">
            <thead class="table-light">
                <tr>
                    <th>Office Name</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr data-type="{{ $contact->type }}">
                    <td>{{ $contact->office_name }}</td>
                    <td>{{ $contact->address }}</td>
                    <td>{{ $contact->contact_number }}</td>
                    <td>{{ $contact->type }}</td>
                    <td class="d-flex flex-wrap gap-1">
                        <button class="btn btn-primary btn-sm" onclick="openEditModal({{ $contact->id }}, '{{ $contact->office_name }}', '{{ $contact->address }}', '{{ $contact->contact_number }}', '{{ $contact->type }}')">Edit</button>
                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @if($contact->type === 'barangay')
                        <button class="btn btn-info btn-sm" onclick="showBarangayDetails()">View Barangay Info</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="contactForm" method="POST" action="{{ route('contacts.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="contact_id" id="contact_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contactModalLabel">Add Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Office Name</label>
                            <input type="text" class="form-control" id="office_name" name="office_name" required>
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label>Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number">
                        </div>
                        <div class="mb-3">
                            <label>Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="mdrrmo">MDRRMO</option>
                                <option value="pnp">PNP</option>
                                <option value="fire">Fire</option>
                                <option value="health">Health</option>
                                <option value="relief">Relief</option>
                                <option value="lgu">LGU</option>
                                <option value="volunteer">Volunteer</option>
                                <option value="mayor">Mayor's Office</option>
                                <option value="barangay">Barangay Officials</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Contact</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Custom Styles -->
<style>
    /* Header Font and Center */
    .directory-header {
        font-family: 'Roboto', sans-serif;
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
    }
    .directory-subtitle {
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 2rem;
    }

    /* Table hover */
    .table-hover tbody tr:hover {
        background-color: #f0f8ff;
    }

    /* 3D-style buttons */
    .btn-3d-search, .btn-3d-clear {
        background:  #1971c2;
        border: none;
        color: #fff;
        font-size: 1.2rem;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        transition: all 0.2s ease;
    }
    .btn-3d-search:hover, .btn-3d-clear:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0,0,0,0.4);
        background: linear-gradient(145deg, #1c7ed6, #0b3d91);
    }
    .btn-3d-search i, .btn-3d-clear i {
        font-size: 1.2rem;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('contactModal'));
    const searchInput = document.getElementById('contactSearch');
    const clearBtn = document.getElementById('clearSearchBtn');

    searchInput.addEventListener('input', function() {
        clearBtn.style.display = searchInput.value ? 'inline-flex' : 'none';
    });

    window.openAddModal = function() {
        document.getElementById('contactForm').action = "{{ route('contacts.store') }}";
        document.getElementById('formMethod').value = "POST";
        document.getElementById('contactForm').reset();
        clearBtn.style.display = 'none';
        document.getElementById('contactModalLabel').innerText = "Add Contact";
        modal.show();
    };

    window.openEditModal = function(id, office_name, address, contact_number, type) {
        document.getElementById('contactForm').action = "/contacts/" + id;
        document.getElementById('formMethod').value = "PUT";
        document.getElementById('contact_id').value = id;
        document.getElementById('office_name').value = office_name;
        document.getElementById('address').value = address;
        document.getElementById('contact_number').value = contact_number;
        document.getElementById('type').value = type;
        document.getElementById('contactModalLabel').innerText = "Edit Contact";
        modal.show();
    };

    window.filterContacts = function() {
        const filter = document.getElementById('contactFilter').value;
        const search = searchInput.value.toLowerCase();
        document.getElementById('emergencyContactsTable').style.display = 'block';
        document.querySelectorAll('#contactsTable tbody tr').forEach(row => {
            const type = row.dataset.type;
            const text = row.innerText.toLowerCase();
            row.style.display = (filter === 'all' || type === filter) && text.includes(search) ? '' : 'none';
        });
    };

    window.clearSearch = function() {
        searchInput.value = '';
        clearBtn.style.display = 'none';
        filterContacts();
    };

    window.showBarangayDetails = function() {
        alert("Show Barangay info here"); 
    };
});
</script>
@endpush
@endsection
