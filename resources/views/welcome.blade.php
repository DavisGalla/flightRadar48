<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aircraft Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        let map;
        let aircraftMarkers = {};
        let selectedAircraftId = null;


        
        function initAircraftTracker() {
            map = window.maps?.['aircrafMap'];

            map.setOptions({
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: false,
                styles: [
            {
                "featureType": "all",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry",
                "stylers": [
                    {
                        "saturation": "58"
                    },
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": "0"
                    },
                    {
                        "hue": "#ff8300"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "lightness": "0"
                    },
                    {
                        "weight": "1"
                    },
                    {
                        "visibility": "on"
                    },
                    {
                        "saturation": "0"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#c2bdb9"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#97ca65"
                    }
                ]
            },
            {
                "featureType": "landscape.natural.terrain",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "0"
                    },
                    {
                        "lightness": "0"
                    },
                    {
                        "color": "#e1d5c1"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.medical",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#fbd3da"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#97ca67"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#efd151"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "black"
                    }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit.station.airport",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#cfb2db"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#25aab7"
                    }
                ]
            }
        ]
            });

            updateAircraft();
            setInterval(updateAircraft, 10000);
        }
        
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(initAircraftTracker, 1500);
        });

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            
            if (selectedAircraftId && aircraftMarkers[selectedAircraftId]) {
                const marker = aircraftMarkers[selectedAircraftId];
                const currentIcon = marker.getIcon();
                marker.setIcon({
                    ...currentIcon,
                    fillColor: '#4285F4',
                    scale: 5
                });
            }
            selectedAircraftId = null;
        }

        function getPlaneIcon(heading, isSelected=false) {
            const size = isSelected ? 40 : 30;
            const color = isSelected ? '#FFD700' : '#4285F4';
                
            return {
                url: `data:image/svg+xml,${encodeURIComponent(`
                    <svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 24 24">
                        <g transform="rotate(${heading-90 || 0}, 12, 12)">
                            <path fill="${color}" stroke="#ffffff" stroke-width="0.5" 
                                  d="M16 10h4a2 2 0 0 1 0 4h-4l-4 7h-3l2 -7h-4l-2 2h-3l2 -4l-2 -4h3l2 2h4l-2 -7h3l4 7"/>
                        </g>
                    </svg>
                `)}`,
                scaledSize: new google.maps.Size(size, size),
                anchor: new google.maps.Point(size/2, size/2)



            };
        }

        function showFlightDetails(state, id) {
            const previouslySelected = selectedAircraftId;
            selectedAircraftId = id;
            
            const callsign = state[1]?.trim() || 'Unknown';
            const originCountry = state[2] || 'Unknown';
            const longitude = state[5]?.toFixed(6) || 'N/A';
            const latitude = state[6]?.toFixed(6) || 'N/A';
            const onGround = state[8] || false;
            const icao24 = state[0] || 'N/A';
            const altitude = state[7] ? Math.round(state[7]) : 0;
            const speed = state[9] ? Math.round(state[9] * 3.6) : 0;
            const heading = state[10] ? Math.round(state[10]) : 0;
            const verticalRate = state[11] ? state[11].toFixed(1) : '0.0';
            const lastContact = state[9] ? Math.round(state[9] / 60) : "Unknown";
            
            const sidebar = document.getElementById('sidebar');
            const detailsContent = document.getElementById('details-content');
            
            detailsContent.innerHTML = `
                
                <div class="bg-gray-900 text-white p-6">
                    <div class="text-sm text-gray-400 mb-1">
                        ${onGround ? 'On Ground' : 'Airborne'} • ${originCountry}
                    </div>
                    <h1 class="text-3xl font-bold mb-1">${callsign}</h1>
                    <p class="text-sm text-gray-400 font-mono">${icao24.toUpperCase()}</p>
                </div>
                
                <div class="p-6 space-y-6">
                   
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-3">Flight Data</h3>
                        <div class="space-y-4">
                            <div">
                                <div class="text-sm text-gray-600 mb-1">Altitude</div>
                                <div class="text-2xl font-bold text-gray-900">${altitude.toLocaleString()} <span class="text-sm font-normal text-gray-500">m</span></div>
                            </div>
                            
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Speed</div>
                                <div class="text-2xl font-bold text-gray-900">${speed} <span class="text-sm font-normal text-gray-500">km/h</span></div>
                            </div>
                            
                            <div>
                                <div class=" text-gray-600 mb-1">Diraction</div>
                                <div class="font-bold text-gray-900">${heading}</div>
                            </div>
                            
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Vertical Rate</div>
                                <div class="text-2xl font-bold text-gray-900">${verticalRate} <span class="text-sm font-normal text-gray-500">m/s</span></div>
                            </div>

                            <div>
                                <div class="text-sm text-gray-600 mb-1">Last contacted:</div>
                                <div class="text-2xl font-bold text-gray-900">${lastContact}<span class="text-sm font-normal text-gray-500">Min</span></div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-3">Position</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Latitude</span>
                                <span class="text-sm font-mono text-gray-900">${latitude}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Longitude</span>
                                <span class="text-sm font-mono text-gray-900">${longitude}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            sidebar.classList.add('translate-x-0');
            sidebar.classList.remove('-translate-x-full');
            
            
            if (previouslySelected && aircraftMarkers[previouslySelected]) {
                const prevMarker = aircraftMarkers[previouslySelected];
                const prevHeading = prevMarker.stateData[10];
                prevMarker.setIcon(getPlaneIcon(prevHeading, false));
            }

            
            if (aircraftMarkers[id]) {
                const currentMarker = aircraftMarkers[id];
                const currentHeading = currentMarker.stateData[10];
                currentMarker.setIcon(getPlaneIcon(currentHeading, true));
            }
        }
        
        async function updateAircraft() {
            const res = await fetch('https://opensky-network.org/api/states/all');
            const data = await res.json();
            
            // data.states = data.states.slice(0, 100);
            
            const currentAircraft = new Set();
            
            data.states.forEach(state => {
                const id = state[0];        
                const callsign = state[1]; 
                const lat = state[6];      
                const lng = state[5];       
                const heading = state[10];  
                const altitude = state[7];  
                
                currentAircraft.add(id);
                
                if (!aircraftMarkers[id]) {
                    aircraftMarkers[id] = new google.maps.Marker({
                    position: { lat, lng },
                    map: map,
                    icon: getPlaneIcon(heading, false),
                    title: `${callsign?.trim() || id}\nAltitude: ${Math.round(altitude)}m`
                });
                    
                    aircraftMarkers[id].addListener('click', () => {
                        showFlightDetails(state, id);
                    });
                    
                    aircraftMarkers[id].stateData = state;
                       
                } else {
                    aircraftMarkers[id].setPosition({ lat, lng });
                    
                    if (heading !== null) {
                        aircraftMarkers[id].setIcon(getPlaneIcon(heading, selectedAircraftId === id));
                    }
                    
                    aircraftMarkers[id].setTitle(`${callsign?.trim() || id}\nAltitude: ${Math.round(altitude)}m`);
                    aircraftMarkers[id].stateData = state;
                    
                    
                    if (selectedAircraftId === id) {
                        showFlightDetails(state, id);
                    }
                }
            });
            
            Object.keys(aircraftMarkers).forEach(id => {
                if (!currentAircraft.has(id)) {
                    aircraftMarkers[id].setMap(null);
                    delete aircraftMarkers[id];
                }
            });
        }
    </script>
</head>
<body class="relative">

<div class="w-full h-screen">
    <x-maps-google 
        id="aircrafMap"
        :mapType="'roadmap'"
        :markers="[]"            
        :centerToBoundsCenter="false"
        :zoomLevel="4"
        :disableDefaultUI="true"
    ></x-maps-google>
</div>

<div id="sidebar" class="fixed left-0 top-0 h-full w-80 bg-white transform -translate-x-full transition-transform duration-300 ease-in-out z-50 overflow-y-auto">
    <button onclick="closeSidebar()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-900 z-10">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <div id="details-content">
    </div>
</div>

</body>
</html>