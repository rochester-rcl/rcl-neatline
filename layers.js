    //attibution giving esri credit for their data
   
 function addBaseLayers(){   
    var attribution = new ol.Attribution({
    html: 'Tiles &copy; <a href="http://services.arcgisonline.com/ArcGIS/' +
            'rest/services/World_Topo_Map/MapServer">ArcGIS</a>'
});

//configure the ESRI layer
var esri = new ol.layer.Tile({
    source: new ol.source.XYZ({
        attributions: [attribution],
        url: 'http://server.arcgisonline.com/ArcGIS/rest/services/' +
                'World_Topo_Map/MapServer/tile/{z}/{y}/{x}'
    }),
    visible: false,
    exhibitname: "esri",
    isBase: true
});
newBaseAdded("ESRI", "esri", esri, "base", "radio");
//configure the stamen toner layer
var toner = new ol.layer.Tile({
    source: new ol.source.Stamen({
        layer: 'toner-lite'
    }),
    visible: false,
    exhibitname: "toner",
    isBase: true
});
newBaseAdded("Stamen Toner", "toner", toner, "base", "radio");
//configure the stamen watercolor layer
var wc = new ol.layer.Tile({
    source: new ol.source.Stamen({
        layer: 'watercolor'
    }),
    visible: false,
    exhibitname: "wc",
    isBase: true
});
newBaseAdded("Stamen Watercolor", "wc", wc, "base", "radio");
//configure the stamen Open Street Map layer
var osm = new ol.layer.Tile({
    source: new ol.source.OSM(),
    name: "raster",
    exhibitname: "osm",
    visible: true,
    isBase: true
});
newBaseAdded("Open Street Map", "osm", osm, "base", "radio");

    var baseGroup = new ol.layer.Group({
    layers: [esri,toner,wc,osm],
    name: "Base Layers",
    opacity: .5
    });
    return baseGroup;
 }
 
