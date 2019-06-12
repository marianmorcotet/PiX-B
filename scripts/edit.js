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

    context.drawImage(image, 0, 0, image.width, image.height, 0, 0, canvas.width, canvas.height);

    
};

var bottomMenu = document.getElementById("bottomMenu");

context.drawImage(image, 0, 0);

var link = document.createElement('a');
    link.innerHTML = 'download image';
link.addEventListener('click', function(ev) {
    link.href = canvas.toDataURL();
    link.download = "mypainting.png";
}, false);
bottomMenu.appendChild(link);