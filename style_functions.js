//set up the feature overlay  and styles so that feature highlight properly
var featureOverlay = new ol.FeatureOverlay({
    map: map,
    style: function (feature) {
        if(feature.get('fill_color_select')){
        var hexColor = feature.get('fill_color_select');
        var color = ol.color.asArray(hexColor);
        color = color.slice();
        color[3] = feature.get('fill_opacity_select'); // change the alpha of the color
        var sc = feature.get('stroke_color_select')
    }
        //this conditional tests if the feature is represented by an image file and sets 
        //the style appropriately
        if (feature.get('point_image')) {
       var myImg = new Image();
        myImg.src = feature.get('point_image');
        var myImage = new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
            opacity: color[3],
            offset: [0, 0],
            scale: 1,
            imgSize: [feature.get('point_radius'), feature.get('point_radius')],
            img: myImg
        }));
      console.log("put some code here to leave the image");
        }else{
            myImg = new ol.style.Circle({
                    radius:feature.get('point_radius'),
                    stroke: new ol.style.Stroke({
                        color: feature.get('stroke_color_select')
                    }),
                    fill: new ol.style.Fill({
                        color: color
                    }),
                });
            }   
        return [new ol.style.Style({
                fill: new ol.style.Fill({
                    color: color
                }),
                //image:myImg
                stroke: new ol.style.Stroke({
                    color: feature.get('stroke_color')
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
    //this conditional tests if the feature is represented by an image file and sets 
    //the style appropriately
    if (feature.get('point_image')) {
        var myImg = new Image();
        myImg.src = feature.get('point_image');
        var myImage = new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
            opacity: color[3],
            offset: [0, 0],
            scale: 1,
            imgSize: [feature.get('point_radius'), feature.get('point_radius')],
            img: myImg
        }));
        console.log(feature.get('point_image'));
    } else {
        myImage = new ol.style.Circle({
            radius: feature.get('point_radius'),
            stroke: new ol.style.Stroke({
                color: feature.get('stroke_color')
            }),
            fill: new ol.style.Fill({
                color: color
            }),
        });
    }

    return [new ol.style.Style({
            fill: new ol.style.Fill({
                color: color
            }),
            image: myImage,
            stroke: new ol.style.Stroke({
                color: feature.get('stroke_color')
            })
        })];
};
