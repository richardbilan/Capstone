// User Dashboard JavaScript
class UserDashboard {
    constructor() {
        this.currentTab = 'maps';
        this.map = null;
        this.hazardLayers = {};
        this.activeHazards = ['all'];
        this.init();
    }

    init() {
        this.setupTabNavigation();
        this.setupMap();
        this.setupTicketForm();
        this.setupNotifications();
        this.setupHazardControls();
        this.loadInitialData();
    }

    // Tab Navigation
    setupTabNavigation() {
        const navLinks = document.querySelectorAll('[data-tab]');
        const tabContents = document.querySelectorAll('.tab-content');

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetTab = link.dataset.tab;
                
                // Update active nav link
                navLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
                
                // Update active tab content
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });
                document.getElementById(`${targetTab}-tab`).classList.add('active');
                
                this.currentTab = targetTab;
                
                // Resize map if switching to maps tab
                if (targetTab === 'maps' && this.map) {
                    setTimeout(() => this.map.invalidateSize(), 100);
                }
            });
        });
    }

    // Map Setup
    setupMap() {
        // Initialize map
        this.map = L.map('disaster-map').setView([13.1421, 123.6857], 15);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);

        // Add main marker
        L.marker([13.1421, 123.6857])
            .addTo(this.map)
            .bindPopup("<strong>Barangay Ilawod</strong><br>Camalig, Albay")
            .openPopup();

        // Initialize hazard layers
        this.initializeHazardLayers();
    }

    // Initialize hazard layers with sample data
    initializeHazardLayers() {
        const hazardData = {
            flood: [
                {
                    name: "Riverside Flood Zone",
                    coordinates: [[13.1435, 123.6840], [13.1430, 123.6865], [13.1415, 123.6870], [13.1410, 123.6845], [13.1435, 123.6840]],
                    riskLevel: "High",
                    color: "#0066CC",
                    fillColor: "#4DA6FF"
                }
            ],
            landslide: [
                {
                    name: "Hillside Risk Area",
                    coordinates: [[13.1445, 123.6875], [13.1440, 123.6885], [13.1430, 123.6880], [13.1435, 123.6870], [13.1445, 123.6875]],
                    riskLevel: "High",
                    color: "#8B4513",
                    fillColor: "#CD853F"
                }
            ],
            fire: [
                {
                    name: "Dense Residential Area",
                    coordinates: [[13.1425, 123.6860], [13.1420, 123.6875], [13.1410, 123.6870], [13.1415, 123.6855], [13.1425, 123.6860]],
                    riskLevel: "High",
                    color: "#FF0000",
                    fillColor: "#FF4444"
                }
            ]
        };

        // Create layer groups for each hazard type
        Object.keys(hazardData).forEach(hazardType => {
            this.hazardLayers[hazardType] = L.layerGroup();
            
            hazardData[hazardType].forEach(zone => {
                const polygon = L.polygon(zone.coordinates, {
                    color: zone.color,
                    fillColor: zone.fillColor,
                    fillOpacity: 0.4,
                    weight: 2
                }).bindPopup(`<strong>${zone.name}</strong><br>Risk Level: ${zone.riskLevel}`);
                
                this.hazardLayers[hazardType].addLayer(polygon);
            });
        });

        // Show all hazards initially
        this.showAllHazards();
    }

    // Hazard control setup
    setupHazardControls() {
        const hazardButtons = document.querySelectorAll('.hazard-btn');
        const evacCentersBtn = document.getElementById('evacCentersBtn');
        const landmarksBtn = document.getElementById('landmarksBtn');

        hazardButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const hazardType = btn.dataset.hazard;
                
                // Update button states
                hazardButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                // Update map display
                if (hazardType === 'all') {
                    this.showAllHazards();
                } else {
                    this.showSpecificHazard(hazardType);
                }
            });
        });

        // Evacuation centers toggle
        evacCentersBtn.addEventListener('click', () => {
            evacCentersBtn.classList.toggle('active');
            this.toggleEvacuationCenters(evacCentersBtn.classList.contains('active'));
        });

        // Landmarks toggle
        landmarksBtn.addEventListener('click', () => {
            landmarksBtn.classList.toggle('active');
            this.toggleLandmarks(landmarksBtn.classList.contains('active'));
        });
    }

    showAllHazards() {
        // Clear all layers first
        Object.keys(this.hazardLayers).forEach(type => {
            if (this.map.hasLayer(this.hazardLayers[type])) {
                this.map.removeLayer(this.hazardLayers[type]);
            }
        });

        // Add all hazard layers
        Object.keys(this.hazardLayers).forEach(type => {
            this.map.addLayer(this.hazardLayers[type]);
        });
    }

    showSpecificHazard(hazardType) {
        // Clear all layers first
        Object.keys(this.hazardLayers).forEach(type => {
            if (this.map.hasLayer(this.hazardLayers[type])) {
                this.map.removeLayer(this.hazardLayers[type]);
            }
        });

        // Add specific hazard layer
        if (this.hazardLayers[hazardType]) {
            this.map.addLayer(this.hazardLayers[hazardType]);
        }
    }

    toggleEvacuationCenters(show) {
        if (show) {
            // Add evacuation center markers
            const centers = [
                { lat: 13.1421, lng: 123.6857, name: "Ilawod Elementary School" },
                { lat: 13.1435, lng: 123.6890, name: "Barangay Hall" },
                { lat: 13.1410, lng: 123.6845, name: "Ilawod Chapel" }
            ];

            if (!this.evacuationLayer) {
                this.evacuationLayer = L.layerGroup();
                
                centers.forEach(center => {
                    const marker = L.marker([center.lat, center.lng], {
                        icon: L.divIcon({
                            className: 'evacuation-marker',
                            html: '🏫',
                            iconSize: [30, 30],
                            iconAnchor: [15, 15]
                        })
                    }).bindPopup(`<strong>${center.name}</strong><br>Evacuation Center`);
                    
                    this.evacuationLayer.addLayer(marker);
                });
            }
            
            this.map.addLayer(this.evacuationLayer);
        } else {
            if (this.evacuationLayer) {
                this.map.removeLayer(this.evacuationLayer);
            }
        }
    }

    toggleLandmarks(show) {
        if (show) {
            // Add landmark markers
            const landmarks = [
                { lat: 13.1410, lng: 123.6845, name: "Ilawod Chapel", icon: "⛪" },
                { lat: 13.1435, lng: 123.6890, name: "Barangay Hall", icon: "🏛️" },
                { lat: 13.1440, lng: 123.6850, name: "Road Sign", icon: "🛣️" }
            ];

            if (!this.landmarksLayer) {
                this.landmarksLayer = L.layerGroup();
                
                landmarks.forEach(landmark => {
                    const marker = L.marker([landmark.lat, landmark.lng], {
                        icon: L.divIcon({
                            className: 'landmark-marker',
                            html: landmark.icon,
                            iconSize: [25, 25],
                            iconAnchor: [12, 12]
                        })
                    }).bindPopup(`<strong>${landmark.name}</strong>`);
                    
                    this.landmarksLayer.addLayer(marker);
                });
            }
            
            this.map.addLayer(this.landmarksLayer);
        } else {
            if (this.landmarksLayer) {
                this.map.removeLayer(this.landmarksLayer);
            }
        }
    }

    // Ticket Form Setup
    setupTicketForm() {
        const ticketForm = document.getElementById('ticketForm');
        
        ticketForm.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitTicket();
        });
    }

    submitTicket() {
        const formData = {
            type: document.getElementById('ticketType').value,
            location: document.getElementById('ticketLocation').value,
            subject: document.getElementById('ticketSubject').value,
            message: document.getElementById('ticketMessage').value,
            priority: document.getElementById('ticketPriority').value
        };

        // Validate form
        if (!formData.type || !formData.subject || !formData.message || !formData.priority) {
            this.showAlert('Please fill in all required fields.', 'warning');
            return;
        }

        // Show loading state
        const submitBtn = document.querySelector('#ticketForm button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
        submitBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            // Generate ticket ID
            const ticketId = 'TK-' + new Date().getFullYear() + '-' + String(Math.floor(Math.random() * 1000)).padStart(3, '0');
            
            // Add ticket to list
            this.addTicketToList(formData, ticketId);
            
            // Reset form
            document.getElementById('ticketForm').reset();
            
            // Show success message
            this.showAlert(`Ticket ${ticketId} submitted successfully!`, 'success');
            
            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    }

    addTicketToList(ticketData, ticketId) {
        const ticketList = document.querySelector('.ticket-list');
        const priorityColors = {
            low: 'success',
            medium: 'warning',
            high: 'danger',
            critical: 'danger'
        };

        const ticketHtml = `
            <div class="ticket-item">
                <div class="ticket-header">
                    <span class="badge bg-${priorityColors[ticketData.priority]}">${ticketData.priority.charAt(0).toUpperCase() + ticketData.priority.slice(1)}</span>
                    <small class="text-muted">Just now</small>
                </div>
                <h6>${ticketData.subject}</h6>
                <p class="ticket-desc">${ticketData.message}</p>
                <div class="ticket-status">
                    <span class="badge bg-secondary">Pending</span>
                    <span class="ticket-id">#${ticketId}</span>
                </div>
            </div>
        `;

        ticketList.insertAdjacentHTML('afterbegin', ticketHtml);
    }

    // Notifications Setup
    setupNotifications() {
        const markAllReadBtn = document.getElementById('markAllRead');
        
        markAllReadBtn.addEventListener('click', () => {
            this.markAllNotificationsRead();
        });

        // Setup individual notification clicks
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', () => {
                this.markNotificationRead(item);
            });
        });
    }

    markAllNotificationsRead() {
        const unreadNotifications = document.querySelectorAll('.notification-item.unread');
        unreadNotifications.forEach(item => {
            item.classList.remove('unread');
        });

        // Update notification count
        document.getElementById('notifCount').textContent = '0';
        
        this.showAlert('All notifications marked as read.', 'info');
    }

    markNotificationRead(notificationItem) {
        if (notificationItem.classList.contains('unread')) {
            notificationItem.classList.remove('unread');
            
            // Update count
            const countElement = document.getElementById('notifCount');
            const currentCount = parseInt(countElement.textContent);
            countElement.textContent = Math.max(0, currentCount - 1);
        }
    }

    // Utility function to show alerts
    showAlert(message, type = 'info') {
        const alertContainer = document.createElement('div');
        alertContainer.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertContainer.style.cssText = `
            top: 90px;
            right: 20px;
            z-index: 1060;
            min-width: 300px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        `;
        
        alertContainer.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertContainer);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertContainer.parentNode) {
                alertContainer.remove();
            }
        }, 5000);
    }

    // Load initial data
    loadInitialData() {
        // Show emergency banner if there are active alerts
        this.checkEmergencyAlerts();
        
        // Update notification count
        this.updateNotificationCount();
    }

    checkEmergencyAlerts() {
        // Check for emergency notifications
        const emergencyNotifications = document.querySelectorAll('.notification-item.emergency.unread');
        
        if (emergencyNotifications.length > 0) {
            const banner = document.querySelector('.emergency-banner');
            banner.classList.remove('d-none');
        }
    }

    updateNotificationCount() {
        const unreadCount = document.querySelectorAll('.notification-item.unread').length;
        document.getElementById('notifCount').textContent = unreadCount;
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new UserDashboard();
});

// Additional utility functions
function formatTimeAgo(date) {
    const now = new Date();
    const diff = now - date;
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);
    
    if (minutes < 60) {
        return `${minutes} minutes ago`;
    } else if (hours < 24) {
        return `${hours} hours ago`;
    } else {
        return `${days} days ago`;
    }
}

// Handle responsive behavior
window.addEventListener('resize', () => {
    // Adjust map controls on mobile
    const mapControls = document.querySelector('.map-controls');
    if (window.innerWidth < 768) {
        mapControls.style.flexDirection = 'column';
    } else {
        mapControls.style.flexDirection = 'row';
    }
});

// Service Worker registration for offline support (optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('SW registered: ', registration);
            })
            .catch(registrationError => {
                console.log('SW registration failed: ', registrationError);
            });
    });
}