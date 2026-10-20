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

        // On images with specific pins or on the final interactive legend, map image itself is not clickable
        if (src.includes('Philippines.png') || src.includes('mindanao.jpg') || src.includes('Zamboanga del sur.jpg') || src.includes('Lapuyan.gif') || src.includes('san jose.png') || src.includes('Legend.png')) {
            mainImage.style.cursor = 'default';
        } else {
            mainImage.style.cursor = 'pointer';
        }
    }
}

// Global function to reset map to default (Philippines overview)
function resetMap() {
    var mainImage = document.getElementById('mainMapImage');
    
    if (mainImage) {
        currentImageIndex = 0;
        mainImage.src = mapImagesSequence[currentImageIndex];
        updatePinVisibility();
        
        // Hide all markers
        var allMarkers = document.querySelectorAll('.purok-markers');
        allMarkers.forEach(function(el) {
            el.style.display = 'none';
        });
    }
}

// Global function to change map on Purok click
function changeMap(element) {
    var newSrc = element.getAttribute('data-image');
    var mainImage = document.getElementById('mainMapImage');
    
    if (newSrc && mainImage) {
        mainImage.src = newSrc;
        updatePinVisibility();
        
        // Hide all purok markers
        var allMarkers = document.querySelectorAll('.purok-markers');
        allMarkers.forEach(function(el) {
            el.style.display = 'none';
        });
        
        // Check which purok is selected and show its markers
        if (newSrc.includes('Purok 1')) {
            var markerDiv = document.getElementById('markers-purok1');
            if(markerDiv) markerDiv.style.display = 'block';
        } else if (newSrc.includes('Purok 2')) {
            var markerDiv = document.getElementById('markers-purok2');
            if(markerDiv) markerDiv.style.display = 'block';
        } else if (newSrc.includes('Purok 3')) {
            var markerDiv = document.getElementById('markers-purok3');
            if(markerDiv) markerDiv.style.display = 'block';
        } else if (newSrc.includes('Purok 4')) {
            var markerDiv = document.getElementById('markers-purok4');
            if(markerDiv) markerDiv.style.display = 'block';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const philPin = document.getElementById('philippinesPin');
    const minPin = document.getElementById('mindanaoPin');
    const lapPin = document.getElementById('lapuyanPin');
    const lapGifPin = document.getElementById('lapuyanGifPin');
    const sjPin = document.getElementById('sanJosePin');
    const mainImage = document.getElementById('mainMapImage');

    // Make sure initial state has correct pin visibility and cursor
    updatePinVisibility();

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
        });
    }

    // 5. Click handler for Pin on San Jose Map -> goes to Legend.png
    if (sjPin && mainImage) {
        sjPin.addEventListener('click', function(e) {
            e.stopPropagation();
            currentImageIndex = mapImagesSequence.indexOf('assets/images/Map/Legend.png');
            if (currentImageIndex === -1) currentImageIndex = 5;
            mainImage.src = mapImagesSequence[currentImageIndex];
            updatePinVisibility();
            
            var allMarkers = document.querySelectorAll('.purok-markers');
            allMarkers.forEach(function(el) {
                el.style.display = 'none';
            });
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
                            var chip = document.createElement('span');
                            chip.textContent = child;
                            chip.style.display = 'inline-block';
                            chip.style.padding = '3px 8px';
                            chip.style.backgroundColor = '#f1f5f9';
                            chip.style.border = '1px solid #cbd5e1';
                            chip.style.borderRadius = '12px';
                            chip.style.fontSize = '0.85rem';
                            chip.style.color = '#334155';
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
