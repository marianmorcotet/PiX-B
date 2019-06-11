var image = document.getElementById("editedImage");
var filterControls = document.querySelectorAll("input[type=range]");
function applyFilter(){
    var computedFilters = '';
    filterControls.forEach(function(item) {
        computedFilters += item.getAttribute('data-filter') + '(' + item.value + item.getAttribute('data-scale') + ') ';
    });
    image.style.filter = computedFilters;
};