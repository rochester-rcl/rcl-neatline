//set up the view
var view = new ol.View({
  center: [0, 5000000],
  zoom: 3
});
//set up the map and add the base layers
var map = new ol.Map({
  layers: [WC, toner, OSM, ESRI],
  target: 'map',
  view: view
});
