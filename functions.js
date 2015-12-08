var apiURL = "http://localhost:8888/omeka/api/";

var ed = [];

function blToggle(bl) {
    var layers = baseLayers.getLayers();
    layers.forEach(function (currentLayer) {
        if (currentLayer.get("exhibitname") === bl) {
            currentLayer.setVisible(1);
        } else {
            currentLayer.setVisible(0);
        }
    });
}

function clearLayers(){ 
    $("#exhibitlist").empty();
    if (exhibitLayers){
    var layers = exhibitLayers.getLayers();
    layers.forEach(function (currentLayer){
        map.removeLayer(currentLayer);
    });
    }
}

function getLayers() {
    //var exhibitGroup = new ol.layer.Group();
    //exhibitGroup.set("group_name", "exhibits");
    //var eC = new ol.Collection();
    $.getJSON("get_layers.php", function (data) {//call the script that will get the json from the mysql database

        $.each(data, function (key, val) { //loop through the 
            $url = "get_records.php?eid[]=" + val["id"];
            $.get($url, function (NeatlineExhibits) {
                var tmp = JSON.parse(NeatlineExhibits);

                var vectorSource = new ol.source.Vector({
                    features: (new ol.format.GeoJSON()).readFeatures(tmp)
                });

                var myLayer = new ol.layer.Vector({
                    group: "exhibits",
                    source: vectorSource,
                    exhibitname: val["title"],
                    style: styleFunction
                });
                
                map.addLayer(myLayer);
                tmp_title = val["title"];
                ed[tmp_title] = val["narrative"];
                newLayerAdded(val["title"], val["narrative"], myLayer, "layer_check", "checkbox");
            });
        });
    });
}


function newBaseAdded(layerName, desc, layer, div, type) {
    var new_layer = document.createElement('div');
    new_layer.setAttribute("class", "layer");
    new_layer.setAttribute("id", layerName);
    var new_checkbox = document.createElement("input");
    new_checkbox.setAttribute("type", type);
     new_checkbox.setAttribute("name", div);
    new_checkbox.setAttribute("class", div);
    new_checkbox.setAttribute("value", desc);
    new_checkbox.setAttribute("checked", true);
    var new_layerlabel = document.createTextNode(layerName);
    $("#baselist").append(new_checkbox);
     var nl = document.createElement("BR");
    //new_layer.appendChild(new_layerlabel);
    $("#baselist").append(new_layerlabel);
    $("#baselist").append(nl);
}
function newLayerAdded(layerName, desc, layer, div, type) {
    var new_layer = document.createElement('div');
    new_layer.setAttribute("class", "layer");
    new_layer.setAttribute("id", layerName);
    var new_checkbox = document.createElement("input");
    //if (type === "checkbox"){
    new_checkbox.setAttribute("type", type);
    //} else {
    //     new_checkbox.setAttribute("type", "radio");
    //}
    //new_checkbox.setAttribute("id", layerName);
     new_checkbox.setAttribute("name", div);
    //new_checkbox.setAttribute("class", "layer_check");
    new_checkbox.setAttribute("class", div);
    new_checkbox.setAttribute("value", desc);
    var new_layerlabel = document.createTextNode(layerName);
    $("#exhibitlist").append(new_checkbox);
    new_layer.appendChild(new_layerlabel);
    $("#exhibitlist").append(new_layer);
    if (type === "checkbox"){
    var visible = $(new_checkbox);
    visible.on('change', function () {
        layer.setVisible(this.checked);
    });
    visible.prop('checked', layer.getVisible());
    }
}

