/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ed = [];

$(".base").change(function () {
    switch ($("input:radio[name=base]:checked").val()) {
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

function getLayers() {
    $.getJSON("get_layers.php", function (data) {//call the script that will get the json from the mysql database
        $.each(data, function (key, val) { //loop through the 
            $url = "get_records.php?eid[]=" + val["id"];
            $.get($url, function (NeatlineExhibits) {
                var vectorSource = new ol.source.Vector({
                    features: (new ol.format.GeoJSON()).readFeatures(NeatlineExhibits)
                });
                var myLayer = new ol.layer.Vector({
                    source: vectorSource,
                    exhibitname: val["title"],
                    style: styleFunction
                });
                map.addLayer(myLayer);
                tmp_title = val["title"];
                ed[tmp_title] = val["narrative"];
                newLayerAdded(val["title"], val["narrative"], myLayer);
            });
        });
    });
}

function newLayerAdded(layerName, desc, layer) {
    var new_layer = document.createElement('div');
    new_layer.setAttribute("class", "layer");
    new_layer.setAttribute("id", layerName);
    var new_checkbox = document.createElement("input");
    new_checkbox.setAttribute("type", "checkbox");
    new_checkbox.setAttribute("id", layerName);
    new_checkbox.setAttribute("class", "layer_check");
    var new_layerlabel = document.createTextNode(layerName);
    $("#layerlist").append(new_checkbox);
    new_layer.appendChild(new_layerlabel);
    $("#layerlist").append(new_layer);
    var visible = $(new_checkbox);
    visible.on('change', function () {
        layer.setVisible(this.checked);
    });
    visible.prop('checked', layer.getVisible());
}