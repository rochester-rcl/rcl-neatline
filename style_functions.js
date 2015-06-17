/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//set up the feature overlay  and styles so that feature highlight properly
var featureOverlay = new ol.FeatureOverlay({
    map: map,
    style: function (feature) {
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

//setting up the style function for the features.  This gets the values from the features and uses it 
//to style the layers
var styleFunction = function (feature) {
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
