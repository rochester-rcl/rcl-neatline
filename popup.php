<html>
    <head>
        <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script>

<?php
echo "var itemid = " . $_GET[id] . ";";
echo "var method = '" . $_GET[method] . "';";
?>

            $(document).ready(function () {

                if (method == "title") {        
                   // var itemMeta = $.getJSON("http://humanities.lib.rochester.edu/ima/api/items/" + itemid, function (data) {
             
                        var itemMeta = $.getJSON(apiURL + "items/" + itemid, function (data) {

                        result = getItemData(data, "Title", function (d) {
                            $("#ititle").append("<h2>" + d + "</h2>");
                        });
                    });
                } else {
               
                    var itemMeta = $.getJSON(apiURL + "items/" + itemid, function (data) {
                        result = getItemData(data, "Title", function (d) {
                            $("#ititle").append("<h2>" + d + "</h2><hr>");
                        });

                        result = getItemData(data, "Description", function (d) {
                            $("#desc").append("<div class='redhead'>Description</div><p>" + d + "</p>");
                        });

                        result = getItemData(data, "Architect", function (d) {
                            $("#arch").append("<div class='redhead'>Architect</div><p>" + d + "</p>");
                        });

                        result = getItemData(data, "Year of Design", function (d) {
                            $("#yd").append("<div class='redhead'>Year of Design</div>" + d);
                        });

                        result = getItemData(data, "Year of Completion", function (d) {
                            $("#yc").append("<div class='redhead'>Year of Completion</div><p>" + d + "</p>");
                        });

                        result = getItemData(data, "Materials", function (d) {
                            $("#mat").append("<div class='redhead'>Materials</div><p>" + d + "</p>");
                        });
                    });

                    var imageMeta = $.getJSON(apiURL + "files?item=" + itemid, function (data) {
                        $("#thumbs").append("<div class='redhead'>Images</div>");

                        result = getImageFiles(data, function (t, f) {
                            if (t) {
                                $("#thumbs").append("<a target='new' href='" + f + "' >" + "<img class='thumb' src='" + t + "' /></a>");
                            } else {
                                $("#thumbs").html("");
                            }
                        });
                    });
                }

                function getImageFiles(data, callback) {
                    $.each(data, function (key, val) {
                        var thumb = val["file_urls"].thumbnail;
                        var full = val["file_urls"].fullsize;
                        callback(thumb, full);

                    });//end element iterator

                }

                function getItemData(data, el, callback) {
                    $.each(data["element_texts"], function (key, val) {
                        if (val.element.name == el) {
                            callback(val.text);
                        }
                    });//end element iterator
                }//end getItemData function

            });// end doc ready function

        </script>
    </head>
    <body>
        <div id="ititle"></div>
        <div id="desc"></div>
        <div id="arch"></div>
        <div id="yd"></div>
        <div id="yc"></div>
        <div id="mat"></div>
        <div id="thumbs"></div>
    </body>
</html>
