function getSessionUserId(){
    fetch('http://localhost/pixB/PiX-B/api.php?x=userId', {
      method: 'GET',
    })
    .then(response => {;
      return response.json();
    })
    .then(responseJson => {
      return responseJson;
    })
}

function requestUserNameFromServer(callback){
  fetch('http://localhost/pixB/PiX-B/api.php?x=userName', {
      method: 'GET',
    })
    .then(response => {;
      return response.json();
    })
    .then(responseJson => {
      console.log(responseJson);
      callback(responseJson['userName']);
    })

}

function updateInfo(username){
  var title = document.getElementById("galleryTitle");
  title.textContent = username;
}


var username = requestUserNameFromServer(updateInfo);
var userid = getSessionUserId();

