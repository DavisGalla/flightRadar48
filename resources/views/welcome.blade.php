<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    {{-- // Leaflet
    // A basic map is as easy as using the x blade component. --}}
    
    <x-maps-leaflet></x-maps-leaflet>
    
    {{-- // Set the centerpoint of the map: --}}
    <x-maps-leaflet :centerPoint="['lat' => 52.16, 'long' => 5]"></x-maps-leaflet>
    
    {{-- // Set a zoomlevel: --}}
    <x-maps-leaflet :zoomLevel="6"></x-maps-leaflet>
    
    {{-- // Set markers on the map: --}}
    <x-maps-leaflet :markers="[['lat' => 52.16444513293423, 'long' => 5.985622388024091]]"></x-maps-leaflet>
</body>
</html>