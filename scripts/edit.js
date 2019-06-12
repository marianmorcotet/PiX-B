var canvas = document.getElementById("editedCanvas");
var image = document.getElementById("editedImage");
var context = canvas.getContext('2d');
var filterControls = document.querySelectorAll("input[type=range]");


function applyFilter(){
    var computedFilters = '';
    filterControls.forEach(function(item) {
        computedFilters += item.getAttribute('data-filter') + '(' + item.value + item.getAttribute('data-scale') + ') ';
    });
    context.clearRect(0,0,canvas.width,canvas.height);
    context.filter = computedFilters;
    console.log(image.width);
    context.drawImage(image, 0, 0, image.width, image.height);
};


function loadImage(){
    window.innerWidth
    
    var canvas = document.getElementById("editedCanvas");
    var image = document.getElementById("editedImage");
    var width = image.width;
    var height = image.height;
    var maxWidth = canvas.width;
    var maxHeight = canvas.height;

    var ratio = maxWidth / width;
    if(height * ratio > maxHeight) {
        ratio = maxHeight / height;
    }
    image.width = width * ratio;
    image.height = height * ratio;

    console.log(image.width);

    context.drawImage(image, 0, 0, image.width, image.height);
}




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
loadImage();