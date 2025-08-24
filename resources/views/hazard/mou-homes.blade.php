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
                            $facilities = [];
                            if($home->toilet) $facilities[] = 'Toilet';
                            if($home->water) $facilities[] = 'Water';
                            if($home->electricity) $facilities[] = 'Electricity';
                            if($home->kitchen) $facilities[] = 'Kitchen';
                            if($home->parking) $facilities[] = 'Parking';
                            if($home->first_aid) $facilities[] = 'First Aid';
                        @endphp
                        {{ implode(', ', $facilities) }}
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
    <form action="{{ route('hazard.mou.updateStatus', $home) }}" method="POST" class="d-flex gap-1 justify-content-center">
        @csrf
        <select name="status" class="form-select form-select-sm">
            <option value="Pending" @if($home->status=='Pending') selected @endif>Pending</option>
            <option value="Approved" @if($home->status=='Approved') selected @endif>Approved</option>
            <option value="Rejected" @if($home->status=='Rejected') selected @endif>Rejected</option>
        </select>
        <button class="btn btn-sm btn-primary" type="submit">Update</button>
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
