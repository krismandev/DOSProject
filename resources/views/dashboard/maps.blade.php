@extends("layouts.dashboard.master")
@section("page_title","Maps")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Maps</li>
@endsection
@section("title","Maps")
@section("content")
<style>
#map{
    height: 100%;
    }
</style>

<section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Title</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body" style="height: 400px;">
        <div id="map"></div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        Footer
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

@endsection
@section("linkfooter")
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnJdVlDZl-Wd39pXkjf3reZbYV2ZTzHKo&callback=gmpstart" async defer></script>

<script type="text/javascript">
    let map;
let infoWindow;
let mapOptions;
let bounds;

function gmpstart(){
    // infoWindow ini digunakan untuk menampilkan pop-up diatas marker terkait lokasi markernya
    infoWindow = new google.maps.InfoWindow;
    //  Variabel berisi properti tipe peta yang bisa diubah-ubah
    mapOptions = {
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    // Deklarasi untuk melakukan load map Google Maps API
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    // Variabel untuk menyimpan batas kordinat
    bounds = new google.maps.LatLngBounds();
    // Pengambilan data dari database MySQL
    <?php
        // Sesuaikan dengan database yang sudah Anda buat diawal
       foreach ($dos as $item) {
            echo "addMarker($item->lat,$item->long);";
       }
    ?>
    // Proses membuat marker
    var location;
    var marker;
    function addMarker(lat, lng){
        location = new google.maps.LatLng(lat, lng);
        bounds.extend(location);
        marker = new google.maps.Marker({
            map: map,
            position: location
        });
        map.fitBounds(bounds);
        bindInfoWindow(marker, map, infoWindow);
     }
    // Proses ini dapat menampilkan informasi lokasi Kota/Kab ketika diklik dari masing-masing markernya
    function bindInfoWindow(marker, map, infoWindow){
        google.maps.event.addListener(marker, 'click', function() {
        // infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    google.maps.event.addListener(map, 'zoom_changed', function () {
        var maptype = map.getMapTypeId();
        if (map.getZoom() >= map.mapTypes[maptype].maxZoom) {
            if (map.getMapTypeId() != google.maps.MapTypeId.HYBRID) {
                map.setMapTypeId(google.maps.MapTypeId.HYBRID)
                map.setTilt(0); // disable 45 degree imagery
            }
        }
    });;

    //membuat poligon
    // var coordinateA = new google.maps.LatLng(-1.6032454,103.5174842);
    // var coordinateB = new google.maps.LatLng(-1.6132726,103.5185685);
    // var coordinateC = new google.maps.LatLng(-1.614501,103.5201911);
    // var coordinateD = new google.maps.LatLng(-1.6144993,103.5202124);

    // var coords =
    // [
    //     {lat: coordinateA.lat(), lng: coordinateA.lng() },
    //     {lat: coordinateB.lat(), lng: coordinateB.lng() },
    //     {lat: coordinateC.lat(), lng: coordinateC.lng() },
    //     {lat: coordinateD.lat(), lng: coordinateD.lng() }
    // ];

    // metros = new google.maps.Polygon(
    // {
    //     paths: coords,
    //     strokeColor: "#0000FF",
    //     strokeOpacity: 0.8,
    //     strokeWeight: 2,
    //     fillColor: "#0000FF",
    //     fillOpacity: 0.26
    // });

    // metros.setMap(map)



    //mewarnai area sekitar koorinat
    // var marker = new google.maps.Marker({
    //   map: map,
    //   position: new google.maps.LatLng(-1.6032454,103.5174842),
    //   title: 'Some location'
    // });

    // var circle = new google.maps.Circle({
    //   map: map,
    //   radius: 16093,    // 10 miles in metres
    //   fillColor: '#AA0000'
    // });
    // circle.bindTo('center', marker, 'position');

}

// google.maps.event.addDomListener(window, 'load', gmpstart);

</script>


@endsection
