const mapImagesSequence = [
    'assets/images/Map/mindanao.jpg',
    'assets/images/Map/Zamboanga del sur.jpg',
    'assets/images/Map/Lapuyan.gif',
    'assets/images/Map/san jose.png',
    'assets/images/Map/ChatGPT Image Oct 6, 2026, 08_49_30 AM.png',
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
    }
}

// Global function to change map on Purok click
function changeMap(element) {
    var newSrc = element.getAttribute('data-image');
    var mainImage = document.getElementById('mainMapImage');
    
    if (newSrc && mainImage) {
        mainImage.src = newSrc;
        updatePinVisibility();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const pin = document.getElementById('sanJosePin');
    const mainImage = document.getElementById('mainMapImage');

    if (mainImage) {
        mainImage.addEventListener('click', function() {
            if (currentImageIndex < mapImagesSequence.length - 1) {
                currentImageIndex++;
                mainImage.src = mapImagesSequence[currentImageIndex];
                updatePinVisibility();
                
                if (currentImageIndex === mapImagesSequence.length - 1) {
                    mainImage.style.cursor = 'default';
                }
            }
        });
    }

    // Handle Pin Click
    if (pin && mainImage) {
        pin.addEventListener('click', function() {
            // Change the image source to ChatGPT Image
            currentImageIndex = mapImagesSequence.indexOf('assets/images/Map/ChatGPT Image Oct 6, 2026, 08_49_30 AM.png');
            if (currentImageIndex === -1) currentImageIndex = 4;
            mainImage.src = mapImagesSequence[currentImageIndex];
            mainImage.style.cursor = 'pointer';
            updatePinVisibility();
        });
    }
});
