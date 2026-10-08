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
    var pin = document.getElementById('sanJosePin');
    if (mainImage && pin) {
        var src = mainImage.getAttribute('src');
        if (src === 'assets/images/Map/san jose.png') {
            pin.style.display = 'block';
        } else {
            pin.style.display = 'none';
        }
    }
}

// Global function to reset map to default
function resetMap() {
    var mainImage = document.getElementById('mainMapImage');
    
    if (mainImage) {
        currentImageIndex = 0;
        mainImage.src = mapImagesSequence[currentImageIndex];
        mainImage.style.cursor = 'pointer';
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
    const pin = document.getElementById('sanJosePin');
    const mainImage = document.getElementById('mainMapImage');

    if (mainImage) {
        mainImage.addEventListener('click', function() {
            currentImageIndex = (currentImageIndex + 1) % mapImagesSequence.length;
            mainImage.src = mapImagesSequence[currentImageIndex];
            updatePinVisibility();
            mainImage.style.cursor = 'pointer';
            
            // Hide all markers when cycling maps
            var allMarkers = document.querySelectorAll('.purok-markers');
            allMarkers.forEach(function(el) {
                el.style.display = 'none';
            });
        });
    }

    // Handle Pin Click
    if (pin && mainImage) {
        pin.addEventListener('click', function() {
            // Change the image source to Legend.png
            currentImageIndex = mapImagesSequence.indexOf('assets/images/Map/Legend.png');
            if (currentImageIndex === -1) currentImageIndex = 5;
            mainImage.src = mapImagesSequence[currentImageIndex];
            mainImage.style.cursor = 'pointer';
            updatePinVisibility();
            
            // Hide all markers when viewing legend
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
                // Get data from clicked marker
                var houseNum = e.target.getAttribute('data-house');
                var husband = e.target.getAttribute('data-husband');
                var spouse = e.target.getAttribute('data-spouse');
                var imageSrc = e.target.getAttribute('data-image');
                
                // Set data to modal elements
                document.getElementById('modalHouseNumber').textContent = houseNum ? houseNum : 'N/A';
                document.getElementById('modalHusbandName').textContent = husband ? husband : 'N/A';
                document.getElementById('modalSpouseName').textContent = spouse ? spouse : 'N/A';
                
                var modalImg = document.getElementById('modalHouseImage');
                if (imageSrc) {
                    modalImg.src = imageSrc;
                } else {
                    modalImg.src = 'https://placehold.co/400x400/e2e8f0/64748b?text=No+Photo';
                }
                
                // Show modal
                modal.style.display = 'flex';
            }
        }
    });
});
