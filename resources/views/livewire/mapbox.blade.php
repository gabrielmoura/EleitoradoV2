<div id='map' style='width: {{$width}}; height: {{$height}};'>
    <link rel='stylesheet' href='https://unpkg.com/maplibre-gl@3.3.0/dist/maplibre-gl.css'/>
    <script src='https://unpkg.com/maplibre-gl@3.3.0/dist/maplibre-gl.js'></script>
    <script>

        const map = new maplibregl.Map({
            container: 'map', // container ID
            style: {
                "version": 8,
                "sources": {
                    "osm": {
                        "type": "raster",
                        "tiles": ["https://c.tile.openstreetmap.org/{z}/{x}/{y}.png"],
                        "tileSize": 256,
                        "attribution": "&copy; Moura Tecnology",
                        "maxzoom": {{$maxZoom}}
                    }
                },
                "layers": [
                    {
                        "id": "osm",
                        "type": "raster",
                        "source": "osm" // This must match the source key above
                    }
                ]
            }, // style URL
            center: [{{$centerLat}}, {{$centerLong}}], // starting position [lng, lat]
            zoom: {{$zoom}}, // starting zoom
        });
        map.on('click', (e) => {
            console.log(`A click event has occurred at ${e.lngLat}`);
        });
        map.addControl(new maplibregl.NavigationControl());
        const marker = new maplibregl.Marker()
            .setLngLat([{{$lat}}, {{$long}}])
            .addTo(map);
    </script>
</div>
