/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

function lTl() {

    var items = new vis.DataSet([]);
    var layers = map.getLayers();
    console.log(layers);

    layers.forEach(function (currentLayer) {
        if (currentLayer.get('group') === "exhibits") {
            currentLayer.getSource().forEachFeature(function (currentFeature) {
                console.log(currentFeature.getProperties());
                if (currentFeature.get("start_date")) {
                    var startDate = new Date(currentFeature.get("start_date"));
                    var endDate = new Date(currentFeature.get("end_date"));
                    items.add([{id: currentFeature.get("fid"), content: currentFeature.get("item_title"), start: startDate, end: endDate}]);
                }
                ;
            });
        };
    });

    var container = document.getElementById('visualization');
    var options = {
        editable: true
    };
    var timeline = new vis.Timeline(container, items, options);

    timeline.on('rangechange', function (properties) {
        //logEvent('rangechange', properties);
        changeVis(timeline.getVisibleItems());
        console.log(timeline.getVisibleItems());
    });
    timeline.on('rangechanged', function (properties) {
        //logEvent('rangechanged', properties);
    });
    timeline.on('select', function (properties) {
        //logEvent('select', properties);
    });

    items.on('*', function (event, properties) {
        //logEvent(event, properties);
    });
}

function changeVis(visItems) {
    var layers = map.getLayers();
    layers.forEach(function (currentLayer) {
        if (currentLayer.get('group') === "exhibits") {
            currentLayer.getSource().forEachFeature(function (currentFeature) {
                console.log(currentFeature.getProperties());
                console.log("\"" + currentFeature.get('fid').toString() + "\"");
                if (visItems.indexOf(currentFeature.get('fid').toString()) < 0) {
                    currentFeature.set('hidden', true);
                } else {
                    currentFeature.set('hidden', false);
                }
            });
        }
        ;
    });
}