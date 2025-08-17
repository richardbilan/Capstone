
@extends('layouts.app')

@section('hideSidebar', true)

@section('content')
<div class="container mt-4">
    <h2>Emergency Contacts Directory</h2>
    <p>Important contact information for emergency services and officials in Camalig, Albay</p>

    <div class="row mb-3">
        <div class="col-md-6">
            <select class="form-select" id="contactFilter" onchange="filterContacts()">
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
        <div class="col-md-6">
            <input type="text" class="form-control" id="contactSearch" placeholder="Search contacts..." onkeyup="filterContacts()">
        </div>
    </div>

    <!-- Emergency Contacts Table -->
    <div class="table-responsive" id="emergencyContactsTable">
        <table class="table table-bordered" id="contactsTable">
            <thead>
                <tr>
                    <th>Office Name</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                </tr>
            </thead>
            <tbody>
                <tr data-type="mdrrmo">
                    <td>Municipal Disaster Risk Reduction and Management Office (MDRRMO) Camalig</td>
                    <td>Poblacion, Camalig, Albay</td>
                    <td>09473259363 / 09163294359</td>
                </tr>
                <tr data-type="pnp">
                    <td>Philippine National Police (PNP) Camalig</td>
                    <td>Poblacion, Camalig, Albay</td>
                    <td>09777808986</td>
                </tr>
                <tr data-type="fire">
                    <td>Bureau of Fire Protection (BFP) Camalig</td>
                    <td>Poblacion, Camalig, Albay</td>
                    <td>09178908823 / 09992265345</td>
                </tr>
                <tr data-type="health">
                    <td>Rural Health Unit (RHU) Camalig</td>
                    <td>Poblacion, Camalig, Albay</td>
                    <td>09178653935 / 09175591220</td>
                </tr>
                <tr data-type="health">
                    <td>Rapid Testing Facility and Isolation Facility Camalig</td>
                    <td>Community Training Center, Salugan, Camalig</td>
                    <td>09163233493</td>
                </tr>
                <tr data-type="health">
                    <td>Bicol Regional Training and Teaching Hospital (BRTTH)</td>
                    <td>Rizal St., Sagpon, Daraga, Albay</td>
                    <td>732 5555 / 732 5501</td>
                </tr>
                <tr data-type="lgu">
                    <td>Bureau of Jail Management and Penology (BJMP) Camalig</td>
                    <td>Poblacion, Camalig, Albay</td>
                    <td>09121524121</td>
                </tr>
                <tr data-type="lgu">
                    <td>Department of the Interior and Local Government (DILG) Camalig</td>
                    <td>Poblacion, Camalig, Albay</td>
                    <td>09273723791</td>
                </tr>
                <tr data-type="lgu">
                    <td>Albay Power and Energy (APEC)</td>
                    <td>W. Vinzons St., Old Albay District, Legazpi City, 4500 Albay</td>
                    <td>09292683904 / 09957296332</td>
                </tr>
                <tr data-type="health">
                    <td>BOC - Holy Face Rehabilitation Center for Mental Health</td>
                    <td>Tabiguian, Tabaco City, Albay</td>
                    <td>09206915015</td>
                </tr>
                <tr data-type="volunteer">
                    <td>Simon of Cyrene Community Rehabilitation and Development Fdn, Inc.</td>
                    <td>286 Bañag, Daraga, Albay</td>
                    <td>(052)7420710 / (052)4312554</td>
                </tr>
                <tr data-type="barangay">
                    <td>Barangay Officials</td>
                    <td>Ilawod, Camalig</td>
                    <td><button class="btn btn-primary btn-sm" onclick="showBarangayDetails()">View All Info</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Barangay Officials Section -->
    <div id="barangayOfficialsSection" style="display: none;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Barangay Officials - Ilawod, Camalig</h4>
            <button class="btn btn-secondary" onclick="showAllContacts()">Back to Contacts</button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center bg-primary text-white">
                            <h5 class="mb-0">BARANGAY (BDRRMC) OFFICIAL</h5>
                        </th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hon. Edsel M. Garcia</td>
                        <td>BDRRMC Chairperson</td>
                    </tr>
                    <tr>
                        <td>Savador M. Llorca</td>
                        <td>Operations/Admin & PIO</td>
                    </tr>
                    <tr>
                        <td>Daisy Donnor</td>
                        <td>Mitigation & Prevention (Sub-Committee)</td>
                    </tr>
                    <tr>
                        <td>Elsa R. Nova</td>
                        <td>Preparedness Sub-Committee</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Recovery and Rehabilitation Sub-Committee</strong></td>
                    </tr>
                    <tr>
                        <td>KGWD. Gloria P. Navales</td>
                        <td>Livelihood Team</td>
                    </tr>
                    <tr>
                        <td>KGWD. Joel A. Lim</td>
                        <td>Infra/Shelter Team</td>
                    </tr>
                    <tr>
                        <td>Salvador Llorca</td>
                        <td>PDANA Team</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Response Sub-Committee</strong></td>
                    </tr>
                    <tr>
                        <td>Antonette Nacion</td>
                        <td>RDANA</td>
                    </tr>
                    <tr>
                        <td>Antonio N. Necio</td>
                        <td>Search, Rescue & Retrieval Team</td>
                    </tr>
                    <tr>
                        <td>Ian V. Villaraza</td>
                        <td>Evacuation CM Team (5 members)</td>
                    </tr>
                    <tr>
                        <td>BT. Armen E. Naz</td>
                        <td>Relief Dist. Team (5 members)</td>
                    </tr>
                    <tr>
                        <td>MW Brigida Moratalla</td>
                        <td>Health/First Aid (12 BHWs)</td>
                    </tr>
                    <tr>
                        <td>Fire Brigade Team</td>
                        <td>Fire Management (10 Fire Brigade)</td>
                    </tr>
                    <tr>
                        <td>Alexa M. Llovit</td>
                        <td>Ilawod Children's Organization</td>
                    </tr>
                    <tr>
                        <td>CSO Representatives</td>
                        <td>3 CSO Members: Youth, PWD, Kalipi</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Research & Planning Team</strong></td>
                    </tr>
                    <tr>
                        <td>Sec. Dava-Franz Monilla</td>
                        <td>Secretary</td>
                    </tr>
                    <tr>
                        <td>SK Chairman</td>
                        <td>SK Representative</td>
                    </tr>
                    <tr>
                        <td>SK KGWD Members</td>
                        <td>SK Council Members</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Transportation Team</strong></td>
                    </tr>
                    <tr>
                        <td>BT Teodolfo Ventura</td>
                        <td>Chairman + 5 Members</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Communication & Warning Team</strong></td>
                    </tr>
                    <tr>
                        <td>KGWD. Gloria P. Navales</td>
                        <td>Chairman + 5 Members</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Security & Safety Team</strong></td>
                    </tr>
                    <tr>
                        <td>KGD. Joel A. Lim</td>
                        <td>Chairman + 5 Members</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Education Team</strong></td>
                    </tr>
                    <tr>
                        <td>KGWD. Nenit Llanza</td>
                        <td>Chairman + 5 Purok Members</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Protection Team</strong></td>
                    </tr>
                    <tr>
                        <td>KGWD. Pamela Cabellon</td>
                        <td>Chairman + 12 BHWs</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="2"><strong>Damage Control Team</strong></td>
                    </tr>
                    <tr>
                        <td>KGWD. Armen E. Naz</td>
                        <td>Chairman + 5 Volunteer Members</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
function filterContacts() {
    const filter = document.getElementById('contactFilter').value;
    const search = document.getElementById('contactSearch').value.toLowerCase();
    
    // Always show emergency contacts table and hide barangay details
    document.getElementById('emergencyContactsTable').style.display = 'block';
    document.getElementById('barangayOfficialsSection').style.display = 'none';
    
    // Filter emergency contacts
    const rows = document.querySelectorAll('#contactsTable tbody tr');
    rows.forEach(row => {
        const type = row.getAttribute('data-type');
        const text = row.innerText.toLowerCase();
        const matchesType = (filter === 'all' || type === filter);
        const matchesSearch = text.includes(search);
        row.style.display = (matchesType && matchesSearch) ? '' : 'none';
    });
}

function showBarangayDetails() {
    // Show barangay officials section, hide emergency contacts
    document.getElementById('emergencyContactsTable').style.display = 'none';
    document.getElementById('barangayOfficialsSection').style.display = 'block';
}

function showAllContacts() {
    // Reset dropdown to "View All Contacts"
    document.getElementById('contactFilter').value = 'all';
    // Show emergency contacts table, hide barangay officials
    document.getElementById('emergencyContactsTable').style.display = 'block';
    document.getElementById('barangayOfficialsSection').style.display = 'none';
    // Clear search and show all rows
    document.getElementById('contactSearch').value = '';
    const rows = document.querySelectorAll('#contactsTable tbody tr');
    rows.forEach(row => {
        row.style.display = '';
    });
}
</script>
@endpush
@endsection