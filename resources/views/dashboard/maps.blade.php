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
      <div class="card-body" style="height: 500px;">
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

    // infoWindow.setOptions({
    //         width:800
    // });

    mapOptions = {
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    // Deklarasi untuk melakukan load map Google Maps API
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    // Variabel untuk menyimpan batas kordinat
    bounds = new google.maps.LatLngBounds();
    let datajson = JSON.parse({!!json_encode($dos_json)!!});
    let odpjson = JSON.parse({!!json_encode($odp_json)!!});

    let colors = ["green","red","blue","yellow","purple","pink","lighBlue","lightGreen"];
    // let selectedColor = colors[Math.floor(Math.random()*colors.length)];

    // console.log(selectedColor);

    var lookup = {};
    var arrSpvId = [];

    for (var item, i = 0; item = datajson[i++];) {
        var spv_id = item.spv_id;

        if (!(spv_id in lookup)) {
            lookup[spv_id] = 1;
            arrSpvId.push(spv_id);
        }
    }

    console.log(arrSpvId);

    const objSpvColor = [];
    for (const key of arrSpvId) {
        // console.log("key");
        // console.log(key);
        // objSpvColor[key] = colors[Math.floor(Math.random()*colors.length)];
        let newColor = {
            spvId: key,
            color: colors[Math.floor(Math.random()*colors.length)]
        }

        objSpvColor.push(newColor);
    }

    console.log(objSpvColor);

    // Pengambilan data dari database MySQL
    datajson.forEach(element => {

        addMarker(element.lat,element.long,element);
    });

    console.log(datajson);
    console.log(odpjson);
    odpjson.forEach(element => {
        addMarkerOdp(element.lat,element.long,element);
    });


    // Proses membuat marker
    var location;
    var marker;


    function pinSymbol(color) {
        return {
            path: 'M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z',
            fillColor: color,
            fillOpacity: 0.6,
            strokeColor: '#FFFFFF',
            strokeWeight: 2,
            scale: 1.5,
            anchor: new google.maps.Point(15, 30),
        };
    }

    function addMarker(lat, lng,info){
        let selectedColor;
        objSpvColor.forEach(element => {
            if (element.spvId == info.spv_id) {
                selectedColor = element.color;
            }
        });

        location = new google.maps.LatLng(lat, lng);
        bounds.extend(location);
        marker = new google.maps.Marker({
            map: map,
            position: location,
            icon: pinSymbol(selectedColor)
        });
        // http://maps.google.com/mapfiles/ms/icons/green-dot.png
        map.fitBounds(bounds);
        bindInfoWindow(marker, map, infoWindow,info);
     }

     function addMarkerOdp(lat, lng,info){
            try {
                location = new google.maps.LatLng(lat, lng);
                bounds.extend(location);
                marker = new google.maps.Marker({
                    map: map,
                    position: location
                });
                map.fitBounds(bounds);
                bindInfoWindowOdp(marker, map, infoWindow,info);
            } catch (error) {

            }
    }

    function bindInfoWindowOdp(marker, map, infoWindow,html){
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(
            `<p><b>Nama ODP</b> : ${html.nama_odp}</p>`
            +`<p><b>Umur ODP</b> : ${html.keterangan_umur}</p>`
            + `<p><b>STO</b> : ${html.sto}</p>`
            + `<p><b>Lat</b> : ${html.lat}</p>`
            + `<p><b>Long</b> : ${html.long}</p>`
            + `<p><b>Alamat</b> : ${html.alamat}</p>`
            + `<p><b>Merk OLT</b> : ${html.merk_olt}</p>`
            + `<p><b>Tanggal Go Live</b> : ${html.tanggal_go_live}</p>`
            + `<p><b>Project</b> : ${html.project}</p>`
            + `<p><b>Mitra</b> : ${html.mitra}</p>`
            + `<p><b>Kendala</b> : ${html.kendala}</p>`
            + `<p><b>Permintaan</b> : ${html.permintaan}</p>`
            );
            infoWindow.open(map, marker);
        });
    }

    // Proses ini dapat menampilkan informasi lokasi Kota/Kab ketika diklik dari masing-masing markernya
    function bindInfoWindow(marker, map, infoWindow, html){
        google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(
        `<p><b>Lat</b> : ${html.lat}</p>`
        + `<p><b>Long</b> : ${html.long}</p>`
        + `<p><b>Kegiatan</b> : ${html.kegiatan}</p>`
        + `<p><b>KKontak</b> : ${html.kkontak}</p>`
        + `<p><b>Tanggal</b> : ${html.tanggal}</p>`
        + `<p><b>Waktu</b> : ${html.waktu}</p>`
        + `<p><b>Produk</b> : ${html.produk}</p>`
        + `<p><b>ODP</b> : ${html.odp}</p>`
        + `<p><b>Status Kunjungan</b> : ${html.status_kunjungan}</p>`
        + `<p><b>Keterangan Kunjungan</b> : ${html.keterangan_kunjungan}</p>`
        + `<p><b>Keterangan Tambahan</b> : ${html.keterangan_tambahan}</p>`
        );
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
    });
}

</script>


@endsection
