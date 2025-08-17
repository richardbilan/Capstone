<div class="accordion bg-dark text-white" id="sidebarAccordion">

    <!-- Barangay Map Link -->
    <div class="p-2">
        <a class="nav-link text-white" href="/">
            <i class="fas fa-map-marked-alt me-2"></i>Barangay Hazard Map
        </a>
    </div>

    <!-- All Hazards Section -->
    <div class="accordion-item bg-dark border-0">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHazards">
                <i class="fas fa-warning me-2"></i>All Hazards
            </button>
        </h2>
        <div id="collapseHazards" class="accordion-collapse collapse">
            <div class="accordion-body text-white">
                <div class="form-check">
                    <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardFlood" data-hazard="flood">
                    <label class="form-check-label" for="hazardFlood">
                        <i class="fas fa-water text-primary me-2"></i>Flood
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardLandslide" data-hazard="landslide">
                    <label class="form-check-label" for="hazardLandslide">
                        <i class="fas fa-mountain text-warning me-2"></i>Landslide
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardFire" data-hazard="fire">
                    <label class="form-check-label" for="hazardFire">
                        <i class="fas fa-fire text-danger me-2"></i>Fire
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardAshfall" data-hazard="ashfall">
                    <label class="form-check-label" for="hazardAshfall">
                        <i class="fas fa-cloud text-secondary me-2"></i>Ashfall
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardLahar" data-hazard="lahar">
                    <label class="form-check-label" for="hazardLahar">
                        <i class="fas fa-tint text-dark me-2"></i>Lahar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardMudflow" data-hazard="mudflow">
                    <label class="form-check-label" for="hazardMudflow">
                        <i class="fas fa-water text-success me-2"></i>Mudflow
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardWind" data-hazard="wind">
                    <label class="form-check-label" for="hazardWind">
                        <i class="fas fa-wind text-info me-2"></i>Wind
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>