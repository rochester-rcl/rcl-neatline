//set up the view

var view = new ol.View({
  center: [0, 5000000],
  zoom: 3
});
//set up the map and add the base layers
var baseLayers = addBaseLayers();


var map = new ol.Map({
  target: 'map',
  view: view
});

var eL = getLayers();
map.addLayer(baseLayers);
//console.log(eL);
//map.addLayer(eL);
map.getLayerGroup();