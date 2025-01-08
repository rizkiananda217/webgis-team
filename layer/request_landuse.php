<?php
$url=file_get_contents("http://localhost:8080/geoserver/sample/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=sample:landuse_jogja&outputFormat=application%2Fjson");
 # url yang ada di dalam ("") itu link address dari halaman GeoJSON.. jangan luap hapus bagian &maxFeatures=50
echo($url);
?>
