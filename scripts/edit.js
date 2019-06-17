var canvas = document.getElementById("editedCanvas");
var image = document.getElementById("editedImage");

canvas.width = image.width;
canvas.height = image.height;

var context = canvas.getContext('2d');
var filterControls = document.querySelectorAll("input[type=range]");

var newCanvas = document.createElement("canvas");

newCanvas.width = canvas.width;
newCanvas.height = canvas.height;

var newContext = newCanvas.getContext('2d');


function scaleToFit(img){

    context.drawImage(img, 0, 0);
}

function updateHiddenCanvas(newW, newH){
    //draw image to hidden canvas for saving
    newContext.clearRect(0, 0, newW, newH);
    newContext.drawImage(canvas, 0, 0, newW, newH);
    //put hidden canvas blob in hidden form input to be sent to back-end
    hiddenInput.value = newCanvas.toDataURL("image/png");
}

function applyFilter(){
    var computedFilters = '';
    filterControls.forEach(function(item) {
        computedFilters += item.getAttribute('data-filter') + '(' + item.value + item.getAttribute('data-scale') + ') ';
    });
    context.clearRect(0,0,canvas.width,canvas.height);
    //apply filter    
    context.filter = computedFilters;
    //draw image to canvas
    context.drawImage(image, 0, 0);
    
    updateHiddenCanvas();
};

function addDownloadLink(){
    var link = document.createElement('a');
    
    link.innerHTML = 'download image';

    link.addEventListener('click', function(ev) {
        link.href = newCanvas.toDataURL();
        link.download = "mypainting.png";
}, false);
var bottomMenu = document.getElementById("bottomMenu");
bottomMenu.appendChild(link);
}

// addDownloadLink();
scaleToFit(image);