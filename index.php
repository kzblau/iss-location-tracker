<!DOCTYPE html>
<html lang="en">
<head>
  <title>ISS Location Tracker</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=[YOUR_API_KEY]">
</script>
<style>
#map {
  height: 400px;
}

th, td {
  text-align: center;
}

.image {
    -webkit-animation:spin 4s linear infinite;
    -moz-animation:spin 4s linear infinite;
    animation:spin 4s linear infinite;
}
@-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
@-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
@keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }

</style>
</head>
<body>
  
  <div class="container-fluid">
    <h3>Current ISS Location</h3>
    <div class="row">
      <div class="col-md-6">
        <label for="latitude">Latitude</label>
        <input id="latitude" type="text" disabled>
        <label for="longitude">Longitude</label>
        <input id="longitude" type="text" disabled>
        <div id="loading" style="float:right"></div>
        <div id="map" style="margin-top:10px"></div>
      </div>
      <div class="col-md-6">

       <table id="locationData" width="100%">
        <tr>
          <tbody>
            <th style="display:none">Latitude</th>
            <th style="display:none">Longitude</th>
            <tr>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </tr>

      </table>
    </div>
  </div>
  <script>

    var calledMap = false;
    $(window).on('load', function(){ 
      initMap();
        //  $('th').css("display","none");
        calledMap = true;

        if (calledMap){
          setInterval(function(){
            initMap();
            $('th').show();
          },5000);


        }

      });

    function initMap() {
      $(document).ready(function() {
        var valores = $.ajax({
          type: "GET", 
          url: "iss_data.php", 
          beforeSend: function() {
            $('#loading').html('<img class="image" src="img/updating.png" />');
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

      $('#locationData > tbody:last-child').append(
        '<tr>'
        +'<td>' + $('#latitude').val() +  '</td>'
        +'<td>' + $('#longitude').val() +  '</td>'
        +'</tr>');     
    }


  </script>

</body>
</html>
