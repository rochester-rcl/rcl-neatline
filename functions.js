var apiURL = "http://localhost:8888/omeka/api/";

var ed = [];
$(".base").change(function () {
    blToggle($("input:radio[name=base]:checked").val());
});

function blToggle(bl) {
    var layers = baseLayers.getLayers();
    layers.forEach(function (currentLayer) {
        if (currentLayer.get("exhibitname") == bl) {
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

function loadFeatures(data){
    clearLayers();
    var exhibitGroup = new ol.layer.Group();
    var exhibitCollection = new ol.Collection();
 $.each(data, function (key, val) { //loop through the 
            $url = "get_records.php?eid[]=" + val["id"];
            $.get($url, function (NeatlineExhibits) {
                var tmp = JSON.parse(NeatlineExhibits);
                if($("#textfilter").val()){
                tmp.features = $.grep(tmp.features, function(element, index){
                    return element.properties.fid == $("#textfilter").val(); //filter the records in the set
                    
                });
            }else{
                tmp = NeatlineExhibits;  
            }
          
                var vectorSource = new ol.source.Vector({
                    //features: (new ol.format.GeoJSON()).readFeatures(NeatlineExhibits)
                    features: (new ol.format.GeoJSON()).readFeatures(tmp)
                });
               
                var myLayer = new ol.layer.Vector({
                    source: vectorSource,
                    exhibitname: val["title"],
                    style:  styleFunction
                            /*function(feature, resolution) { 
                                if (feature.get('hidden')) { 
                                return null; 
                                }else { 
                                return styles; 
                                } 
                            } */
                });
                exhibitCollection.push(myLayer);
                map.addLayer(myLayer);
                tmp_title = val["title"];
                ed[tmp_title] = val["narrative"];
                newLayerAdded(val["title"], val["narrative"], myLayer);
            });
        });  
        exhibitGroup.setLayers(exhibitCollection);
        return exhibitGroup;
}

function getLayers() {
    $.getJSON("get_layers.php", function (data) {//call the script that will get the json from the mysql database
            exhibitLayers = loadFeatures(data);
           
            return exhibitLayers;
//       
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
    $("#exhibitlist").append(new_checkbox);
    new_layer.appendChild(new_layerlabel);
    $("#exhibitlist").append(new_layer);
    var visible = $(new_checkbox);
    visible.on('change', function () {
        layer.setVisible(this.checked);
    });
    visible.prop('checked', layer.getVisible());
}

