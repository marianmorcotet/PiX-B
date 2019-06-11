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