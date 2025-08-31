@extends('layouts.app')

@section('hideSidebar', true)

@section('content')
<style>
/* Hide large decorative graphics that overlap content (fallback) */
.decorative, .hero-chevron, .site-hero, .site-hero__graphic,
.background-arrow, .big-arrow, svg.large-decoration, .hero-bg, .page-hero,
.header-graphic, .hero, .hero-svg, .site-header-graphic {
  display: none !important;
  visibility: hidden !important;
  pointer-events: none !important;
  opacity: 0 !important;
}
body > svg, svg[width], svg[height], svg[style*="position:absolute"], svg[style*="position: fixed"] {
  display: none !important;
  pointer-events: none !important;
  opacity: 0 !important;
}
.max-w-7xl, .table-wrap, .header-row, .search-controls, .modal-overlay {
  position: relative;
  z-index: 1000 !important;
}

/* MODALS */
.modal-overlay { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; z-index: 2000; backdrop-filter: blur(3px); background: rgba(10,15,20,0.35); pointer-events: auto; }
.modal-overlay.show { display: flex; }
.modal-dialog { background: linear-gradient(180deg,#ffffff 0%, #fbfbff 100%); border-radius: 12px; width: 92%; max-width: 880px; max-height: 88vh; overflow: auto; padding: 1rem; box-shadow: 0 14px 40px rgba(14,32,66,0.12); z-index: 2001; }
.modal-dialog, .modal-dialog * { pointer-events: auto; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.form-grid .col-span-2 { grid-column: 1 / -1; }
.modal-dialog input, .modal-dialog select, .modal-dialog textarea {
  width: 100%; padding: .5rem; border-radius: 8px; border: 1px solid #e6e9ef; box-sizing: border-box;
}

/* BUTTONS */
.btn { display:inline-flex; align-items:center; gap:.5rem; padding:.45rem .8rem; border-radius:10px; font-weight:600; cursor:pointer; border:1px solid transparent; }
.btn-primary { background:#2563eb; color:#fff; border-color:#2563eb; }
.btn-ghost { background:#fff; color:#374151; border-color:#e5e7eb; box-shadow: 0 2px 6px rgba(15,23,42,0.03); }
.btn-warning { background:#f59e0b; color:#fff; border-color:#f59e0b; }
.btn-danger { background:#ef4444; color:#fff; border-color:#ef4444; }

/* TABLE */
.table-wrap { overflow-x:auto; border-radius:10px; background:#fff; padding:.5rem; }
@media (max-width:640px){ .form-grid { grid-template-columns: 1fr; } }

/* CONTAINER */
.pagination-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .8rem;
  margin-top: 1.5rem;
  width: 100%;
}

/* UL CONTAINER */
.pagination-numbers ul {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  list-style: none;
  padding: 0;
  margin: 0;
  justify-content: center;
}

/* PAGE BUTTON STYLE */
.pagination-numbers li a,
.pagination-numbers li span {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 46px;
  min-height: 46px;
  border-radius: 10px;
  font-size: 1rem;
  font-weight: 500;
  color: #374151;
  border: 1px solid #e5e7eb;
  text-decoration: none;
  transition: all .2s ease-in-out;
  background: #f9fafb;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

/* hover simple blue */
.pagination-numbers li a:hover {
  background: #2563eb;
  color: #fff;
  border-color: #1d4ed8;
  transform: translateY(-2px);
}

/* ACTIVE PAGE */
.pagination-numbers li.active a {
  background: #1d4ed8;
  color: #fff;
  border-color: #1e40af;
  font-weight: 700;
  box-shadow: 0 2px 8px rgba(37,99,235,0.35);
  cursor: default;
  transform: scale(1.05);
}

/* DISABLED STATE */
.pagination-numbers li.disabled span {
  background: #f3f4f6;
  color: #9ca3af;
  border-color: #e5e7eb;
  cursor: not-allowed;
  opacity: .6;
}

/* INFO TEXT */
.pagination-info {
  font-size: .95rem;
  color: #374151;
}
</style>

<div class="max-w-7xl mx-auto p-4 space-y-6">
  <div class="header-row" style="display:flex;justify-content:space-between;align-items:center">
    <h1 style="font-size:1.6rem;margin:0">Residents</h1>
    <div style="display:flex;gap:.5rem">
      <a href="{{ route('home') }}" class="btn btn-ghost">← Back</a>
      <button type="button" onclick="openModal('addModal')" class="btn btn-primary">+ Add Resident</button>
    </div>
  </div>

  @if(session('success'))
    <div style="padding:.5rem;background:#ecfdf5;border:1px solid #bbf7d0;color:#065f46;border-radius:8px">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div style="padding:.5rem;background:#fff1f2;border:1px solid #fecaca;color:#7f1d1d;border-radius:8px">
      <ul style="margin:0;padding-left:1.2rem">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
    </div>
  @endif

<form method="GET" action="{{ route('residents.index') }}" 
      style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem;width:100%">

  {{-- Left: Purok Filter --}}
  <div style="display:flex;align-items:center;gap:.5rem">
    <label style="font-size:.9rem">Filter by Purok:</label>
    <select name="purok" onchange="this.form.submit()" 
            style="padding:.4rem;border-radius:6px;border:1px solid #e5e7eb">
      <option value="">All</option>
      @for ($i = 1; $i <= 5; $i++)
        <option value="{{ $i }}" {{ (string)request('purok') === (string)$i ? 'selected' : '' }}>
          Purok {{ $i }}
        </option>
      @endfor
    </select>

    <label style="font-size:.9rem; margin-left:.5rem">Filter by Status:</label>
    <select name="filter" onchange="this.form.submit()" 
            style="padding:.4rem;border-radius:6px;border:1px solid #e5e7eb">
      @php $f = strtolower((string)request('filter')); @endphp
      <option value="" {{ $f==='' ? 'selected' : '' }}>All</option>
      <option value="Married" {{ $f==='married' ? 'selected' : '' }}>Married</option>
      <option value="Single" {{ $f==='single' ? 'selected' : '' }}>Single</option>
      <option value="Solo_Parent" {{ $f==='solo_parent' ? 'selected' : '' }}>Solo Parent</option>
      <option value="Disability" {{ $f==='disability' ? 'selected' : '' }}>Disability</option>
      <option value="Maternal" {{ $f==='maternal' ? 'selected' : '' }}>Maternal</option>
    </select>
  </div>

  {{-- Right: Search + Icons --}}
  <div style="display:flex;align-items:center;gap:.4rem; margin-top: 10px; margin-bottom: 10px;">
    <input type="search" name="search" placeholder="Search name or RBI"
           value="{{ old('search', request('search')) }}"
           style="padding:.4rem .6rem;border-radius:6px;border:1px solid #e5e7eb; width:400px;" />

    {{-- Search Icon Button --}}
    <button type="submit" class="btn btn-ghost" title="Search" 
            style="padding:.4rem .6rem;display:flex;align-items:center;justify-content:center">
      🔍
    </button>

    {{-- Clear Icon Button (only show if active) --}}
    @if(request()->has('search') || request()->has('purok') || request()->has('filter'))
      <a href="{{ route('residents.index') }}" class="btn btn-ghost" title="Clear Search"
         style="padding:.4rem .6rem;display:flex;align-items:center;justify-content:center">
        ✖
      </a>
    @endif
  </div>
</form>


  <div class="table-wrap border rounded">
    <table style="width:100%;border-collapse:collapse;font-size:.95rem">
      <thead style="background:#f8fafc">
        <tr>
          <th style="padding:.6rem;text-align:left">ID</th>
          <th style="padding:.6rem;text-align:left">Full Name</th>
          <th style="padding:.6rem;text-align:left">Birthday</th>
          <th style="padding:.6rem;text-align:left">Age</th>
          <th style="padding:.6rem;text-align:left">Gender</th>
          <th style="padding:.6rem;text-align:left">Civil Status</th>
          <th style="padding:.6rem;text-align:left">RBI No</th>
          <th style="padding:.6rem;text-align:left">Purok</th>
          <th style="padding:.6rem;text-align:left">Solo Parent</th>
          <th style="padding:.6rem;text-align:left">Disability</th>
          <th style="padding:.6rem;text-align:left">Maternal</th>
          <th style="padding:.6rem;text-align:left">Remarks</th>
          <th style="padding:.6rem;text-align:left">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($residents as $r)
          <tr style="border-top:1px solid #eef2f7">
            <td style="padding:.6rem">{{ $r->id }}</td>
            <td style="padding:.6rem">{{ $r->fullname ?? trim($r->firstname . ' ' . ($r->middlename ?: '') . ' ' . $r->surname) }}</td>
            <td style="padding:.6rem">{{ $r->birthday ? \Carbon\Carbon::parse($r->birthday)->format('m/d/Y') : '' }}</td>
            <td style="padding:.6rem">{{ $r->age }}</td>
            <td style="padding:.6rem">{{ $r->gender }}</td>
            <td style="padding:.6rem">{{ $r->civil_status }}</td>
            <td style="padding:.6rem">{{ $r->rbi_no }}</td>
            <td style="padding:.6rem">{{ $r->purok }}</td>
            <td style="padding:.6rem">{{ $r->solo_parent }}</td>
            <td style="padding:.6rem">{{ $r->type_of_disability }}</td>
            <td style="padding:.6rem">{{ $r->maternal_status }}</td>
            <td style="padding:.6rem">{{ $r->remark }}</td>
            <td style="padding:.6rem">
              <button type="button" onclick='openEditModal(@json($r))' class="btn btn-warning">Edit</button>
              <button type="button" onclick="openDeleteModal({{ $r->id }})" class="btn btn-danger">Delete</button>
            </td>
          </tr>
        @empty
          <tr><td colspan="13" style="text-align:center;padding:1rem;color:#6b7280">No residents</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

{{-- PAGINATION (auto adjust by 20 pages each set) --}}
<div class="pagination-container">
  <div class="pagination-numbers">
    <ul>
      {{-- Previous Button --}}
      @if ($residents->onFirstPage())
        <li class="disabled" ><span>« Previous</span></li>
      @else
        <li><a href="{{ $residents->previousPageUrl() }}">« Previous</a></li>
      @endif

      {{-- Numbered Links (group of 20) --}}
      @php
        $current = $residents->currentPage();
        $totalPages = $residents->lastPage();
        $groupStart = floor(($current - 1) / 20) * 20 + 1;
        $groupEnd = min($groupStart + 19, $totalPages);
      @endphp

      @for ($i = $groupStart; $i <= $groupEnd; $i++)
        <li class="{{ $current == $i ? 'active' : '' }}">
          <a href="{{ $residents->url($i) }}">{{ $i }}</a>
        </li>
      @endfor

      {{-- Next Button --}}
      @if ($residents->hasMorePages())
        <li><a href="{{ $residents->nextPageUrl() }}">Next »</a></li>
      @else
        <li class="disabled"><span>Next »</span></li>
      @endif
    </ul>
  </div>

  {{-- Showing X to Y of Z --}}
  <div class="pagination-info">
    <p>
      Showing
      {{ $residents->firstItem() }}
      to
      {{ $residents->lastItem() }}
      of
      {{ $residents->total() }}
      results
    </p>
  </div>
</div>


{{-- ADD modal --}}
<div id="addModal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="modal-dialog" role="document" tabindex="-1">
    <h2 style="margin:0 0 .6rem 0;font-size:1.05rem;font-weight:600">Add Resident</h2>
    <form id="addForm" action="{{ route('residents.store') }}" method="POST" novalidate>
      @csrf
      <div class="form-grid">
        <input name="firstname" value="{{ old('firstname') }}" placeholder="First Name" required>
        <input name="middlename" value="{{ old('middlename') }}" placeholder="Middle Name">
        <input name="surname" value="{{ old('surname') }}" placeholder="Surname" required>
        <input name="suffix" value="{{ old('suffix') }}" placeholder="Suffix">
        <input type="date" name="birthday" id="add_birthday" value="{{ old('birthday') }}" required>
        <input type="number" name="age" id="add_age" value="{{ old('age') }}" placeholder="Age" readonly>
        <select name="gender"><option value="">Gender</option><option {{ old('gender')=='Male'?'selected':'' }}>Male</option><option {{ old('gender')=='Female'?'selected':'' }}>Female</option><option {{ old('gender')=='Other'?'selected':'' }}>Other</option></select>
        <select name="civil_status"><option value="">Civil Status</option><option {{ old('civil_status')=='Single'?'selected':'' }}>Single</option><option {{ old('civil_status')=='Married'?'selected':'' }}>Married</option><option {{ old('civil_status')=='Widowed'?'selected':'' }}>Widowed</option><option {{ old('civil_status')=='Separated'?'selected':'' }}>Separated</option><option {{ old('civil_status')=='Divorced'?'selected':'' }}>Divorced</option></select>
        <input name="rbi_no" value="{{ old('rbi_no') }}" placeholder="RBI No">
        <select name="purok" required>@for($i=1;$i<=5;$i++)<option value="Purok {{ $i }}" {{ old('purok')=="Purok $i" ? 'selected' : '' }}>Purok {{ $i }}</option>@endfor</select>
        <input name="solo_parent" value="{{ old('solo_parent') }}" placeholder="Solo Parent">
        <input name="type_of_disability" value="{{ old('type_of_disability') }}" placeholder="Disability">
        <select name="maternal_status"><option value="">Maternal Status</option><option {{ old('maternal_status')=='None'?'selected':'' }}>None</option><option {{ old('maternal_status')=='Pregnant'?'selected':'' }}>Pregnant</option><option {{ old('maternal_status')=='Lactating'?'selected':'' }}>Lactating</option><option {{ old('maternal_status')=='Both'?'selected':'' }}>Both</option></select>
        <textarea name="remark" class="col-span-2" placeholder="Remarks">{{ old('remark') }}</textarea>
      </div>

      <div style="display:flex;justify-content:flex-end;gap:.6rem;margin-top:.9rem">
        <button type="button" onclick="closeModal('addModal')" class="btn btn-ghost">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

{{-- EDIT modal --}}
<div id="editModal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="modal-dialog" role="document" tabindex="-1">
    <h2 style="margin:0 0 .6rem 0;font-size:1.05rem;font-weight:600">Edit Resident</h2>
    <form id="editForm" method="POST" action="#" novalidate>
      @csrf @method('PUT')
      <input type="hidden" id="edit_id" name="id" value="">
      <div class="form-grid">
        <input id="edit_firstname" name="firstname" required>
        <input id="edit_middlename" name="middlename">
        <input id="edit_surname" name="surname" required>
        <input id="edit_suffix" name="suffix">
        <input type="date" id="edit_birthday" name="birthday" required>
        <input type="number" id="edit_age" name="age" readonly>
        <select id="edit_gender" name="gender"><option value="">Gender</option><option>Male</option><option>Female</option><option>Other</option></select>
        <select id="edit_civil_status" name="civil_status"><option value="">Civil Status</option><option>Single</option><option>Married</option><option>Widowed</option><option>Separated</option><option>Divorced</option></select>
        <input id="edit_rbi_no" name="rbi_no">
        <select id="edit_purok" name="purok">@for($i=1;$i<=5;$i++)<option value="Purok {{ $i }}">Purok {{ $i }}</option>@endfor</select>
        <input id="edit_solo_parent" name="solo_parent">
        <input id="edit_type_of_disability" name="type_of_disability">
        <select id="edit_maternal_status" name="maternal_status"><option value="">Maternal Status</option><option>None</option><option>Pregnant</option><option>Lactating</option><option>Both</option></select>
        <textarea id="edit_remark" name="remark" class="col-span-2"></textarea>
      </div>

      <div style="display:flex;justify-content:flex-end;gap:.6rem;margin-top:.9rem">
        <button type="button" onclick="closeModal('editModal')" class="btn btn-ghost">Cancel</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>

{{-- DELETE modal --}}
<div id="deleteModal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="modal-dialog" style="max-width:420px">
    <h3 style="margin:0 0 .5rem 0;font-weight:600">Confirm Delete</h3>
    <p>Are you sure you want to delete this resident?</p>
    <form id="deleteForm" method="POST" class="mt-4">@csrf @method('DELETE')
      <div style="display:flex;justify-content:flex-end;gap:.6rem;margin-top:.6rem">
        <button type="button" onclick="closeModal('deleteModal')" class="btn btn-ghost">Cancel</button>
        <button type="submit" class="btn btn-danger">Delete</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openModal(id){
    document.querySelectorAll('.modal-overlay.show').forEach(m => { m.classList.remove('show'); m.setAttribute('aria-hidden','true'); });
    const m = document.getElementById(id); if(!m) return; m.classList.add('show'); m.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden';
    const first = m.querySelector('input,select,textarea,button'); if(first) first.focus();
  }
  function closeModal(id){ const m = document.getElementById(id); if(!m) return; m.classList.remove('show'); m.setAttribute('aria-hidden','true'); document.body.style.overflow='auto'; }
  document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ document.querySelectorAll('.modal-overlay.show').forEach(m=>{m.classList.remove('show');m.setAttribute('aria-hidden','true');}); document.body.style.overflow='auto'; }});
  document.querySelectorAll('.modal-overlay').forEach(modal=> modal.addEventListener('click', function(e){ if(e.target===modal){ modal.classList.remove('show'); modal.setAttribute('aria-hidden','true'); document.body.style.overflow='auto'; } }));

  function calculateAgeFromDate(dateString){
    if(!dateString) return '';
    const dob = new Date(dateString);
    if(isNaN(dob)) return '';
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const m = today.getMonth() - dob.getMonth();
    if(m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
    return age >= 0 ? age : '';
  }

  function wireBirthdayAge(){
    const addBirthday = document.getElementById('add_birthday'), addAge = document.getElementById('add_age');
    if(addBirthday && addAge){
      addBirthday.addEventListener('change', ()=> addAge.value = calculateAgeFromDate(addBirthday.value));
      if(addBirthday.value) addAge.value = calculateAgeFromDate(addBirthday.value);
      document.getElementById('addForm')?.addEventListener('submit', ()=> addAge.value = calculateAgeFromDate(addBirthday.value));
    }
    const editBirthday = document.getElementById('edit_birthday'), editAge = document.getElementById('edit_age');
    if(editBirthday && editAge){
      editBirthday.addEventListener('change', ()=> editAge.value = calculateAgeFromDate(editBirthday.value));
      if(editBirthday.value) editAge.value = calculateAgeFromDate(editBirthday.value);
      document.getElementById('editForm')?.addEventListener('submit', ()=> editAge.value = calculateAgeFromDate(editBirthday.value));
    }
  }

  function removeLargeDecorativeElements() {
    // remove large SVGs or absolutely positioned large elements that overlap the UI
    const candidates = Array.from(document.querySelectorAll('svg, .decorative, .hero-chevron, .big-arrow, .site-hero, .hero, .hero-svg, .header-graphic, .site-header-graphic, .background-arrow'));
    candidates.forEach(el => {
      try {
        const style = getComputedStyle(el);
        const rect = el.getBoundingClientRect ? el.getBoundingClientRect() : { width: 0, height: 0 };
        // remove if very large or positioned absolutely/fixed or has very large border radius arrow look
        if (rect.width > 300 || rect.height > 300 || style.position === 'fixed' || style.position === 'absolute' || style.zIndex && Number(style.zIndex) > 1000) {
          el.remove();
        }
      } catch (e) {
        // ignore
        try { el.remove(); } catch(_) {}
      }
    });

    // also remove any inline <svg> that's visually huge
    document.querySelectorAll('svg').forEach(s => {
      const r = s.getBoundingClientRect ? s.getBoundingClientRect() : { width:0, height:0 };
      if (r.width > 400 || r.height > 400) s.remove();
    });
  }

  function openEditModal(resident){
    if(!resident || !resident.id) return;
    document.getElementById('editForm').action = "{{ url('residents') }}/" + encodeURIComponent(resident.id);
    document.getElementById('edit_id').value = resident.id ?? '';
    document.getElementById('edit_firstname').value = resident.firstname ?? '';
    document.getElementById('edit_middlename').value = resident.middlename ?? '';
    document.getElementById('edit_surname').value = resident.surname ?? '';
    document.getElementById('edit_suffix').value = resident.suffix ?? '';
    document.getElementById('edit_birthday').value = resident.birthday ? resident.birthday.split(' ')[0] : '';
    document.getElementById('edit_age').value = calculateAgeFromDate(document.getElementById('edit_birthday').value);
    document.getElementById('edit_gender').value = resident.gender ?? '';
    document.getElementById('edit_civil_status').value = resident.civil_status ?? '';
    document.getElementById('edit_rbi_no').value = resident.rbi_no ?? '';
    document.getElementById('edit_purok').value = resident.purok ?? '';
    document.getElementById('edit_solo_parent').value = resident.solo_parent ?? '';
    document.getElementById('edit_type_of_disability').value = resident.type_of_disability ?? '';
    document.getElementById('edit_maternal_status').value = resident.maternal_status ?? '';
    document.getElementById('edit_remark').value = resident.remark ?? '';
    openModal('editModal');
  }

  function openDeleteModal(id){
    document.getElementById('deleteForm').action = "{{ url('residents') }}/" + encodeURIComponent(id);
    openModal('deleteModal');
  }

  document.addEventListener('DOMContentLoaded', function(){
    // remove offending decoration first
    removeLargeDecorativeElements();
    wireBirthdayAge();

    @if($errors->any() && old('_method') == 'PUT' && old('id'))
      const residentFromOld = { id:"{{ old('id') }}",
        firstname:{!! json_encode(old('firstname')) !!},
        middlename:{!! json_encode(old('middlename')) !!},
        surname:{!! json_encode(old('surname')) !!},
        suffix:{!! json_encode(old('suffix')) !!},
        birthday:{!! json_encode(old('birthday')) !!},
        gender:{!! json_encode(old('gender')) !!},
        civil_status:{!! json_encode(old('civil_status')) !!},
        rbi_no:{!! json_encode(old('rbi_no')) !!},
        purok:{!! json_encode(old('purok')) !!},
        solo_parent:{!! json_encode(old('solo_parent')) !!},
        type_of_disability:{!! json_encode(old('type_of_disability')) !!},
        maternal_status:{!! json_encode(old('maternal_status')) !!},
        remark:{!! json_encode(old('remark')) !!}
      };
      openEditModal(residentFromOld);
    @elseif($errors->any() && old('_method') != 'PUT')
      openModal('addModal');
    @endif
  });
</script>
@endsection

