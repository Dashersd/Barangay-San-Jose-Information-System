document.addEventListener('DOMContentLoaded', function() {
    const markerInput = document.getElementById('markerImage');
    const mapPreviewArea = document.getElementById('mapPreviewArea');
    const topInput = document.getElementById('topPosition');
    const leftInput = document.getElementById('leftPosition');
    const widthInput = document.getElementById('markerWidth');
    const heightInput = document.getElementById('markerHeight');
    
    let previewImg = null;
    let isDragging = false;
    
    // Listen for file selection
    if (markerInput) {
        markerInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!previewImg) {
                        previewImg = document.createElement('img');
                        previewImg.style.position = 'absolute';
                        previewImg.style.transform = 'translate(-50%, -50%)';
                        previewImg.style.cursor = 'move';
                        previewImg.style.zIndex = '100';
                        mapPreviewArea.appendChild(previewImg);
                        
                        // Setup dragging
                        previewImg.addEventListener('mousedown', startDrag);
                        previewImg.addEventListener('touchstart', startDrag, {passive: false});
                    }
                    
                    previewImg.src = e.target.result;
                    
                    // Set initial position and size from inputs
                    updatePreviewFromInputs();
                }
                reader.readAsDataURL(file);
            } else if (previewImg) {
                previewImg.remove();
                previewImg = null;
            }
        });
    }
    
    // Listen for manual input changes to width/height/position
    [topInput, leftInput, widthInput, heightInput].forEach(input => {
        if(input) {
            input.addEventListener('input', updatePreviewFromInputs);
        }
    });
    
    function updatePreviewFromInputs() {
        if (previewImg) {
            const width = widthInput.value || 40;
            const height = heightInput.value || 40;
            const top = topInput.value || 50;
            const left = leftInput.value || 50;
            
            previewImg.style.width = width + 'px';
            previewImg.style.height = height + 'px';
            previewImg.style.top = top + '%';
            previewImg.style.left = left + '%';
        }
    }
    
    function startDrag(e) {
        e.preventDefault();
        isDragging = true;
        
        document.addEventListener('mousemove', drag);
        document.addEventListener('touchmove', drag, {passive: false});
        document.addEventListener('mouseup', stopDrag);
        document.addEventListener('touchend', stopDrag);
    }
    
    function drag(e) {
        if (!isDragging) return;
        e.preventDefault();
        
        const rect = mapPreviewArea.getBoundingClientRect();
        
        // Handle both mouse and touch events
        let clientX = e.clientX;
        let clientY = e.clientY;
        if (e.touches && e.touches.length > 0) {
            clientX = e.touches[0].clientX;
            clientY = e.touches[0].clientY;
        }
        
        let x = clientX - rect.left;
        let y = clientY - rect.top;
        
        // Clamp to boundaries
        x = Math.max(0, Math.min(x, rect.width));
        y = Math.max(0, Math.min(y, rect.height));
        
        // Convert to percentages
        let leftPercent = (x / rect.width) * 100;
        let topPercent = (y / rect.height) * 100;
        
        // Update inputs
        if(leftInput) leftInput.value = leftPercent.toFixed(2);
        if(topInput) topInput.value = topPercent.toFixed(2);
        
        updatePreviewFromInputs();
    }
    
    function stopDrag() {
        isDragging = false;
        document.removeEventListener('mousemove', drag);
        document.removeEventListener('touchmove', drag);
        document.removeEventListener('mouseup', stopDrag);
        document.removeEventListener('touchend', stopDrag);
    }
});
