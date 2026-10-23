const mapImagesSequence = [
    'assets/images/Map/Philippines.png',
    'assets/images/Map/mindanao.jpg',
    'assets/images/Map/Zamboanga del sur.jpg',
    'assets/images/Map/Lapuyan.gif',
    'assets/images/Map/san jose.png',
    'assets/images/Map/Legend.png',
];
let currentImageIndex = 0;

function updatePinVisibility() {
    var mainImage = document.getElementById('mainMapImage');
    var philPin = document.getElementById('philippinesPin');
    var minPin = document.getElementById('mindanaoPin');
    var lapPin = document.getElementById('lapuyanPin');
    var lapGifPin = document.getElementById('lapuyanGifPin');
    var sjPin = document.getElementById('sanJosePin');
    var purokPins = document.getElementById('purokPinsContainer');
    var landmarkPins = document.getElementById('landmarkPinsContainer');
    var overviewBtn = document.querySelector('.sm-overview-btn');
    
    if (mainImage) {
        var src = mainImage.getAttribute('src') || '';
        
        // Philippines Pin (only on Philippines.png)
        if (philPin) {
            philPin.style.display = src.includes('Philippines.png') ? 'flex' : 'none';
        }

        // Mindanao Pin (only on mindanao.jpg)
        if (minPin) {
            minPin.style.display = src.includes('mindanao.jpg') ? 'flex' : 'none';
        }

        // Lapuyan Pin (only on Zamboanga del sur.jpg)
        if (lapPin) {
            lapPin.style.display = src.includes('Zamboanga del sur.jpg') ? 'flex' : 'none';
        }

        // Lapuyan GIF Pin (only on Lapuyan.gif)
        if (lapGifPin) {
            lapGifPin.style.display = src.includes('Lapuyan.gif') ? 'flex' : 'none';
        }
        
        // San Jose Pin (only on san jose.png)
        if (sjPin) {
            sjPin.style.display = src.includes('san jose.png') ? 'flex' : 'none';
        }

        // 4 Purok Pins (only on Legend.png aerial view)
        if (purokPins) {
            purokPins.style.display = src.includes('Legend.png') ? 'block' : 'none';
        }

        // Landmark Pins (only on Legend.png aerial view)
        if (landmarkPins) {
            landmarkPins.style.display = src.includes('Legend.png') ? 'block' : 'none';
        }

        // Overview button text / icon
        if (overviewBtn) {
            if (src.includes('Purok')) {
                overviewBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Back to Aerial Map';
                overviewBtn.setAttribute('title', 'Return to Aerial Map with 4 Purok Pins');
            } else {
                overviewBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Overview Map';
                overviewBtn.setAttribute('title', 'Return to Map Overview');
            }
        }

        // On images with specific pins or on the final interactive legend, map image itself is not clickable
        if (src.includes('Philippines.png') || src.includes('mindanao.jpg') || src.includes('Zamboanga del sur.jpg') || src.includes('Lapuyan.gif') || src.includes('san jose.png') || src.includes('Legend.png')) {
            mainImage.style.cursor = 'default';
        } else {
            mainImage.style.cursor = 'pointer';
        }
    }
}

// Global function to reset map to default or return to aerial view
function resetMap() {
    var mainImage = document.getElementById('mainMapImage');
    
    if (mainImage) {
        var src = mainImage.getAttribute('src') || '';
        if (src.includes('Purok')) {
            // Return to Aerial Map with 4 pins
            showAerialMap();
        } else {
            // Reset to step 0
            currentImageIndex = 0;
            mainImage.src = mapImagesSequence[currentImageIndex];
            updatePinVisibility();
            
            // Hide all markers
            var allMarkers = document.querySelectorAll('.purok-markers');
            allMarkers.forEach(function(el) {
                el.style.display = 'none';
            });
            document.querySelectorAll('.sm-purok-badge').forEach(function(b) {
                b.classList.remove('active');
            });
        }
    }
}

// Global function to jump directly to Aerial View
function showAerialMap() {
    var mainImage = document.getElementById('mainMapImage');
    if (!mainImage) return;
    
    currentImageIndex = mapImagesSequence.indexOf('assets/images/Map/Legend.png');
    if (currentImageIndex === -1) currentImageIndex = 5;
    mainImage.src = mapImagesSequence[currentImageIndex];
    updatePinVisibility();
    
    // Hide all markers & remove active badge
    var allMarkers = document.querySelectorAll('.purok-markers');
    allMarkers.forEach(function(el) {
        el.style.display = 'none';
    });
    document.querySelectorAll('.sm-purok-badge').forEach(function(b) {
        b.classList.remove('active');
    });
}

// Global function to load a Purok image
function loadPurok(imgSrc, purokNum) {
    var mainImage = document.getElementById('mainMapImage');
    if (!mainImage || !imgSrc) return;
    
    mainImage.src = imgSrc;
    updatePinVisibility();
    
    // Hide all purok markers
    var allMarkers = document.querySelectorAll('.purok-markers');
    allMarkers.forEach(function(el) {
        el.style.display = 'none';
    });
    
    // Show selected purok markers
    var markerDiv = document.getElementById('markers-purok' + purokNum);
    if (markerDiv) markerDiv.style.display = 'block';
    
    // Set active state on corresponding badge
    document.querySelectorAll('.sm-purok-badge').forEach(function(b) {
        b.classList.remove('active');
        if (b.getAttribute('data-image') === imgSrc || b.textContent.trim() === 'Purok ' + purokNum) {
            b.classList.add('active');
        }
    });
}

// Global function to change map on Purok badge click
function changeMap(element) {
    var newSrc = element.getAttribute('data-image');
    var match = newSrc ? newSrc.match(/Purok\s*(\d+)/i) : null;
    var purokNum = match ? match[1] : '1';
    loadPurok(newSrc, purokNum);
}

document.addEventListener('DOMContentLoaded', function() {
    const philPin = document.getElementById('philippinesPin');
    const minPin = document.getElementById('mindanaoPin');
    const lapPin = document.getElementById('lapuyanPin');
    const lapGifPin = document.getElementById('lapuyanGifPin');
    const sjPin = document.getElementById('sanJosePin');
    const mainImage = document.getElementById('mainMapImage');
    const purokPins = document.querySelectorAll('.purok-map-pin');

    // Make sure initial state has correct pin visibility and cursor
    updatePinVisibility();

    // 4 Purok Map Pins Click Event (opens Purok 1-4 images)
    purokPins.forEach(function(pin) {
        function activatePurokPin(e) {
            if (e) e.stopPropagation();
            var imgSrc = pin.getAttribute('data-image');
            var purokNum = pin.getAttribute('data-purok');
            loadPurok(imgSrc, purokNum);
        }

        pin.addEventListener('click', activatePurokPin);
        pin.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                activatePurokPin(e);
            }
        });
    });

    // 1. Click handler for Pin on Philippines Map -> goes to mindanao.jpg
    if (philPin && mainImage) {
        philPin.addEventListener('click', function(e) {
            e.stopPropagation();
            currentImageIndex = mapImagesSequence.indexOf('assets/images/Map/mindanao.jpg');
            if (currentImageIndex === -1) currentImageIndex = 1;
            mainImage.src = mapImagesSequence[currentImageIndex];
            updatePinVisibility();
            
            var allMarkers = document.querySelectorAll('.purok-markers');
            allMarkers.forEach(function(el) {
                el.style.display = 'none';
            });
            document.querySelectorAll('.sm-purok-badge').forEach(function(b) {
                b.classList.remove('active');
            });
        });
    }

    // 2. Click handler for Pin on Mindanao Map -> goes to Zamboanga del sur.jpg
    if (minPin && mainImage) {
        minPin.addEventListener('click', function(e) {
            e.stopPropagation();
            currentImageIndex = mapImagesSequence.indexOf('assets/images/Map/Zamboanga del sur.jpg');
            if (currentImageIndex === -1) currentImageIndex = 2;
            mainImage.src = mapImagesSequence[currentImageIndex];
            updatePinVisibility();
            
            var allMarkers = document.querySelectorAll('.purok-markers');
            allMarkers.forEach(function(el) {
                el.style.display = 'none';
            });
            document.querySelectorAll('.sm-purok-badge').forEach(function(b) {
                b.classList.remove('active');
            });
        });
    }

    // 3. Click handler for Pin on Zamboanga del Sur Map -> goes to Lapuyan.gif
    if (lapPin && mainImage) {
        lapPin.addEventListener('click', function(e) {
            e.stopPropagation();
            currentImageIndex = mapImagesSequence.indexOf('assets/images/Map/Lapuyan.gif');
            if (currentImageIndex === -1) currentImageIndex = 3;
            mainImage.src = mapImagesSequence[currentImageIndex];
            updatePinVisibility();
            
            var allMarkers = document.querySelectorAll('.purok-markers');
            allMarkers.forEach(function(el) {
                el.style.display = 'none';
            });
            document.querySelectorAll('.sm-purok-badge').forEach(function(b) {
                b.classList.remove('active');
            });
        });
    }

    // 4. Click handler for Pin on Lapuyan GIF -> goes to san jose.png
    if (lapGifPin && mainImage) {
        lapGifPin.addEventListener('click', function(e) {
            e.stopPropagation();
            currentImageIndex = mapImagesSequence.indexOf('assets/images/Map/san jose.png');
            if (currentImageIndex === -1) currentImageIndex = 4;
            mainImage.src = mapImagesSequence[currentImageIndex];
            updatePinVisibility();
            
            var allMarkers = document.querySelectorAll('.purok-markers');
            allMarkers.forEach(function(el) {
                el.style.display = 'none';
            });
            document.querySelectorAll('.sm-purok-badge').forEach(function(b) {
                b.classList.remove('active');
            });
        });
    }

    // 5. Click handler for Pin on San Jose Map -> goes to Legend.png (Aerial Map with 4 pins)
    if (sjPin && mainImage) {
        sjPin.addEventListener('click', function(e) {
            e.stopPropagation();
            showAerialMap();
        });
    }

    // Click on main map image:
    // Only advances if NOT on images that require clicking pins/controls
    if (mainImage) {
        mainImage.addEventListener('click', function() {
            var src = mainImage.getAttribute('src') || '';
            if (src.includes('Philippines.png') || src.includes('mindanao.jpg') || src.includes('Zamboanga del sur.jpg') || src.includes('Lapuyan.gif') || src.includes('san jose.png') || src.includes('Legend.png')) {
                return; // User must click the Pin!
            }

            currentImageIndex = (currentImageIndex + 1) % mapImagesSequence.length;
            mainImage.src = mapImagesSequence[currentImageIndex];
            updatePinVisibility();
            
            var allMarkers = document.querySelectorAll('.purok-markers');
            allMarkers.forEach(function(el) {
                el.style.display = 'none';
            });
            document.querySelectorAll('.sm-purok-badge').forEach(function(b) {
                b.classList.remove('active');
            });
        });
    }

    // Handle House Marker Clicks using event delegation
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('house-marker')) {
            var modal = document.getElementById('householdModal');
            if (modal) {
                var houseNum = e.target.getAttribute('data-house');
                var husband = e.target.getAttribute('data-husband');
                var spouse = e.target.getAttribute('data-spouse');
                var imageSrc = e.target.getAttribute('data-image');
                var rawChildren = e.target.getAttribute('data-children');
                
                document.getElementById('modalHouseNumber').textContent = houseNum ? houseNum : 'N/A';
                document.getElementById('modalHusbandName').textContent = husband ? husband : 'N/A';
                document.getElementById('modalSpouseName').textContent = spouse ? spouse : 'N/A';
                
                var modalImg = document.getElementById('modalHouseImage');
                if (imageSrc) {
                    modalImg.src = imageSrc;
                } else {
                    modalImg.src = 'https://placehold.co/400x400/e2e8f0/64748b?text=No+Photo';
                }

                // Render children
                var childrenContainer = document.getElementById('modalChildrenList');
                if (childrenContainer) {
                    childrenContainer.innerHTML = '';
                    var childrenList = [];
                    try {
                        childrenList = JSON.parse(rawChildren || '[]');
                    } catch(err) {
                        childrenList = [];
                    }
                    if (Array.isArray(childrenList) && childrenList.length > 0) {
                        childrenList.forEach(function(child) {
                            var chip = document.createElement('div');
                            chip.className = 'child-badge-item';
                            
                            var dot = document.createElement('span');
                            dot.className = 'child-badge-dot';
                            
                            var textSpan = document.createElement('span');
                            textSpan.textContent = child;
                            
                            chip.appendChild(dot);
                            chip.appendChild(textSpan);
                            childrenContainer.appendChild(chip);
                        });
                    } else {
                        var noneSpan = document.createElement('span');
                        noneSpan.textContent = 'None listed';
                        noneSpan.style.color = '#94a3b8';
                        noneSpan.style.fontStyle = 'italic';
                        noneSpan.style.fontSize = '0.85rem';
                        childrenContainer.appendChild(noneSpan);
                    }
                }
                
                modal.style.display = 'flex';
            }
        }
    });

    // Close household modal when clicking on the backdrop
    var householdModal = document.getElementById('householdModal');
    if (householdModal) {
        householdModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    }
});

// ========================================================
// LANDMARK FUNCTIONS (OPEN MODAL & HIGHLIGHT ON MAP)
// ========================================================
function openLandmarkModal(pinEl) {
    if (!pinEl) return;
    var name = pinEl.getAttribute('data-name') || 'Landmark Details';
    var photo = pinEl.getAttribute('data-photo') || '';
    var desc = pinEl.getAttribute('data-desc') || '';
    var color = pinEl.getAttribute('data-color') || '#6366f1';
    var iconEl = pinEl.querySelector('.sm-landmark-icon-wrap i');
    var iconClass = iconEl ? iconEl.className : 'bi bi-geo-alt-fill';

    var modal = document.getElementById('landmarkModal');
    if (!modal) return;

    var titleEl = document.getElementById('lmTitle');
    var badgeWrap = document.getElementById('lmBadgeWrap');
    var badgeIcon = document.getElementById('lmBadgeIcon');
    var photoContainer = document.getElementById('lmPhotoContainer');
    var photoImg = document.getElementById('lmPhotoImg');
    var descEl = document.getElementById('lmDesc');

    if (titleEl) titleEl.textContent = name;
    if (badgeWrap) badgeWrap.style.backgroundColor = color;
    if (badgeIcon) badgeIcon.className = iconClass;

    if (photo && photo !== 'null' && photo.trim() !== '') {
        if (photoImg) photoImg.src = photo;
        if (photoContainer) photoContainer.style.display = 'flex';
    } else {
        if (photoContainer) photoContainer.style.display = 'none';
    }

    if (descEl) {
        descEl.textContent = desc ? desc : 'Official landmark in Barangay San Jose, Lapuyan, Zamboanga del Sur.';
    }

    modal.style.display = 'flex';
}

function closeLandmarkModal(e) {
    var modal = document.getElementById('landmarkModal');
    if (modal) modal.style.display = 'none';
}

function highlightLandmark(id) {
    var mainImage = document.getElementById('mainMapImage');
    var src = mainImage ? (mainImage.getAttribute('src') || '') : '';

    // Switch to aerial map if not currently on Legend.png
    if (!src.includes('Legend.png')) {
        showAerialMap();
    }

    var pin = document.getElementById('landmarkPin_' + id);
    if (pin) {
        document.querySelectorAll('.sm-landmark-pin').forEach(function(p) {
            p.classList.remove('highlight');
        });
        
        pin.classList.add('highlight');
        setTimeout(function() {
            pin.classList.remove('highlight');
        }, 3500);

        var photo = pin.getAttribute('data-photo');
        if (photo && photo !== 'null' && photo.trim() !== '') {
            openLandmarkModal(pin);
        }
    }
}

