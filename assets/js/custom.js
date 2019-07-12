(function ($, Drupal, drupalSettings) {
    Drupal.behaviors.maps = {
        attach: function (context, settings) {

            var maps_key = drupalSettings.maps_key;
            var zoom = settings.zoom;
            var center_position = settings.center.split(",");
            var center_lat = center_position[0];
            var center_long = center_position[1];
            var title_marker = settings.title_marker;
            var description_marker = settings.description_marker;
            var position_marker = settings.position_marker.split(",");
            var lat_marker = position_marker[0];
            var long_marker = position_marker[1];
            var size_logo = settings.size_logo;
            var logo_marker = settings.logo_marker;
            var logo = logo_marker.replace(/public:/g, '');
            var enable_marker = settings.enable_marker;
            var animate_marker_position = drupalSettings.animate_marker_position;

            $.getScript('https://maps.googleapis.com/maps/api/js?key=' + maps_key + '&callback=initMap', function () {
                    //AIzaSyAxsYM8uLOZvdqjYpQINzzvYKcVkT57p58

                    var myCenter = new google.maps.LatLng(center_lat, center_long);
                    var cat = [
                        [title_marker, description_marker, lat_marker, long_marker, logo],
                    ];


                    function initialize() {
                        var mapProp = {
                            center: myCenter,
                            zoom: parseInt(zoom),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };

                        //alert(animate_marker_position);
                        if (animate_marker_position === 1) {
                            var google_animate = 'none';
                        }
                        else if (animate_marker_position === 2) {
                            var google_animate = google.maps.Animation.BOUNCE;
                        }
                        else if (animate_marker_position === 3) {
                            var google_animate = google.maps.Animation.DROP;
                        }
                        // alert(animate_marker_position);
                        var map = new google.maps.Map(document.getElementById("maps"), mapProp);
                        if (enable_marker === 1) {
                            setMarkers(map, cat);
                        }
                        var marker = new google.maps.Marker({
                            position: myCenter,
                            animation: google.maps.Animation.DROP
                        });

                        marker.setMap(map);
                    }

                    function setMarkers(map, locations) {
                        for (var i = 0; i < locations.length; i++) {
                            var villes = locations[i];
                            var image = {
                                url: villes[4],
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(17, 34),
                                scaledSize: new google.maps.Size(size_logo, size_logo)
                            };
                            var myLatLng = new google.maps.LatLng(villes[2], villes[3]);
                            var infoWindow = new google.maps.InfoWindow();
                            var marker = new google.maps.Marker({
                                position: myLatLng,
                                map: map,
                                icon: image,
                                animation: google.maps.Animation.DROP
                            });
                            (function (i) {
                                google.maps.event.addListener(marker, "click", function () {
                                    var villes = locations[i];
                                    infoWindow.close();
                                    infoWindow.setContent("<div style='text-align: center; font-family: monospace;'>" + villes[0] + "<br />" + villes[1] + "</div>");
                                    infoWindow.open(map, this);
                                });
                            })(i);
                        }
                    }


                    google.maps.event.addDomListener(window, 'load', initialize);

                }
            );


        }
    };
})(jQuery, Drupal, drupalSettings);


