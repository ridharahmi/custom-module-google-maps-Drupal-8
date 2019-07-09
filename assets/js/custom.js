(function ($, Drupal, drupalSettings) {
    Drupal.behaviors.maps = {
        attach: function (context, settings) {

            var maps_key = settings.maps_key;
            var zoom = settings.zoom;
            var center_position = settings.center.split(",");
            var center_lat = center_position[0] ;
            var center_long = center_position[1];
            var title_marker = settings.title_marker;
            var description_marker = settings.description_marker;
            var position_marker = settings.position_marker.split(",");
            var lat_marker = position_marker[0] ;
            var long_marker = position_marker[1];




            $.getScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyAxsYM8uLOZvdqjYpQINzzvYKcVkT57p58&callback=initMap' ,function () {

                // var myCenter = new google.maps.LatLng(center_lat,center_long);
                // var mapCanvas = document.getElementById("maps");
                // var mapOptions = {
                //     zoom: parseInt(zoom)
                // };
                //
                // var map = new google.maps.Map(mapCanvas, mapOptions);
                //
                // var arrayLength = markers.length;
                // for (var i = 0; i < arrayLength; i++) {
                //     var mar = markers[i].split(",");
                //     var marker = new google.maps.Marker({
                //         position: new google.maps.LatLng(mar[0],mar[1])
                //     });
                //     marker.setMap(map);
                // }



                //**************************************//
                var myCenter = new google.maps.LatLng(center_lat,center_long);
                var marker;
                var cat = [
                    [title_marker, description_marker, lat_marker, long_marker, 'https://www.elyosdigital.com//themes/custom/elyos/assets/images/logo_elyos.svg'],
                ];
                function initialize() {
                    var mapProp = {
                        center : myCenter,
                        zoom : parseInt(zoom),
                        mapTypeId : google.maps.MapTypeId.ROADMAP
                    };

                    var map = new google.maps.Map(document.getElementById("maps"), mapProp);
                    setMarkers(map, cat);
                    var marker = new google.maps.Marker({
                        position : myCenter,
                        animation : google.maps.Animation.BOUNCE
                    });

                    marker.setMap(map);
                }
                function setMarkers(map, locations) {
                    for(var i = 0; i < locations.length; i++) {
                        var villes = locations[i];
                        var image = {
                            url: villes[4],
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(50, 50)
                        };
                        var myLatLng = new google.maps.LatLng(villes[2], villes[3]);
                        var infoWindow = new google.maps.InfoWindow();
                        var marker = new google.maps.Marker({
                            position : myLatLng,
                            map : map,
                            icon : image,
                            animation : google.maps.Animation.DROP
                        });
                        (function(i) {
                            google.maps.event.addListener(marker, "click", function() {
                                var villes = locations[i];
                                infoWindow.close();
                                infoWindow.setContent("<div style='text-align: center; font-family: monospace;'>" + villes[0] + "<br />" + villes[1] + "</div>");
                                infoWindow.open(map, this);
                            });
                        })(i);
                    }
                }

                google.maps.event.addDomListener(window, 'load', initialize);

            });

        }
    };
})(jQuery, Drupal, drupalSettings);


