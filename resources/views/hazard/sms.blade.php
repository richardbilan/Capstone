@extends('layouts.app')

@section('hideSidebar', true)

@section('content')
<div class="container mt-4">
    <h2>SMS Notifications</h2>
    <p>Send and manage SMS alerts to residents. Use this tool to quickly notify the community during emergencies.</p>

    <div class="row">
        <!-- SMS Form -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <form>
                        <div class="mb-2">
                            <label class="form-label">Associated Name</label>
                            <input type="text" class="form-control" placeholder="Enter associated name">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Associated Alert</label>
                            <input type="text" class="form-control" placeholder="Enter associated alert">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Message Template</label>
                            <select class="form-select">
                                <option selected disabled>Select template from database</option>
                                {{-- @foreach($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Message Name</label>
                            <input type="text" class="form-control" placeholder="Enter message name">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="3" maxlength="160" placeholder="Enter SMS message"></textarea>
                        </div>
                        <div class="mb-2 text-muted small">
                            Maximum 160 characters per SMS, include essential information only.
                        </div>
                        <div class="card mb-3">
                            <div class="card-header fw-bold">Target Recipients</div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <label class="form-label">Purok</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="purok1" value="1">
                                        <label class="form-check-label" for="purok1">Purok 1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="purok2" value="2">
                                        <label class="form-check-label" for="purok2">Purok 2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="purok3" value="3">
                                        <label class="form-check-label" for="purok3">Purok 3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="purok4" value="4">
                                        <label class="form-check-label" for="purok4">Purok 4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="purok5" value="5">
                                        <label class="form-check-label" for="purok5">Purok 5</label>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Vulnerable Groups</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pwd" value="pwd">
                                        <label class="form-check-label" for="pwd">PWD</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pregnant" value="pregnant">
                                        <label class="form-check-label" for="pregnant">Pregnant</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="lactating" value="lactating">
                                        <label class="form-check-label" for="lactating">Lactating</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="senior" value="senior">
                                        <label class="form-check-label" for="senior">Senior Citizen</label>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Estimated Recipients</label>
                                    <input type="text" class="form-control" id="estimatedRecipients" value="0 contacts" readonly>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Send SMS</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- SMS Logs (Left Side) -->
        <div class="col-md-4">
            <button class="btn btn-dark w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#smsLogsCollapse" aria-expanded="false" aria-controls="smsLogsCollapse">
                View SMS Logs
            </button>
            <div class="collapse" id="smsLogsCollapse">
                <div class="card" style="background-color: #222; color: #fff;">
                    <div class="card-header fw-bold" style="background-color: #111;">SMS Logs</div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <!-- SMS logs will be dynamically loaded from the database after sending SMS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection