@extends('layouts.app')
@section('hideSidebar', true)

@section('content')
<div class="container mt-5 pt-4">
    <!-- Page Title -->
    <div class="text-center mb-3">
        <h3 class="mb-1">MOU/MOA Applications</h3>
        <small class="text-muted">List of submitted private home evacuation center applications</small>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>ID</th>
                    <th>Homeowner</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>House Type</th>
                    <th>Capacity</th>
                    <th>Facilities</th>
                    <th>Status</th>
                    <th>Submitted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
            @foreach($mouHomes as $home)
                <tr>
                    <td>{{ $home->id }}</td>
                    <td>{{ $home->homeowner_name }}</td>
                    <td>{{ $home->contact_number }}</td>
                    <td>{{ $home->address }}</td>
                    <td>{{ $home->house_type }}</td>
                    <td>{{ $home->capacity }}</td>
                    <td>
                        @php
                            $labels = [
                                'toilet' => 'Toilet',
                                'water' => 'Water',
                                'electricity' => 'Electricity',
                                'kitchen' => 'Kitchen',
                                'parking' => 'Parking',
                                'first_aid' => 'First Aid',
                            ];
                            $values = [];
                            if (is_array($home->facilities)) {
                                foreach ($home->facilities as $f) {
                                    $values[] = $labels[$f] ?? ucfirst(str_replace('_',' ', $f));
                                }
                            } else {
                                // Fallback to legacy boolean columns if JSON not present
                                if($home->toilet ?? false) $values[] = 'Toilet';
                                if($home->water ?? false) $values[] = 'Water';
                                if($home->electricity ?? false) $values[] = 'Electricity';
                                if($home->kitchen ?? false) $values[] = 'Kitchen';
                                if($home->parking ?? false) $values[] = 'Parking';
                                if($home->first_aid ?? false) $values[] = 'First Aid';
                            }
                        @endphp
                        {{ implode(', ', $values) }}
                    </td>
                    <td>
                        @php
                            $badgeClass = match($home->status) {
                                'Approved' => 'success',
                                'Rejected' => 'danger',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeClass }}">{{ $home->status }}</span>
                    </td>
                    <td>{{ $home->created_at->format('M d, Y H:i') }}</td>
                    <td>
    <form action="{{ route('hazard.mou.updateStatus', $home) }}" method="POST" class="d-flex flex-wrap gap-1 justify-content-center">
        @csrf
        <select name="status" class="form-select form-select-sm">
            <option value="Pending" @if($home->status=='Pending') selected @endif>Pending</option>
            <option value="Approved" @if($home->status=='Approved') selected @endif>Approved</option>
            <option value="Rejected" @if($home->status=='Rejected') selected @endif>Rejected</option>
        </select>
        <button class="btn btn-sm btn-primary" type="submit">Update</button>
        <a class="btn btn-sm btn-success" href="{{ route('evacuation', ['address' => $home->address]) }}" target="_blank">View on Map</a>
    </form>
</td>

@if(session('success'))
    <div id="successAlert" class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" 
         role="alert" style="z-index: 1050;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        // Auto-hide after 3 seconds
        setTimeout(() => {
            const alert = document.getElementById('successAlert');
            if(alert){
                alert.classList.remove('show');
                alert.classList.add('hide');
                alert.addEventListener('transitionend', () => alert.remove());
            }
        }, 3000);
    </script>
@endif

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
