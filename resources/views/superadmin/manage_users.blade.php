<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Camaligtas Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <style>
        body {
            background: rgb(255, 255, 255);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* Responsive Navbar Styles */
        .navbar {
            padding: 0.5rem 1rem;
        }
        
        .navbar-brand {
            font-family: 'Lobster', cursive;
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            width: 40px;
            height: auto;
            margin-right: 0.5rem;
        }

        /* Main Content Styles */
        .main-content {
            padding: 1rem;
            margin-top: 1rem;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #e53935, #c62828);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
            padding: 1rem 1.5rem;
        }

        /* Barangay Selection Styles */
        .barangay-selection {
            margin-bottom: 2rem;
        }

        .barangay-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .barangay-btn {
            background: linear-gradient(135deg, #00bcd4, #0097a7);
            border: none;
            border-radius: 15px;
            color: white;
            padding: 2rem 1.5rem;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(0, 188, 212, 0.3);
            position: relative;
            overflow: hidden;
        }

        .barangay-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 188, 212, 0.4);
            background: linear-gradient(135deg, #0097a7, #00838f);
        }

        .barangay-btn:active {
            transform: translateY(-2px);
        }

        .barangay-btn.selected {
            background: linear-gradient(135deg, #ff9800, #f57f17);
            box-shadow: 0 8px 25px rgba(255, 152, 0, 0.4);
        }

        /* User Management Content */
        .user-management-content {
            display: none;
            animation: fadeIn 0.5s ease-in;
        }

        .user-management-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            height: 100%;
            text-align: center;
            transition: transform 0.2s ease;
            border: 1px solid #e9ecef;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        /* Table Responsive */
        .table-responsive {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            white-space: nowrap;
            background: #f8f9fa;
        }

        /* Action Buttons */
        .btn-action {
            padding: 0.4rem 0.8rem;
            margin: 0.2rem;
            white-space: nowrap;
        }

        .btn-approve {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-reject {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        /* Search and Filter Section */
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-box {
            border-radius: 25px;
            padding: 0.5rem 1rem;
        }

        .user-photo {
            width: 48px;
            height: 48px;
            object-fit: cover;
        }

        .position-label {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .id-label {
            background: #e9ecef;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-family: monospace;
        }

        /* Back Button */
        .back-btn {
            background: linear-gradient(135deg, #6c757d, #495057);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #495057, #343a40);
            transform: translateY(-2px);
            color: white;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1200px) {
            .stats-number {
                font-size: 1.75rem;
            }
            .barangay-btn {
                font-size: 1.3rem;
                padding: 1.5rem 1rem;
            }
        }

        @media (max-width: 992px) {
            .navbar-brand {
                font-size: 1.5rem;
            }
            .stats-card {
                margin-bottom: 1rem;
            }
            .btn-action {
                padding: 0.3rem 0.6rem;
                font-size: 0.8rem;
            }
            .barangay-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0.5rem;
            }
            .navbar-brand {
                font-size: 1.3rem;
            }
            .navbar-brand img {
                width: 30px;
            }
            .stats-number {
                font-size: 1.5rem;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
            .filter-section form {
                flex-direction: column;
            }
            .filter-section .col-md-6,
            .filter-section .col-md-4,
            .filter-section .col-md-2 {
                margin-bottom: 1rem;
            }
            .barangay-btn {
                font-size: 1.1rem;
                padding: 1.25rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.5rem;
            }
            .card-header {
                padding: 1rem;
            }
            .stats-card {
                padding: 1rem;
            }
            .btn-action {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            .user-photo {
                width: 36px;
                height: 36px;
            }
            .barangay-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.75rem;
            }
            .barangay-btn {
                font-size: 1rem;
                padding: 1rem 0.75rem;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: rgb(247, 247, 247);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#" style="margin-right: auto;">
            <img src="{{ asset('assets/img/logo_camalig.png') }}" alt="Logo" class="d-none d-sm-block">
            <div class="brand-text">
                <span class="camalig" style="color:rgb(252, 122, 46);">Camalig</span><span class="tas" style="color:rgb(12, 207, 22);">tas</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-shield me-2"></i>Super Administrator
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="{{ route('login') }}" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container main-content">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-2"><i class="fas fa-users-cog me-3"></i>User Management</h1>
            <p class="text-muted" id="pageDescription">Select a barangay to manage admin accounts and approval requests</p>
        </div>
    </div>

    <!-- Barangay Selection -->
    <div class="barangay-selection" id="barangaySelection">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-4">Select Barangay</h3>
                <div class="barangay-grid">
                    <button class="barangay-btn" onclick="selectBarangay('brgy1', this)">
                        <i class="fas fa-map-marker-alt mb-2 d-block"></i>
                        Brgy 1
                    </button>
                    <button class="barangay-btn" onclick="selectBarangay('brgy2', this)">
                        <i class="fas fa-map-marker-alt mb-2 d-block"></i>
                        Brgy2
                    </button>
                    <button class="barangay-btn" onclick="selectBarangay('ilawod', this)">
                        <i class="fas fa-map-marker-alt mb-2 d-block"></i>
                        Ilawod
                    </button>
                    <button class="barangay-btn" onclick="selectBarangay('libod', this)">
                        <i class="fas fa-map-marker-alt mb-2 d-block"></i>
                        Libod
                    </button>
                    <button class="barangay-btn" onclick="selectBarangay('sua', this)">
                        <i class="fas fa-map-marker-alt mb-2 d-block"></i>
                        Sua
                    </button>
                    <button class="barangay-btn" onclick="selectBarangay('cabangan', this)">
                        <i class="fas fa-map-marker-alt mb-2 d-block"></i>
                        Cabangan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management Content -->
    <div class="user-management-content" id="userManagementContent">
        <!-- Back Button -->
        <button class="btn back-btn" onclick="goBackToSelection()">
            <i class="fas fa-arrow-left me-2"></i>Back to Barangay Selection
        </button>

        <!-- Selected Barangay Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="text-primary"><i class="fas fa-map-marker-alt me-2"></i><span id="selectedBarangayName">Selected Barangay</span></h3>
                <p class="text-muted">Manage admin accounts and approval requests for this barangay</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stats-card">
                    <div class="stats-number text-primary" id="totalAdmins">4</div>
                    <div class="stats-label">Total Admins</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card">
                    <div class="stats-number text-warning" id="pendingAdmins">3</div>
                    <div class="stats-label">Pending</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card">
                    <div class="stats-number text-success" id="activeAdmins">1</div>
                    <div class="stats-label">Active</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card">
                    <div class="stats-number text-danger" id="suspendedAdmins">0</div>
                    <div class="stats-label">Suspended</div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <div id="alertContainer"></div>

        <!-- Filters -->
        <div class="filter-section">
            <form class="row g-3" onsubmit="filterUsers(event)">
                <div class="col-12 col-md-6">
                    <input type="text" name="search" class="form-control search-box" 
                           placeholder="Search by name, email, or ID...">
                </div>
                <div class="col-12 col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="inactive">Inactive</option>
                        <option value="on_leave">On Leave</option>
                        <option value="suspended">Suspended</option>
                        <option value="terminated">Terminated</option>
                        <option value="retired">Retired</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Admins Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Admin Accounts - <span id="tableBarangayName">Selected Area</span></h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Full Name & Position</th>
                                <th>Contact</th>
                                <th>Official ID</th>
                                <th>Household ID</th>
                                <th>Status</th>
                                <th>Registered</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <!-- Dynamic content will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalTitle">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="confirmModalBody">
                Are you sure you want to perform this action?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmButton">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let currentBarangay = null;
    let confirmModal;

    // Initialize modal
    document.addEventListener('DOMContentLoaded', function() {
        confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    });

    // Sample data for different barangays
    const barangayData = {
        brgy1: {
            name: "Barangay 1",
            stats: { total: 5, pending: 2, active: 2, suspended: 1 },
            users: [
                {
                    id: 1,
                    name: "Maria Santos",
                    position: "Barangay Captain",
                    email: "maria.santos@brgy1.gov.ph",
                    phone: "09123456789",
                    officialId: "OFF-2025-0001",
                    householdId: "HH-2025-0001",
                    status: "active",
                    registered: "January 15, 2025",
                    photo: "{{ asset('images/admin_photos/admin1.jpg') }}"
                },
                {
                    id: 2,
                    name: "Jose Reyes",
                    position: "Barangay Secretary",
                    email: "jose.reyes@brgy1.gov.ph",
                    phone: "09187654321",
                    officialId: "OFF-2025-0002",
                    householdId: "HH-2025-0002",
                    status: "pending",
                    registered: "February 10, 2025",
                    photo: "{{ asset('images/admin_photos/admin2.jpg') }}"
                }
            ]
        },
        brgy2: {
            name: "Barangay 2",
            stats: { total: 3, pending: 1, active: 2, suspended: 0 },
            users: [
                {
                    id: 3,
                    name: "Ana Cruz",
                    position: "Barangay Kagawad",
                    email: "ana.cruz@brgy2.gov.ph",
                    phone: "09198765432",
                    officialId: "OFF-2025-0003",
                    householdId: "HH-2025-0003",
                    status: "active",
                    registered: "March 5, 2025",
                    photo: "{{ asset('images/admin_photos/admin3.jpg') }}"
                }
            ]
        },
        ilawod: {
            name: "Ilawod",
            stats: { total: 4, pending: 3, active: 1, suspended: 0 },
            users: [
                {
                    id: 4,
                    name: "Juan Dela Cruz",
                    position: "Barangay Secretary",
                    email: "admin@gmail.com",
                    phone: "09123456789",
                    officialId: "OFF-2025-0001",
                    householdId: "HH-2025-0001",
                    status: "pending",
                    registered: "May 20, 2025",
                    photo: "{{ asset('images/admin_photos/admin2.jpg') }}"
                }
            ]
        },
        libod: {
            name: "Libod",
            stats: { total: 6, pending: 1, active: 4, suspended: 1 },
            users: [
                {
                    id: 5,
                    name: "Roberto Garcia",
                    position: "Barangay Captain",
                    email: "roberto.garcia@libod.gov.ph",
                    phone: "09123123123",
                    officialId: "OFF-2025-0005",
                    householdId: "HH-2025-0005",
                    status: "active",
                    registered: "January 8, 2025",
                    photo: "{{ asset('images/admin_photos/admin4.jpg') }}"
                }
            ]
        },
        sua: {
            name: "Sua",
            stats: { total: 3, pending: 0, active: 3, suspended: 0 },
            users: [
                {
                    id: 6,
                    name: "Carmen Lopez",
                    position: "Barangay Treasurer",
                    email: "carmen.lopez@sua.gov.ph",
                    phone: "09156789012",
                    officialId: "OFF-2025-0006",
                    householdId: "HH-2025-0006",
                    status: "active",
                    registered: "February 18, 2025",
                    photo: "{{ asset('images/admin_photos/admin5.jpg') }}"
                }
            ]
        },
        cabangan: {
            name: "Cabangan",
            stats: { total: 4, pending: 2, active: 1, suspended: 1 },
            users: [
                {
                    id: 7,
                    name: "Pedro Ramos",
                    position: "Barangay Kagawad",
                    email: "pedro.ramos@cabangan.gov.ph",
                    phone: "09167890123",
                    officialId: "OFF-2025-0007",
                    householdId: "HH-2025-0007",
                    status: "pending",
                    registered: "March 12, 2025",
                    photo: "{{ asset('images/admin_photos/admin6.jpg') }}"
                }
            ]
        }
    };

    function selectBarangay(barangayKey, buttonElement) {
        currentBarangay = barangayKey;
        const data = barangayData[barangayKey];

        // Remove selected class from all buttons
        document.querySelectorAll('.barangay-btn').forEach(btn => {
            btn.classList.remove('selected');
        });

        // Add selected class to clicked button
        buttonElement.classList.add('selected');

        // Update page content
        document.getElementById('selectedBarangayName').textContent = data.name;
        document.getElementById('tableBarangayName').textContent = data.name;
        document.getElementById('pageDescription').textContent = `Manage admin accounts and approval requests for ${data.name}`;

        // Update statistics
        document.getElementById('totalAdmins').textContent = data.stats.total;
        document.getElementById('pendingAdmins').textContent = data.stats.pending;
        document.getElementById('activeAdmins').textContent = data.stats.active;
        document.getElementById('suspendedAdmins').textContent = data.stats.suspended;

        // Load users table
        loadUsersTable(data.users);

        // Hide selection, show content
        setTimeout(() => {
            document.getElementById('barangaySelection').style.display = 'none';
            document.getElementById('userManagementContent').classList.add('active');
        }, 200);
    }

    function goBackToSelection() {
        document.getElementById('userManagementContent').classList.remove('active');
        setTimeout(() => {
            document.getElementById('barangaySelection').style.display = 'block';
            document.getElementById('pageDescription').textContent = 'Select a barangay to manage admin accounts and approval requests';
            
            // Remove selected class from all buttons
            document.querySelectorAll('.barangay-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            
            currentBarangay = null;
        }, 300);
    }

    function loadUsersTable(users) {
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';

        users.forEach(user => {
            const statusBadge = getStatusBadge(user.status);
            const row = `
                <tr data-user-id="${user.id}">
                    <td>
                        <img src="${user.photo}" alt="Admin Photo" class="user-photo rounded-circle">
                    </td>
                    <td>
                        <div>
                            <strong>${user.name}</strong>
                            <div class="position-label">${user.position}</div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <i class="fas fa-envelope me-1 text-muted"></i>${user.email}
                            <br>
                            <small><i class="fas fa-phone me-1 text-muted"></i>${user.phone}</small>
                        </div>
                    </td>
                    <td>
                        <span class="id-label">${user.officialId}</span>
                    </td>
                    <td>
                        <span class="id-label">${user.householdId}</span>
                    </td>
                    <td>
                        ${statusBadge}
                    </td>
                    <td>
                        <small>${user.registered}</small>
                    </td>
                    <td>
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                            ${getActionButtons(user.status, user.id)}
                        </div>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    function getStatusBadge(status) {
        const badges = {
            'active': '<span class="badge bg-success">Active</span>',
            'pending': '<span class="badge bg-warning">Pending</span>',
            'suspended': '<span class="badge bg-danger">Suspended</span>',
            'inactive': '<span class="badge bg-secondary">Inactive</span>'
        };
        return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
    }

    function getActionButtons(status, userId) {
        if (status === 'pending') {
            return `
                <button class="btn btn-approve btn-action" onclick="approveUser(${userId})">
                    <i class="fas fa-check me-1"></i>Approve
                </button>
                <button class="btn btn-reject btn-action" onclick="rejectUser(${userId})">
                    <i class="fas fa-times me-1"></i>Reject
                </button>
                <button class="btn btn-outline-danger btn-action" onclick="deleteUser(${userId})">
                    <i class="fas fa-trash me-1"></i>Delete
                </button>
            `;
        } else {
            return `
                <button class="btn btn-outline-primary btn-action" onclick="editUser(${userId})">
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
                <button class="btn btn-outline-danger btn-action" onclick="deleteUser(${userId})">
                    <i class="fas fa-trash me-1"></i>Delete
                </button>
            `;
        }
    }

    function filterUsers(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const searchTerm = formData.get('search').toLowerCase();
        const statusFilter = formData.get('status');
        
        if (!currentBarangay) return;
        
        const data = barangayData[currentBarangay];
        let filteredUsers = data.users;
        
        if (searchTerm) {
            filteredUsers = filteredUsers.filter(user =>
                user.name.toLowerCase().includes(searchTerm) ||
                user.email.toLowerCase().includes(searchTerm) ||
                user.officialId.toLowerCase().includes(searchTerm)
            );
        }
        
        if (statusFilter) {
            filteredUsers = filteredUsers.filter(user => user.status === statusFilter);
        }
        
        loadUsersTable(filteredUsers);
        showAlert('Filter applied successfully!', 'success');
    }

    function approveUser(userId) {
        showConfirmModal(
            'Approve User',
            'Are you sure you want to approve this user?',
            () => {
                // Here you would make an API call to approve the user
                showAlert('User approved successfully!', 'success');
                updateUserStatus(userId, 'active');
            }
        );
    }

    function rejectUser(userId) {
        showConfirmModal(
            'Reject User',
            'Are you sure you want to reject this user?',
            () => {
                // Here you would make an API call to reject the user
                showAlert('User rejected successfully!', 'warning');
                updateUserStatus(userId, 'inactive');
            }
        );
    }

    function deleteUser(userId) {
        showConfirmModal(
            'Delete User',
            'Are you sure you want to delete this user? This action cannot be undone.',
            () => {
                // Here you would make an API call to delete the user
                showAlert('User deleted successfully!', 'success');
                removeUserFromTable(userId);
            }
        );
    }

    function editUser(userId) {
        showAlert('Edit user functionality would be implemented here.', 'info');
    }

    function updateUserStatus(userId, newStatus) {
        if (!currentBarangay) return;
        
        const data = barangayData[currentBarangay];
        const user = data.users.find(u => u.id === userId);
        if (user) {
            user.status = newStatus;
            loadUsersTable(data.users);
            updateStats();
        }
    }

    function removeUserFromTable(userId) {
        if (!currentBarangay) return;
        
        const data = barangayData[currentBarangay];
        data.users = data.users.filter(u => u.id !== userId);
        loadUsersTable(data.users);
        updateStats();
    }

    function updateStats() {
        if (!currentBarangay) return;
        
        const data = barangayData[currentBarangay];
        const stats = {
            total: data.users.length,
            pending: data.users.filter(u => u.status === 'pending').length,
            active: data.users.filter(u => u.status === 'active').length,
            suspended: data.users.filter(u => u.status === 'suspended').length
        };
        
        data.stats = stats;
        
        document.getElementById('totalAdmins').textContent = stats.total;
        document.getElementById('pendingAdmins').textContent = stats.pending;
        document.getElementById('activeAdmins').textContent = stats.active;
        document.getElementById('suspendedAdmins').textContent = stats.suspended;
    }

    function showConfirmModal(title, message, callback) {
        document.getElementById('confirmModalTitle').textContent = title;
        document.getElementById('confirmModalBody').textContent = message;
        
        const confirmButton = document.getElementById('confirmButton');
        confirmButton.onclick = () => {
            callback();
            confirmModal.hide();
        };
        
        confirmModal.show();
    }

    function showAlert(message, type) {
        const alertContainer = document.getElementById('alertContainer');
        const alertClass = `alert-${type}`;
        const alert = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        alertContainer.innerHTML = alert;
        
        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            const alertElement = alertContainer.querySelector('.alert');
            if (alertElement) {
                alertElement.remove();
            }
        }, 3000);
    }
</script>

</body>
</html>
