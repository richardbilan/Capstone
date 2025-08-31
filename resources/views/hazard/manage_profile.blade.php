
@extends('layouts.app')
@section('hideSidebar', true)
@section('hideNavbarLinks', true)

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Manage Profile</h2>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!$edit)
                        <!-- Profile View Mode -->
                        <div class="text-center mb-4">
                            <div style="position: relative; display: inline-block;">
                                <img src="{{ $fakeUser->photo ? asset('storage/' . $fakeUser->photo) : asset('images/default_user.png') }}"
                                     alt="Profile Photo"
                                     class="rounded-circle"
                                     style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #1877f2;">
                            </div>
                            <h4 class="mt-3 mb-1">{{ $fakeUser->full_name }}</h4>
                            <p class="mb-1 text-muted">{{ $fakeUser->position }}</p>
                            <p class="mb-1"><i class="fas fa-phone"></i> {{ $fakeUser->contact_number }}</p>
                            <a href="{{ route('hazard.profile', ['edit' => 1]) }}" class="btn btn-outline-primary mt-2">Edit Profile</a>
                        </div>
                    @else
                        <!-- Profile Edit Form -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 text-center">
                                <div style="position: relative; display: inline-block;">
                                    <img id="profilePicPreview"
                                         src="{{ $fakeUser->photo ? asset('storage/' . $fakeUser->photo) : asset('images/default_user.png') }}"
                                         alt="Profile Photo"
                                         class="rounded-circle mb-2"
                                         style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #1877f2;">
                                    <label for="photo" style="position: absolute; bottom: 0; right: 0; background: #fff; border-radius: 50%; padding: 6px; cursor: pointer; border: 1px solid #ccc;">
                                        <i class="fas fa-camera"></i>
                                        <input type="file" id="photo" name="photo" class="d-none" accept="image/*" onchange="previewProfilePic(event)">
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $fakeUser->full_name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Position</label>
                                <input type="text" name="position" class="form-control" value="{{ old('position', $fakeUser->position) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $fakeUser->contact_number) }}" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Submit Changes</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS for live preview of profile picture -->
<script>
function previewProfilePic(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('profilePicPreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection