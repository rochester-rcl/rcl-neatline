/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    //attibution giving esri credit for their data
    var attribution = new ol.Attribution({
    html: 'Tiles &copy; <a href="http://services.arcgisonline.com/ArcGIS/' +
            'rest/services/World_Topo_Map/MapServer">ArcGIS</a>'
});

//configure the ESRI layer
var ESRI = new ol.layer.Tile({
    source: new ol.source.XYZ({
        attributions: [attribution],
        url: 'http://server.arcgisonline.com/ArcGIS/rest/services/' +
                'World_Topo_Map/MapServer/tile/{z}/{y}/{x}'
    }),
    visible: false
});

//configure the stamen toner layer
var toner = new ol.layer.Tile({
    source: new ol.source.Stamen({
        layer: 'toner-lite'
    }),
    visible: false
});

//configure the stamen watercolor layer
var WC = new ol.layer.Tile({
    source: new ol.source.Stamen({
        layer: 'watercolor'
    }),
    visible: false
});

//configure the stamen Open Street Map layer
var OSM = new ol.layer.Tile({
    source: new ol.source.OSM(),
    name: "raster",
    exhibitname: "na",
    visible: true
});
