<!DOCTYPE html>
<!doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="http://openlayers.org/en/v3.1.0/css/ol.css" type="text/css">
        <link rel="stylesheet" href="neatline_mapper.css" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.5.0/ol.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <title>Introduction to Modern Architecture</title>
    </head>

    <body>
        <!--<div id="loadingcont">
        <div id="loading">LOADING</div>
        </div>-->
        <div id="map" class="map">
            <div id="title"> <div id="title_box">  Introduction to Modern Architecture</div></div>
            <div id="titlepopup">
                <div id="titlecontent"></div>
            </div>
            <div id="infopopup">
                <div id="closer">x</div>
                <div>
                    <div id="popcontent"></div>
                </div>
            </div>
            <div id="layercontainer">
                <div id="min" title="Hide Layers">-</div>
                <div id="max" title="Show Layers">+</div>
                <div id="layerlist">
                    <div class="layer_heading">Base Layers</div>
                    <input type="radio" name="base" value="OSM" class="base" checked="true">Open Streetmap<br>
                    <input type="radio" name="base" value="esri" class="base">ESRI<br>
                    <input type="radio" name="base" value="wc" class="base" >Stamen Watercolor<br>
                    <input type="radio" name="base" value="toner" class="base">Stamen Toner<br>
                    <div class="layer_heading">Exhibits</div>
                </div>
            </div>
        </div>
        <script src="layers.js"></script>
        <script src="map_config.js"></script>
        <script src="style_functions.js"></script>
        <script src="functions.js"></script>

        <script type="text/javascript">

            $(document).ready(function () {

                //hide the divs that will hold the title and the information popups
                $("#titlepopup").hide();
                $("#infopopup").hide();
                $("#max").hide();

                var highlight;
                getLayers();
//               
                $("#closer").click(
                        function () {
                            //$( "#infopopup" ).hide(); 
                            $("#popcontent").html("");
                            $("#infopopup").hide();
                        });

                $("#min").click(
                        function () {
                            $("#layerlist").hide();
                            $("#max").show();
                            $("#min").hide();
                        });

                $("#max").click(
                        function () {
                            $("#layerlist").show();
                            $("#max").hide();
                            $("#min").show();
                        });

                $("#layerlist").on({
                    mouseenter: function () {
                        if (ed[this.id] && $('#infopopup').css('display') === "none") {
                            $("#titlepopup").show();
                            $("#titlecontent").html(ed[this.id]);
                        }
                    },
                    mouseleave: function () {
                        $("#titlepopup").hide();
                    }
                }, 'div');

                var displayTitleInfo = function (pixel) {
                    var feature = map.forEachFeatureAtPixel(pixel, function (feature, layer) {
                        return feature;
                    });

                    if (feature !== highlight) {
                        if (highlight) {
                            featureOverlay.removeFeature(highlight);
                        }
                        if (feature) {
                            featureOverlay.addFeature(feature);
                        }
                        highlight = feature;
                    }

                    if (feature) {
                        if (feature.get('fid') && $('#infopopup').css('display') === "none") {
                            $("#titlepopup").show();
                            $("#titlecontent").html(feature.get('item_title'));
                        }
                    } else {
                        $("#titlepopup").hide();
                    }
                };

                //get feature info on hover
                map.on('pointermove', function (evt) {
                    if (evt.dragging) {
                        return;
                    }
                    var pixel = map.getEventPixel(evt.originalEvent);
                    displayTitleInfo(pixel);
                });

                ///get feature information on click
                map.on('click', function (evt) {
                    var feature = map.forEachFeatureAtPixel(evt.pixel,
                            function (feature, layer) {
                                return feature;
                            });

                    if (feature) {
                        if (feature.get('fid')) {
                            $("#titlepopup").hide();
                            $("#infopopup").show();
                            $("#popcontent").load("popup.php?id=" + feature.get('fid'));
                        }
                    }
                });
            });
        </script>
    </body>
</html>
