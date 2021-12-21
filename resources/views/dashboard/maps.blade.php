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
}

// google.maps.event.addDomListener(window, 'load', gmpstart);

</script>


@endsection
