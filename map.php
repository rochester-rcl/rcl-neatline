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

<div id="loadingcont">
<div id="loading">LOADING</div>

</div>
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
    
    <script type="text/javascript">

$(document).ready(function(){

var tmp = setTimeout(function(){
  $('#loading').hide();
   $('#loadingcont').hide();
}, 500);

 $( "#titlepopup" ).hide();

    $( "#infopopup" ).hide();
    $( "#max" ).hide();
    
    $( ".base" ).change(function() {
  
  switch($( "input:radio[name=base]:checked" ).val()) {
    case "esri":
        ESRI.setVisible(1);
        OSM.setVisible(0);
        toner.setVisible(0);
        WC.setVisible(0);
        break;
    case "OSM":
        ESRI.setVisible(0);
        OSM.setVisible(1);
        toner.setVisible(0);
        WC.setVisible(0);
        break;
    case "wc":
        ESRI.setVisible(0);
        OSM.setVisible(0);
        toner.setVisible(0);
        WC.setVisible(1);
        break;
    case "toner":
        ESRI.setVisible(0);
        OSM.setVisible(0);
        toner.setVisible(1);
        WC.setVisible(0);
        break;
    default:
        OSM.setVisible(1);
}
});
    
    var ed = [];
    
    var attribution = new ol.Attribution({
  html: 'Tiles &copy; <a href="http://services.arcgisonline.com/ArcGIS/' +
      'rest/services/World_Topo_Map/MapServer">ArcGIS</a>'
});
    
    var ESRI = new ol.layer.Tile({
      source: new ol.source.XYZ({
        attributions: [attribution],
        url: 'http://server.arcgisonline.com/ArcGIS/rest/services/' +
            'World_Topo_Map/MapServer/tile/{z}/{y}/{x}'
      }),
	visible: false
    });
        
        var toner = new ol.layer.Tile({
      source: new ol.source.Stamen({
        layer: 'toner-lite'
      }),
	visible: false
    });
        
        var WC = new ol.layer.Tile({
      source: new ol.source.Stamen({
        layer: 'watercolor'
      }),
	visible: false
    });
    
        var OSM = new ol.layer.Tile({
        source: new ol.source.OSM(),
        name: "raster",
        exhibitname: "na",
	visible: true 
        });
        
var view = new ol.View({
  center: [0, 5000000],
  zoom: 3
});

var map = new ol.Map({
  layers: [WC, toner, OSM, ESRI],
  target: 'map',
  view: view
});


var featureOverlay = new ol.FeatureOverlay({
  map: map,
  style:  function(feature) {
    var hexColor = feature.get('fill_color_select');
    var color = ol.color.asArray(hexColor);
    color = color.slice();
    color[3] = feature.get('fill_opacity_select'); // change the alpha of the color

  return [new ol.style.Style({
    fill: new ol.style.Fill({
      color: color 
    }),


  image: new ol.style.Circle({
      radius: 10,

 stroke: new ol.style.Stroke({
      color: feature.get('stroke_color_select')
    }),


        fill: new ol.style.Fill({
        color: color
      }),
}),

    stroke: new ol.style.Stroke({
      color: feature.get('stroke_color_select')
    })
  })];
}
});

 //adding some comments
var styleFunction = function(feature) {
    var hexColor = feature.get('fill_color');
    var color = ol.color.asArray(hexColor);
    color = color.slice();
    color[3] = feature.get('fill_opacity'); // change the alpha of the color
    
  return [new ol.style.Style({
    fill: new ol.style.Fill({
      color: color
    }),


  image: new ol.style.Circle({
      radius: 10, 
		
 stroke: new ol.style.Stroke({
      color: feature.get('stroke_color')
    }),

	
	fill: new ol.style.Fill({
        color: color 
      }), 
}),

    stroke: new ol.style.Stroke({
      color: feature.get('stroke_color')
    })
  })];
};

  
  function newLayerAdded(layerName, desc, layer) {
    var new_layer = document.createElement( 'div' );
    new_layer.setAttribute("class", "layer");
    new_layer.setAttribute("id", layerName);
    var new_checkbox = document.createElement("input");
    new_checkbox.setAttribute("type", "checkbox");
    new_checkbox.setAttribute("id", layerName);
    new_checkbox.setAttribute("class", "layer_check");
    var new_layerlabel = document.createTextNode(layerName);
    $( "#layerlist" ).append(new_checkbox);
    new_layer.appendChild(new_layerlabel);
    
    $( "#layerlist" ).append(new_layer);
    var visible = $(new_checkbox);
    visible.on('change', function() {
    layer.setVisible(this.checked);
  });
  visible.prop('checked', layer.getVisible());
  }
  
    $.getJSON( "get_layers.php", function( data ) {
        
        //console.log("data recieved");
        $.each( data, function( key, val ) {
                $url = "get_records.php?eid[]=" + val["id"];
                $.get($url, function( NeatlineExhibits) {
                  console.log (NeatlineExhibits);
                    
                    var vectorSource = new ol.source.Vector({
                  features: (new ol.format.GeoJSON()).readFeatures(NeatlineExhibits)
                    });
                    
                    var myLayer = new ol.layer.Vector({
                     source: vectorSource,
                    exhibitname: val["title"],
                    style: styleFunction
                    });
    
                    map.addLayer(myLayer);
                    tmp = val["title"];
                    ed[tmp] = val["narrative"];
                    //console.log(ed);
                    newLayerAdded(val["title"], val["narrative"], myLayer);                       
                });
            });    
    });
    
    
    
      $("#closer").click(
        function(){
           //$( "#infopopup" ).hide(); 
	$( "#popcontent" ).html(""); 
        $( "#infopopup" ).hide(); 
       
      });
      
      $("#min").click(
        function(){
           $( "#layerlist" ).hide();
           $( "#max" ).show();
           $( "#min" ).hide();
        });
      
      $("#max").click(
        function(){
           $( "#layerlist" ).show();
           $( "#max" ).hide();
           $( "#min" ).show();
        });
      
    //var tmp = setTimeout(function(){ 
    $( "#layerlist").on({
    mouseenter: function () {
      if (ed[this.id] && $('#infopopup').css('display') == "none") {
       $( "#titlepopup" ).show();
	 $( "#titlecontent" ).html(ed[this.id]);
      }
    },
    mouseleave: function () {
       $( "#titlepopup" ).hide();
    }
}, 'div');

var highlight;

var displayTitleInfo = function(pixel) {

    var feature = map.forEachFeatureAtPixel(pixel, function(feature, layer) {
      return feature;
     });

 if (feature !== highlight) {
//console.log("should be highlighting stuff");
    if (highlight) {
      featureOverlay.removeFeature(highlight);
    }
    if (feature) {
      featureOverlay.addFeature(feature);
    }
    highlight = feature;
  }



    if (feature){
	 if(feature.get('fid') && $('#infopopup').css('display') == "none"){
         $( "#titlepopup" ).show();
	 $( "#titlecontent" ).html(feature.get('item_title'));
	/////////////
        }

	/////////////////

	}else{
//featureOverlay.removeFeature(highlight);

        $( "#titlepopup" ).hide();
}


}


//get feature info on hover
     map.on('pointermove', function(evt){
        if(evt.dragging){
	  return;
	}
	var pixel = map.getEventPixel(evt.originalEvent);
	displayTitleInfo(pixel);
     });

        ///get feature information on click
     map.on('click', function(evt) {
       var feature = map.forEachFeatureAtPixel(evt.pixel,
          function(feature, layer) {
             return feature;
          });

       if (feature) {
          if(feature.get('fid')){
	  $( "#titlepopup" ).hide();
             $( "#infopopup" ).show();
             $( "#popcontent" ).load( "popup.php?id=" + feature.get('fid') );       
          }  
       }  
   });
        

});
        
    </script>
  </body>
</html>
