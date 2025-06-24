function sendData(event){
  event.preventDefault();

  var MMSI = document.getElementById('MMSI').value;
  var horodatage = document.getElementById('horodatage').value;
  var latitude = document.getElementById('latitude').value;
  var longitude = document.getElementById('longitude').value;
  var sog = document.getElementById('SOG').value;
  var cog = document.getElementById('COG').value;
  var heading = document.getElementById('heading').value;
  var name = document.getElementById('name').value;
  var length = document.getElementById('length').value;
  var width = document.getElementById('width').value;
  var draft = document.getElementById('draft').value;
  var status = document.getElementById('status').value;
  
  let data = 'mmsi='+MMSI+'&horodatage='+horodatage+'&latitude='+latitude+'&longitude='+longitude+'&sog='+sog+'&cog='+cog+'&heading='+heading+'&name='+name+'&length='+length+'&width='+width+'&draft='+draft+'&status='+status
  ajaxRequest('POST','./php/request.php/addData', function(data){
    let error = document.getElementById('error');
    error.innerHTML = "<p>Nouvelle donnée <br> enregistrée <br></p>";
    error.style.color = "rgb(100, 255, 100, 0.8)";
    error.style.removeProperty('pointer-events')
    error.classList.add('show');
    setTimeout(function() {
        error.classList.remove('show');
    }, 8000);
  }, data);
}
