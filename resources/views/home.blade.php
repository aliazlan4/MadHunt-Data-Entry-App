@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add a Marker</div>

                <div class="panel-body">
                    <div id="map" style="height: 450px; width: 100%;"></div>
                </div>

                <div class="panel-footer text-center">
                    <form class="form-inline" onsubmit="event.preventDefault();">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="radius">Radius (meters)</label>
                            <input type="number" class="form-control" id="radius" value="1000" onchange="changeRadius()">
                        </div>
                        <button type="submit" class="btn btn-default" style="poition:relative; float:right" onclick="submitForm()">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var map;
    var marker = null;
    var circle = null;
    function initMap() {
        var isb = {lat: 33.664508, lng: 73.087013};
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: isb
        });
        google.maps.event.addListener(map, 'click', function(event) {
           placeMarker(event.latLng);
        });
        google.maps.event.addListener(map, 'rightclick', function(event) {
            if(marker != null){
                marker.setMap(null);
                circle.setMap(null);
                marker = null;
                circle = null;
            }
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map.setCenter(pos);
            map.setZoom(15);
            });
        }
    }
    function placeMarker(location) {
        var temp1 = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });
        var temp2 = new google.maps.Circle({
          map: map,
          radius: parseInt(document.getElementById('radius').value),
          fillColor: '#AA0000',
          strokeWeight: 0
        });
        temp2.bindTo('center', temp1, 'position');

        if(marker != null){
            marker.setMap(null);
            circle.setMap(null);
        }
        marker = temp1;
        circle = temp2;
    }

    function changeRadius(){
        circle.setRadius(parseInt(document.getElementById('radius').value));
    }

    function submitForm(){
        if(marker == null){
            alert("Error: Marker is not present!");
            return;
        }
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();
        var radius = parseInt(document.getElementById('radius').value);

        $.ajax({
           type:'POST',
           url:'/home/saveData',
           data:{_token : '<?php echo csrf_token() ?>', lat: lat, lng: lng, radius: radius},
           success:function(data){
              alert(data.msg);
          }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzXlSM6C3A1VnBpCvqnlmTmxUdlzOQhYg&callback=initMap"></script>
@endsection
