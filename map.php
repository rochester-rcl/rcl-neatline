<!DOCTYPE html>
<?php
include('config.php');
?>
<html lang="en">
    <head>
        <link rel="stylesheet" href="http://openlayers.org/en/v3.1.0/css/ol.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.9.0/vis.min.css">
        <link rel="stylesheet" href="neatline_mapper.css" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.9.0/vis.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ol3/3.11.0/ol.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <title>
<?php echo $pagetitle ?>
        </title>
    </head>

    <body>
        <div id="map" class="map">

            <?php
            //include ('filtering.php');
            ?>

            <div id="pagetitle"> <div id="title_box">  
                    <?php echo $pagetitle ?>
                </div></div>

            <div id="titlepopup">
                <div id="titlecontent"></div>
            </div>

            <div id="closer"><span class="fa-stack">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-circle-thin fa-stack-2x"></i>
                    <i class="fa fa-close fa-stack-1x"></i>
                </span></div>
            <div id="infopopup">
                <div>
                    <div id="popcontent"></div>
                </div>
            </div>
            <div id="layercontainer">
                <div id="min" title="Hide Layers"><i class="fa fa-minus-square"></i></div>
                <div id="max" title="Show Layers"><i class="fa fa-plus-square"></i></div>
                <div id="layerlist">
                    <div class="layer_heading">Base Layers</div>
                     <div id="baselist"></div>
                    <div class="layer_heading">Exhibits</div>
                    <div id="exhibitlist"></div>
                </div>
            </div>
        </div>
        <div id="visualization"></div>
      
        <script type="text/javascript">

            $(document).ready(function () {
                //hide the divs that will hold the title and the information popups
                $("#closer").hide();
                $("#titlepopup").hide();
                $("#infopopup").hide();
                $("#max").hide();

                var highlight;

                $("#rmvlayersbutton").click(
                        function () {
                            clearLayers();
                        });

                $("#filterbutton").click(
                        function () {
                            lTl();
                        });

                // });

                $("#closer").click(
                        function () {
                            //$( "#infopopup" ).hide(); 
                            $("#closer").hide();
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
                            $("#titlepopup").delay(800).fadeIn(400);
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
                            featureOverlay.getSource().removeFeature(highlight);
                        }
                        if (feature) {
                            featureOverlay.getSource().addFeature(feature);
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
                            $("#closer").show();
                            $("#popcontent").load("popup.php?id=" + feature.get('fid'));
                        }
                    }
                });
            //window.onload = lTl;
            window.setTimeout(lTl, 100);
             $(".base").change(function () {
             console.log("it changed");
                blToggle($("input:radio[name=base]:checked").val());
                });
            });

            
        </script>
        <script src="thetimeline.js"></script>
        <script src="functions.js"></script>
        <script src="layers.js"></script>
        <script src="map_config.js"></script>
        <script src="style_functions.js"></script>

    </body>
</html>
