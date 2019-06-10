function getSessionUserId(){

    fetch('http://localhost/pixB/PiX-B/api.php', {
        method: 'get'
    })
    .then(response => {
      return response.json();
    })
    .then(responseJson => {
      console.log(responseJson['userId']);
      console.log("ceva");
    })
}


getSessionUserId();