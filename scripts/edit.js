var canvas = document.getElementById("editedCanvas");
var image = document.getElementById("editedImage");
var context = canvas.getContext('2d');
var filterControls = document.querySelectorAll("input[type=range]");

function scaleToFit(img){
    // get the scale
    var scale = Math.min(canvas.width / img.width, canvas.height / img.height);
    // get the top left position of the image
    var x = (canvas.width / 2) - (img.width / 2) * scale;
    var y = (canvas.height / 2) - (img.height / 2) * scale;
    context.drawImage(img, x, y, img.width * scale, img.height * scale);
}

function applyFilter(){
    var computedFilters = '';
    filterControls.forEach(function(item) {
        computedFilters += item.getAttribute('data-filter') + '(' + item.value + item.getAttribute('data-scale') + ') ';
    });
    context.clearRect(0,0,canvas.width,canvas.height);
    context.filter = computedFilters;

    scaleToFit(image);

    hiddenInput.value = canvas.toDataURL("image/png");
};

function addDownloadLink(){
    var link = document.createElement('a');
    link.innerHTML = 'download image';
    link.addEventListener('click', function(ev) {
    link.href = canvas.toDataURL();
    link.download = "mypainting.png";
}, false);
var bottomMenu = document.getElementById("bottomMenu");
bottomMenu.appendChild(link);
}

addDownloadLink();
scaleToFit(image);