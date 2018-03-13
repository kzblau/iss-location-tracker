<!DOCTYPE html>
<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=[YOUR_API_KEY]">
</script>
<style>
 #map {
  height: 400px;
  width: 50%;
}
</style>
</head>
<body>
  <h3>Current ISS Location</h3>
  <label for="latitude">Latitude</label>
  <input id="latitude" type="text" disabled></div>
  <label for="longitude">Longitude</label>
  <input id="longitude" type="text" disabled></div>
  <div id="loading"></div>
  <div id="map" style="margin-top:10px"></div>
  <script>

    var calledMap = false;
      $(window).on('load', function(){ 
          initMap();
          calledMap = true;

          if (calledMap){
            setInterval(function(){
              initMap();
            },5000);
          }
        });
      
     function initMap() {
      $(document).ready(function() {
        var valores = $.ajax({
          type: "GET", 
          url: "iss_data.php", 
          beforeSend: function() {
            $('#loading').text('Cargando...');
          },
          complete: function() {
            $('#loading').text('');
          },
          async: false}).responseText;
        var location = valores.split(',');
        var la = location[0];
        var lo = location[1];
        $('#latitude').val(la); 
        $('#longitude').val(lo);
        var position = {lat: parseInt(la), lng: parseInt(lo) };
        var mapOptions = { zoom:2.5,center:position}
        var map = new google.maps.Map(document.getElementById('map'),mapOptions);
        var marker = new google.maps.Marker({
          position: position,
          map: map
        });
      });

    }

 </script>

</body>
</html>
