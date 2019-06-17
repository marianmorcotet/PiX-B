var canvas = document.getElementById("editedCanvas");
var image = document.getElementById("editedImage");
var context = canvas.getContext('2d');
var filterControls = document.querySelectorAll("input[type=range]");


var newCanvas = document.createElement("canvas");
var imageWidth = 0;
var imageHeight = 0;

function scaleToFit(img){
    // get the scale
    var scale = Math.min(canvas.width / img.width, canvas.height / img.height);
    // get the top left position of the image
    var x = (canvas.width / 2) - (img.width / 2) * scale;
    var y = (canvas.height / 2) - (img.height / 2) * scale;
    context.drawImage(img, x, y, img.width * scale, img.height * scale);

    imageHeight = (img.height * scale) - y;
    imageWidth = (img.width * scale) - x;

    newCanvas.width = imageWidth;
    newCanvas.height = imageHeight;

    var newContext = newCanvas.getContext('2d');

    newContext.drawImage(canvas, x, y, img.width * scale, img.height * scale, 0, 0, newCanvas.width, newCanvas.height);
}

function applyFilter(){
    var computedFilters = '';
    filterControls.forEach(function(item) {
        computedFilters += item.getAttribute('data-filter') + '(' + item.value + item.getAttribute('data-scale') + ') ';
    });
    context.clearRect(0,0,canvas.width,canvas.height);
    context.filter = computedFilters;

    scaleToFit(image);

    hiddenInput.value = newCanvas.toDataURL("image/png");
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

addDownloadLink();
scaleToFit(image);