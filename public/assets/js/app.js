// Global JavaScript for the application

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize sidebar functionality
    initializeSidebar();
    
    // Initialize hazard checkboxes
    initializeHazardCheckboxes();
    
    // Initialize responsive behavior
    initializeResponsiveBehavior();
});

// Sidebar Functions
function initializeSidebar() {
    const sidebar = document.querySelector('.sidebar-container');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const contentArea = document.querySelector('.content-area');
    
    if (!sidebar) return;

    // Make sidebar visible by default
    sidebar.style.display = 'block';
    sidebar.classList.remove('hidden'); // Ensure sidebar starts visible
    
    // Add toggle functionality
    if (sidebarToggle) {
        console.log('Sidebar toggle button found, adding click listener');
        
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Sidebar toggle clicked');
            
            // Toggle sidebar visibility
            const isHidden = sidebar.classList.contains('hidden');
            
            if (isHidden) {
                // Show sidebar
                sidebar.classList.remove('hidden');
                if (contentArea) {
                    contentArea.classList.remove('sidebar-hidden');
                }
                console.log('Sidebar shown');
            } else {
                // Hide sidebar
                sidebar.classList.add('hidden');
                if (contentArea) {
                    contentArea.classList.add('sidebar-hidden');
                }
                console.log('Sidebar hidden');
            }
            
            // Trigger map resize if hazard map exists
            setTimeout(function() {
                if (window.hazardMap && window.hazardMap.invalidateSize) {
                    window.hazardMap.invalidateSize();
                }
            }, 300);
        });
    } else {
        console.log('Sidebar toggle button not found');
    }
    
    // Handle accordion state persistence
    const accordionButtons = document.querySelectorAll('.accordion-button');
    accordionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-bs-target');
            localStorage.setItem('accordion-' + target, this.classList.contains('collapsed') ? 'open' : 'closed');
        });
    });

    // Restore accordion states
    accordionButtons.forEach(button => {
        const target = button.getAttribute('data-bs-target');
        const state = localStorage.getItem('accordion-' + target);
        if (state === 'open') {
            button.click();
        }
    });
}

// Hazard Checkbox Functions
function initializeHazardCheckboxes() {
    const hazardCheckboxes = document.querySelectorAll('.hazard-checkbox');
    const purokCheckboxes = document.querySelectorAll('.purok-checkbox');
    
    hazardCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const hazardType = this.dataset.hazard;
            const isChecked = this.checked;
            
            console.log(`Hazard ${hazardType} ${isChecked ? 'enabled' : 'disabled'}`);
            
            // Here you would typically update map layers or filters
            updateHazardDisplay(hazardType, isChecked);
        });
    });
    
    purokCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const purokType = this.dataset.purok;
            const isChecked = this.checked;
            
            console.log(`Purok ${purokType} ${isChecked ? 'enabled' : 'disabled'}`);
            
            // Here you would typically update map layers
            updatePurokDisplay(purokType, isChecked);
        });
    });
}

// Hazard Display Functions
function updateHazardDisplay(hazardType, isEnabled) {
    // This function would typically interact with a map library like Leaflet
    // For now, we'll just update the legend
    updateLegend();
}

function updatePurokDisplay(purokType, isEnabled) {
    // This function would typically show/hide purok layers on a map
    console.log(`Updating purok display for ${purokType}: ${isEnabled}`);
}

function updateLegend() {
    const legendContainer = document.getElementById('hazard-legend');
    if (!legendContainer) return;
    
    const activeHazards = document.querySelectorAll('.hazard-checkbox:checked');
    
    // Clear existing legend items except static ones
    const dynamicItems = legendContainer.querySelectorAll('.legend-item.dynamic');
    dynamicItems.forEach(item => item.remove());
    
    // Add legend items for active hazards
    activeHazards.forEach(checkbox => {
        const hazardType = checkbox.dataset.hazard;
        const legendItem = createLegendItem(hazardType);
        legendContainer.appendChild(legendItem);
    });
}

function createLegendItem(hazardType) {
    const colors = {
        flood: '#0066ff',
        landslide: '#ff6600',
        volcanic: '#ff0000',
        ashfall: '#666666',
        lahar: '#996633',
        mudflow: '#cc9900',
        fire: '#ff3300',
        wind: '#00ccff'
    };
    
    const item = document.createElement('div');
    item.className = 'legend-item dynamic';
    item.innerHTML = `
        <span class="legend-color" style="background-color: ${colors[hazardType] || '#666666'};"></span>
        <span>${hazardType.charAt(0).toUpperCase() + hazardType.slice(1)}</span>
    `;
    
    return item;
}

// Responsive Behavior
function initializeResponsiveBehavior() {
    const sidebar = document.querySelector('.sidebar-container');
    const content = document.querySelector('.content-area');
    
    if (!sidebar || !content) return;
    
    function checkScreenSize() {
        if (window.innerWidth < 992) {
            // Mobile: Hide sidebar by default
            sidebar.style.transform = 'translateX(-100%)';
            content.style.marginLeft = '0';
        } else {
            // Desktop: Show sidebar
            sidebar.style.transform = 'translateX(0)';
            content.style.marginLeft = '280px';
        }
    }
    
    // Check on load and resize
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);
}

// Modal Functions
function showBarangayDataModal() {
    // Create and show a modal with barangay data
    const modalHtml = `
        <div class="modal fade" id="barangayDataModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-chart-bar me-2"></i>Barangay Data Overview
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Population Statistics</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Population</span>
                                        <strong>3,825</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Households</span>
                                        <strong>853</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Families</span>
                                        <strong>1,126</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>PWD Population</span>
                                        <strong>97</strong>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-success">Risk Assessment</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>High Risk Areas</span>
                                        <span class="badge bg-danger">5</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Medium Risk Areas</span>
                                        <span class="badge bg-warning">12</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Low Risk Areas</span>
                                        <span class="badge bg-success">8</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Evacuation Centers</span>
                                        <span class="badge bg-info">3</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='/home'">
                            View Detailed Dashboard
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('barangayDataModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('barangayDataModal'));
    modal.show();
    
    // Clean up modal after it's hidden
    document.getElementById('barangayDataModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Utility Functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 70px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar-container');
    const content = document.querySelector('.content-area');
    
    if (!sidebar || !content) return;
    
    if (sidebar.style.transform === 'translateX(-100%)') {
        sidebar.style.transform = 'translateX(0)';
        content.style.marginLeft = '280px';
    } else {
        sidebar.style.transform = 'translateX(-100%)';
        content.style.marginLeft = '0';
    }
}

// Export functions for global use
window.showBarangayDataModal = showBarangayDataModal;
window.showNotification = showNotification;
window.toggleSidebar = toggleSidebar;
