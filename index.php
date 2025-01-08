<!DOCTYPE html>
<html>
<head> <!-- untuk meta description, keywords, dan author bisa gantu dan di sesuaikan tapi yang meta charset sama viewport jangan di ganti -->

  <link rel="stylesheet" href="leaflet/lf/leaflet.css" /> <!-- memanggil css di folder leaflet -->
  <script src="leaflet/lf/leaflet.js"></script> <!-- memanggil leaflet.js di folder leaflet -->
  <script src="js/jquery-3.2.1.min.js"></script> <!-- memanggil jquery di folder js -->
  <script src="leaflet/lfprof/leaflet-providers.js"></script> <!-- memanggil leaflet-providers.js di folder leaflet provider -->
  <link rel="stylesheet" href="css/style.css" /> <!-- memanggil css style -->

  <!-- memanggil plugin group layers -->
  <link rel="stylesheet" href="leaflet/groupLayers/src/leaflet.groupedlayercontrol.css"/>
  <script src="leaflet/groupLayers/src/leaflet.groupedlayercontrol.js"></script>

  <!--memanggil plugin pencarian, Json dan Extend all-->

  <link rel="stylesheet" href="leaflet/leaflet.defaultextent-master/dist/leaflet.defaultextent.css" />
  <script src="leaflet/leaflet-ajax/dist/leaflet.ajax.js"></script>

  <script src="leaflet/leaflet.defaultextent-master/dist/leaflet.defaultextent.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js"></script>

<!-- memanggil awesome marker -->
   <link rel="stylesheet" href="leaflet/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="leaflet/awesome-marker/dist/leaflet.awesome-markers.css">
   <script src="leaflet/awesome-marker/dist/leaflet.awesome-markers.js"></script>

  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name='description' content='WebGIS info-geospasial.com menyajikan berbagai konten spasial ke dalam bentuk Website'/>
  <meta name='keywords' content='WebGIS, WebGIS info-geospasial, WebGIS Indoensia'/>
  <meta name='Author' content='Egi Septiana'/>
  <title>WebGIS Jogjgakarta - PTI Untuksha</title> <!-- title bisa di sesuaikan dengan nama judul WebGIS yang di inginkan -->
</head>
<body>
<!-- bagian ini akan di isi konten utama -->
<?php include 'header.php'; ?>

  <div id="map"> <!-- ini id="map" bisa di ganti dengan nama yang di inginkan -->
  <script>
  var items = [];

  var layer_permanent = $.getJSON("select.php", function (data) {
          for (var i = 0; i < data.length; i++) {
            var location = new L.LatLng(data[i].lat, data[i].long);
            var name = data[i].judul;
            var marker = new L.Marker(location).addTo(map)
            .bindPopup("<div style='text-align: center; margin-left: auto; margin-right: auto;'>"+ name +" <br /> <a href='delete.php?id="+ data[i].long +"'>Delete Marker</a>  </div>", {maxWidth: '400'});
          }
        });



  // MENGATUR TITIK KOORDINAT TITIK TENGAN & LEVEL ZOOM PADA BASEMAP
  var map = L.map('map').setView([-7.797068,110.370529], 4);

  // MENAMPILKAN SKALA
  L.control.scale({imperial: false}).addTo(map);

  // ------------------- VECTOR ----------------------------
  var layer_landuse = new L.GeoJSON.AJAX("layer/request_landuse.php",{ // sekarang perintahnya diawali dengan variabel
    style: function(feature){
    var fillColor, // ini style yang akan digunakan
            kode = feature.properties.id; // perwarnaan objek polygon berdasarkan kode kabupaten di dalam file geojson
             if ( kode = 1 ) fillColor = "#DBD525";
        // no data
        return { color: "#F0F0EB", dashArray: '2', weight: 2, fillColor: fillColor, fillOpacity: 0.8 }; // style border sertaa transparansi
      },
      onEachFeature: function(feature, layer){
        items.push(layer);
      //layer.bindPopup("<center>" + feature.properties.nama + "</center>"), // popup yang akan ditampilkan diambil dari filed kab_kot
      that = this; // perintah agar menghasilkan efek hover pada objek layer
            layer.on('mouseover', function (e) {
                this.setStyle({
                weight: 1,
                color: '#F0F0EB',
                dashArray: '',
                fillOpacity: 0.8
                });
            layer.on('click', function(e){
              layer.bindPopup("<center>" + feature.properties.nama + " <br /> <a href='upload.php?lang=" + e.latlng.lat + "&long=" + e.latlng.lng +"'>Tambah Marker</a> </center>");
              //alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng);
            });
            });
            layer.on('mouseout', function (e) {
                layer_landuse.resetStyle(e.target); // isi dengan nama variabel dari layer
                //info.update();
            });
    }
    }).addTo(map);

    var marker1 = L.AwesomeMarkers.icon({
      icon: 'camera',
      prefix: 'fa',
      iconColor: 'white',
      markerColor: 'red'
     });
     var markerIbadah = L.AwesomeMarkers.icon({
       icon: 'moon-o',
       prefix: 'fa',
       iconColor: 'white',
       markerColor: 'red'
      });
     var marker_rumahsakit = L.AwesomeMarkers.icon({
       icon: 'plus-circle',
       prefix: 'fa',
       iconColor: 'white',
       markerColor: 'green'
      });
      var marker_spbu = L.AwesomeMarkers.icon({
        icon: 'fa-spotify',
        prefix: 'fa',
        iconColor: 'white',
        markerColor: 'red'
       });
       var markerHotel = L.AwesomeMarkers.icon({
         icon: 'bed',
         prefix: 'fa',
         iconColor: 'white',
         markerColor: 'green'
        });

   var layer_sungai = new L.GeoJSON.AJAX("layer/request_sungai.php",{ // sekarang perintahnya diawali dengan variabel
         style: function(feature){
         var fillColor, // ini style yang akan digunakan
                 kode = feature.properties.id; // perwarnaan objek polygon berdasarkan kode kabupaten di dalam file geojson
                  if ( kode >= 1 ) color = "#9ADDFF";
             // no data
             return { color: "#9ADDFF", dashArray: '0', weight:4, color: color, opacity: 1 }; // style border sertaa transparansi
           },
           onEachFeature: function(feature, layer){
             items.push(layer);
           layer.bindPopup("<center>" + feature.properties.nama + " <div> "), // popup yang akan ditampilkan diambil dari filed kab_kot
           that = this; // perintah agar menghasilkan efek hover pada objek layer
                 layer.on('mouseover', function (e) {
                     this.setStyle({
                     weight: 5,
                     color: '#9ADDFF',
                     dashArray: '',
                     fillOpacity: 1
                     });
                 });
                 layer.on('mouseout', function (e) {
                     layer_sungai.resetStyle(e.target); // isi dengan nama variabel dari layer
                     //info.update();
                 });
         }, //costum icon
         pointToLayer: function (feature, latlng) {
                 return L.marker(latlng, {icon: marker1});
         }
         }).addTo(map);

       var layer_jalan = new L.GeoJSON.AJAX("layer/request_jalan.php",{ // sekarang perintahnya diawali dengan variabel
         style: function(feature){
         var weight, // ini style yang akan digunakan
                 kode = feature.properties.id; // perwarnaan objek polygon berdasarkan kode kabupaten di dalam file geojson
                  if ( kode <= 42 ) weight = 4;
                  else if ( kode >= 43 ) weight = 1;
             return { color: "#FEFEFE", dashArray: '0', weight: weight, opacity: 1 }; // style border sertaa transparansi
           },
           onEachFeature: function(feature, layer){
             items.push(layer);
           layer.bindPopup("<center>" + feature.properties.jalan + " <div> "); // popup yang akan ditampilkan diambil dari filed kab_kot
         }, //costum icon
         pointToLayer: function (feature, latlng) {
                 return L.marker(latlng, {icon: marker1});
         }
         }).addTo(map);

       var layer_spbu = new L.GeoJSON.AJAX("layer/request_spbu.php",{ // sekarang perintahnya diawali dengan variabel
         style: function(feature){
         var fillColor, // ini style yang akan digunakan
                 kode = feature.properties.id; // perwarnaan objek polygon berdasarkan kode kabupaten di dalam file geojson
                  if ( kode >= 1 ) fillColor = "#ffd700";
             // no data
             return { color: "#999", dashArray: '3', weight: 0, fillColor: fillColor, opacity: 0 }; // style border sertaa transparansi
           },
           onEachFeature: function(feature, layer){
             items.push(layer);
             map.on('zoomend', function () {
              if (map.getZoom() < 4.5 && map.hasLayer(layer_spbu)) {
                  map.removeLayer(layer_spbu);
              }
              if (map.getZoom() > 4.5 && map.hasLayer(layer_spbu) == false)
              {
                  map.addLayer(layer_spbu);
              }
              });
           layer.bindPopup("<center>" + feature.properties.nama + " <div> <img src='"+ feature.properties.url +"' height='150px' /> <br /> <a href='https://www.google.co.id/search?q="+ feature.properties.nama +"' target='_blank'>Cari Informasi Lebih Lanjut</a> </div> </center>" + layer.getLatLng()); // popup yang akan ditampilkan diambil dari filed kab_kot
         },
          //costum icon
         pointToLayer: function (feature, latlng) {
                 return L.marker(latlng, {icon: marker_spbu});
         }
         }).addTo(map);

         var layer_hotel = new L.GeoJSON.AJAX("layer/request_hotel.php",{ // sekarang perintahnya diawali dengan variabel
           style: function(feature){
           var fillColor, // ini style yang akan digunakan
                   kode = feature.properties.id; // perwarnaan objek polygon berdasarkan kode kabupaten di dalam file geojson
                    if ( kode >= 1 ) fillColor = "#ffd700";
               // no data
               return { color: "#999", dashArray: '3', weight: 0, fillColor: fillColor, opacity: 0 }; // style border sertaa transparansi
             },
             onEachFeature: function(feature, layer){
               items.push(layer);
               var hotel = feature.properties.id;
               if( hotel < 3 ){
                 map.on('zoomend', function () {
                  if (map.getZoom() < 4 && map.hasLayer(layer_hotel)) {
                      map.removeLayer(layer_hotel);
                  }
                  if (map.getZoom() > 4 && map.hasLayer(layer_hotel) == false)
                  {
                      map.addLayer(layer_hotel);
                  }
                  });
               }

             layer.bindPopup("<center>" + feature.properties.nama + "</center> <div> </div>" + layer.getLatLng()); // popup yang akan ditampilkan diambil dari filed kab_kot
           },
            //costum icon
           pointToLayer: function (feature, latlng) {
                   return L.marker(latlng, {icon: markerHotel});
           }
           }).addTo(map);

       var layer_rumahsakit = new L.GeoJSON.AJAX("layer/request_rumahsakit.php",{ // sekarang perintahnya diawali dengan variabel
         style: function(feature){
         var fillColor, // ini style yang akan digunakan
                 kode = feature.properties.id; // perwarnaan objek polygon berdasarkan kode kabupaten di dalam file geojson
                  if ( kode > 1 ) fillColor = "#ffd700";
             // no data
             return { color: "#999", dashArray: '3', weight: 2, fillColor: fillColor, fillOpacity: 1 }; // style border sertaa transparansi
           },
           onEachFeature: function(feature, layer){
             items.push(layer);
           layer.bindPopup("<center>" + feature.properties.nama + "</center> <div> </div>" + layer.getLatLng()), // popup yang akan ditampilkan diambil dari filed kab_kot
           that = this; // perintah agar menghasilkan efek hover pada objek layer
                 layer.on('mouseover', function (e) {
                     this.setStyle({
                     weight: 2,
                     color: '#72152b',
                     dashArray: '',
                     fillOpacity: 0.8
                     });
                 });
                 layer.on('mouseout', function (e) {
                     layer_rumahsakit.resetStyle(e.target); // isi dengan nama variabel dari layer
                     //info.update();
                 });
         },
          //costum icon
         pointToLayer: function (feature, latlng) {
                 return L.marker(latlng, {icon: marker_rumahsakit});
         }
         }).addTo(map);

         var layer_ibadah = new L.GeoJSON.AJAX("layer/request_ibadah.php",{ // sekarang perintahnya diawali dengan variabel
           style: function(feature){
           var fillColor, // ini style yang akan digunakan
                   kode = feature.properties.id; // perwarnaan objek polygon berdasarkan kode kabupaten di dalam file geojson
                    if ( kode > 1 ) fillColor = "#ffd700";
               // no data
               return { color: "#999", dashArray: '3', weight: 2, fillColor: fillColor, fillOpacity: 1 }; // style border sertaa transparansi
             },
             onEachFeature: function(feature, layer){
               items.push(layer);
               map.on('zoomend', function () {
                if (map.getZoom() < 4 && map.hasLayer(layer_ibadah)) {
                    map.removeLayer(layer_ibadah);
                }
                if (map.getZoom() > 4 && map.hasLayer(layer_ibadah) == false)
                {
                    map.addLayer(layer_ibadah);
                }
                });
             layer.bindPopup("<center>" + feature.properties.nama + " <div> <img src='"+ feature.properties.url +"' height='150px' /> <br /> <a href='https://www.google.co.id/search?q="+ feature.properties.nama +"' target='_blank'>Cari Informasi Lebih Lanjut</a> </div> </center>" + layer.getLatLng()), // popup yang akan ditampilkan diambil dari filed kab_kot
             that = this; // perintah agar menghasilkan efek hover pada objek layer
                   layer.on('mouseover', function (e) {
                       this.setStyle({
                       weight: 2,
                       color: '#72152b',
                       dashArray: '',
                       fillOpacity: 0.8
                       });
                   });
                   layer.on('mouseout', function (e) {
                       layer_ibadah.resetStyle(e.target); // isi dengan nama variabel dari layer
                       //info.update();
                   });
           }, //costum icon
           pointToLayer: function (feature, latlng) {
                   return L.marker(latlng, {icon: markerIbadah});
           }
           }).addTo(map);

    var layer_wisata = new L.GeoJSON.AJAX("layer/request_wisata.php",{ // sekarang perintahnya diawali dengan variabel
      style: function(feature){
      var fillColor, // ini style yang akan digunakan
              kode = feature.properties.id; // perwarnaan objek polygon berdasarkan kode kabupaten di dalam file geojson
               if ( kode > 1 ) fillColor = "#ffd700";
          // no data
          return { color: "#999", dashArray: '3', weight: 2, fillColor: fillColor, fillOpacity: 1 }; // style border sertaa transparansi
        },
        onEachFeature: function(feature, layer){
          items.push(layer);
        layer.bindPopup("<center>" + feature.properties.nama + " <div> <img src='"+ feature.properties.url +"' height='150px' /> <br /> <a href='https://www.google.co.id/search?q="+ feature.properties.nama +"' target='_blank'>Cari Informasi Lebih Lanjut</a> </div> </center>" + layer.getLatLng()), // popup yang akan ditampilkan diambil dari filed kab_kot
        that = this; // perintah agar menghasilkan efek hover pada objek layer
              layer.on('mouseover', function (e) {
                  this.setStyle({
                  weight: 2,
                  color: '#72152b',
                  dashArray: '',
                  fillOpacity: 0.8
                  });
              });
              layer.on('mouseout', function (e) {
                  layer_wisata.resetStyle(e.target); // isi dengan nama variabel dari layer
                  //info.update();
              });
      }, //costum icon
      pointToLayer: function (feature, latlng) {
              return L.marker(latlng, {icon: marker1});
      }
      }).addTo(map);


  //ADD MENAMBAHKAN TOOL PENCARIAN
  // SEARCH TOOL

  function sortNama(a, b) {
    var _a = a.feature.properties.nama; // nama field yang akan dijadikan acuan di dalam tool pencarian

    var _b = b.feature.properties.nama; // nama field yang akan dijadikan acuan di dalam tool pencarian

    if (_a < _b) {
      return -1;
    }
    if (_a > _b) {
      return 1;
    }
    return 0;
  }

  L.Control.Search = L.Control.extend({
    options: {
      // topright, topleft, bottomleft, bottomright
      position: 'topleft',
      placeholder: ' Search...'
    },
    initialize: function (options /*{ data: {...}  }*/) {
      // constructor
      L.Util.setOptions(this, options);
    },
    onAdd: function (map) {
      // happens after added to map
      var container = L.DomUtil.create('div', 'search-container');
      this.form = L.DomUtil.create('form', 'form', container);
      var group = L.DomUtil.create('div', 'form-group', this.form);
      this.input = L.DomUtil.create('input', 'form-control input-sm', group);
      this.input.type = 'text';
      this.input.placeholder = this.options.placeholder;
      this.results = L.DomUtil.create('div', 'list-group', group);
      L.DomEvent.addListener(this.input, 'keyup', _.debounce(this.keyup, 300), this);
      L.DomEvent.addListener(this.form, 'submit', this.submit, this);
      L.DomEvent.disableClickPropagation(container);
      return container;
    },
    onRemove: function (map) {
      // when removed
      L.DomEvent.removeListener(this._input, 'keyup', this.keyup, this);
      L.DomEvent.removeListener(form, 'submit', this.submit, this);
    },
    keyup: function(e) {
      if (e.keyCode === 38 || e.keyCode === 40) {
        // do nothing
      } else {
        this.results.innerHTML = '';
        if (this.input.value.length > 2) {
          var value = this.input.value;
          var results = _.take(_.filter(this.options.data, function(x) {
            return x.feature.properties.nama.toUpperCase().indexOf(value.toUpperCase()) > -1;
          }).sort(sortNama), 10);
          _.map(results, function(x) {
            var a = L.DomUtil.create('a', 'list-group-item');
            a.href = '';
            a.setAttribute('data-result-name', x.feature.properties.nama); // nama field yang akan dijadikan acuan di dalam tool pencarian

            a.innerHTML = x.feature.properties.nama; // nama field yang akan dijadikan acuan di dalam tool pencarian

            this.results.appendChild(a);
            L.DomEvent.addListener(a, 'click', this.itemSelected, this);
            return a;
          }, this);
        }
      }
    },
    itemSelected: function(e) {
      L.DomEvent.preventDefault(e);
      var elem = e.target;
      var value = elem.innerHTML;
      this.input.value = elem.getAttribute('data-result-name');
      var feature = _.find(this.options.data, function(x) {
        return x.feature.properties.nama === this.input.value; // nama field yang akan dijadikan acuan di dalam tool pencarian

      }, this);
      if (feature) {
        this._map.fitBounds(feature.getBounds());
      }
      this.results.innerHTML = '';
    },
    submit: function(e) {
      L.DomEvent.preventDefault(e);
    }
  });

  L.control.search = function(id, options) {
    return new L.Control.Search(id, options);
  }
  L.control.search({
    data: items
  }).addTo(map);

  //end add map

  //make label
  var marker = new L.marker([59.5343180010956, 96.85546875000001], { opacity: 0 }); //opacity may be set to zero
  marker.bindTooltip("KOTA YOGYAKARTA", {permanent: true, className: "my-label", offset: [0, 0] });
  marker.addTo(map);
  // PILIHAN BASEMAP YANG AKAN DITAMPILKAN
  var baseLayers = {
  //'Esri.WorldTopoMap': L.tileLayer.provider('Esri.WorldTopoMap').addTo(map),
  //'Esri WorldImagery': L.tileLayer.provider('Esri.WorldImagery')
  };


  // MENAMPILKAN TOOLS UNTUK MEMILIH BASEMAP
  //L.control.layers(baseLayers,{}).addTo(map);
  // membuat pilihan untuk menampilkan layer
  var overlays = {
        "KOTA JOGYAKARTA": {
          //"Landuse 2": layer_landuse,
          "Layer Rumah Sakit" : layer_rumahsakit,
          "Layer Hotel" : layer_hotel,
          "Layer Sungai" : layer_sungai,
          "Layer Tempat Ibadah" : layer_ibadah,
          "Layer Objek WIsata" : layer_wisata,
          "Layer Jalan" : layer_jalan,
          "Layer SPBU" : layer_spbu
        }
        };
  var options = {
    exclusiveGroups: ["PROVINSI BALI"]
  };
  // MENAMPILKAN TOOLS UNTUK MEMILIH BASEMAP
  L.control.groupedLayers(baseLayers, overlays, options).addTo(map);
  </script>
  </div>
<?php include 'footer.php'; ?>

</body>
</html>
