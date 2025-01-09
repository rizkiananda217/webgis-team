<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <title>Objek Wisata Kabupaten Aceh Tengah</title>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js"></script>

    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
        #toggle-style {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1;
            background: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-family: Arial, sans-serif;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
    {{-- tailwind css --}}
  @vite('resources/css/app.css')
</head>
<body>
    <div id="toggle-style">Ganti ke Peta Satelit</div>
    <div id="fly">
        <div id="map" class="w-[65%] h-[100vh]"></div>
    </div>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiZGZpdHJpYW5hIiwiYSI6ImNsYmc0a3pwejA1dHczcHEzYmJpcG5ndXYifQ.I4HBCvvZH5hHK8zC0-nFTA';
        
        // These options control the camera position after animation
        const start = {
            center: [{{ $pariwisata->longitude }}, {{ $pariwisata->latitude }}],
            zoom: 2,
            pitch: 0,
            bearing: 0
        };
        const end = {
            center: [{{ $pariwisata->longitude }}, {{ $pariwisata->latitude }}],
            zoom: 12.5,
            bearing: 50,
            pitch: 75
        };
        
        // Default map style
        let mapStyle = 'mapbox://styles/mapbox/streets-v12';
        
        // Initialize map
        const map = new mapboxgl.Map({
            container: 'map',
            style: mapStyle,
            center: [{{ $pariwisata->longitude }}, {{ $pariwisata->latitude }}],
            ...start
        });
        
        // Add popup
        const popUp = new mapboxgl.Popup({
            offset: 35,
            closeOnClick: false,
        })
        .setLngLat([{{ $pariwisata->longitude }}, {{ $pariwisata->latitude }}])
        .setHTML(`
        <div class="w-[200px] h-[220px] rounded border bg-white">
              <img alt="{{ $pariwisata->places }}" src="{{ asset("storage/img/$pariwisata->image") }}" class="w-full h-[80px] object-cover rounded-t"/>
              <div class="mt-2 px-2 font-nunito text-sm text-black-c2 font-semibold line-clamp-1 h-8 hover:text-black-c1">
                {{ $pariwisata->places }} 
              </div>
              <div class="px-2 font-nunito text-xs text-gay-c1 font-normal line-clamp-5">
                {{ $pariwisata->deskripsi }} 
              </div>
        </div>
        `);

        const marker1 = new mapboxgl.Marker()
            .setLngLat([{{ $pariwisata->longitude }}, {{ $pariwisata->latitude }}])
            .setPopup(popUp) // sets a popup on this marker
            .addTo(map);

        // Add navigation control
        map.addControl(new mapboxgl.NavigationControl());
        
        // Setting fly animation
        let isAtStart = true;
        document.getElementById('fly').addEventListener('click', () => {
            const target = isAtStart ? end : start;
            isAtStart = !isAtStart;

            map.flyTo({
                ...target,
                duration: 12000,
                essential: true
            });
        }, {once: true});

        // Add toggle style functionality
        document.getElementById('toggle-style').addEventListener('click', () => {
            mapStyle = mapStyle === 'mapbox://styles/mapbox/streets-v12'
                ? 'mapbox://styles/mapbox/satellite-v9'
                : 'mapbox://styles/mapbox/streets-v12';
            
            map.setStyle(mapStyle);

            const toggleText = mapStyle === 'mapbox://styles/mapbox/satellite-v9'
                ? 'Ganti ke Peta Jalan'
                : 'Ganti ke Peta Satelit';

            document.getElementById('toggle-style').textContent = toggleText;
        });
    </script>
</body>
</html>
