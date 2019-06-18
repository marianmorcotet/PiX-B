var canvas = document.getElementById("editedCanvas");
var image = document.getElementById("editedImage");
var hiddenInput = document.getElementById("hiddenInput");
var newCanvas = document.createElement("canvas");
var filterControls = document.querySelectorAll("input[type=range]");

function addTranslateButton() {
    var translateImageButton = document.getElementById("translateImageButton");
    translateImageButton.textContent = "Translate image";
    translateImageButton.addEventListener('click', update, false);
    var bottomMenu = document.getElementById("mainMenuRightTop");
    bottomMenu.appendChild(translateImageButton);
};

function init(){
    canvas.width = image.width;
    canvas.height = image.height;

    newCanvas.width = canvas.width;
    newCanvas.height = canvas.height;

    var context = canvas.getContext('2d');
    context.drawImage(image, 0, 0, canvas.width, canvas.height);
    
    addTranslateButton();
    addDownloadLink();
}

function updateHiddenCanvas() {
    newCanvas.width = canvas.width;
    newCanvas.height = canvas.height;

    var newContext = newCanvas.getContext('2d');
    newContext.clearRect(0, 0, newCanvas.width, newCanvas.height);

    newContext.drawImage(canvas, 0, 0, canvas.width, canvas.height, 0, 0, newCanvas.width, newCanvas.height);

    //put hidden canvas blob in hidden form input to be sent to back-end
    hiddenInput.value = newCanvas.toDataURL("image/png");
}

function update(){
    var newHeightInput = document.getElementById("newHeight");
    var newWidthInput = document.getElementById("newWidth");
    var newRotateInput = document.getElementById("newRotate");
    
    applyFilter(newWidthInput.value, newHeightInput.value, newRotateInput.value);

    updateHiddenCanvas(newWidthInput.value, newHeightInput.value, newRotateInput.value);
}

function applyFilter(newW=0, newH=0, newR=0){
    
    var computedFilters = '';
    filterControls.forEach(function(item) {
        computedFilters += item.getAttribute('data-filter') + '(' + item.value + item.getAttribute('data-scale') + ') ';
    });

    if((newW != 0) && (newH != 0)){
        canvas.width = newW;
        canvas.height = newH;
    }

    var context = canvas.getContext('2d');
    context.clearRect(0,0,canvas.width,canvas.height);    
    context.filter = computedFilters;

    if(newR != 0){
        context.translate(canvas.width/2, canvas.height/2);
        context.rotate(newR * Math.PI / 180);
        context.drawImage(image, -canvas.width / 2, -canvas.height / 2, canvas.width, canvas.height);

        context.rotate(-(newR * Math.PI / 180));
        context.translate(-canvas.width/2, -canvas.height/2)
    }else{
        //no rotation
        context.drawImage(image, 0, 0);
    }
    
};

function addDownloadLink(){
    var link = document.createElement('a');
    
    link.innerHTML = 'download';

    link.addEventListener('click', function(ev) {
        link.href = newCanvas.toDataURL();
        link.download = "mypainting.png";
}, false);

var bottomMenu = document.getElementById("mainMenuRightTop");
bottomMenu.appendChild(link);
};

init();
