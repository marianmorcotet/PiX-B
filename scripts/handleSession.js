function getSessionUserId(){
    fetch('http://localhost/pixB/PiX-B/api.php?x=userId', {
      method: 'GET',
    })
    .then(response => {
      console.warn(response);
      return response.json();
    })
    .then(responseJson => {
      console.log(responseJson);
    })

}


getSessionUserId();