
<?php
include_once('geoPHP.inc');
include('config.php');
//geophp_load();


if ($_GET){
    $in_statement = implode(",", $_GET[eid]);
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

$sel = "SELECT omeka_neatline_records.id, omeka_neatline_records.item_title, omeka_neatline_records.item_id, omeka_neatline_records.fill_color_select, omeka_neatline_records.stroke_color_select, omeka_neatline_records.fill_opacity_select, omeka_neatline_records.stroke_opacity_select, omeka_neatline_records.stroke_width, omeka_neatline_records.point_radius, omeka_neatline_records.fill_color, omeka_neatline_records.fill_opacity, omeka_neatline_records.stroke_color, asText(omeka_neatline_records.coverage),omeka_neatline_exhibits.title, omeka_neatline_exhibits.id
        FROM omeka_neatline_records
        LEFT JOIN omeka_neatline_exhibits
        ON omeka_neatline_records.exhibit_id=omeka_neatline_exhibits.id
        WHERE omeka_neatline_records.exhibit_id IN ($in_statement)";
        
   $stmt = $conn->query($sel);
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

function addGeo ($currentGeo, $lt, $props){
    if ($lt == 0){
    $currentGeo = '{"type": "Feature",' . '"geometry": '  . $currentGeo .  ',"properties":' . json_encode($props)  . '}';
    }else{
        $currentGeo = ',{"type": "Feature",' . '"geometry": '  . $currentGeo .  ',"properties":' . json_encode($props)  . '}';
    }
    return $currentGeo;
}
                     
         $startjson =  '{
        "type": "FeatureCollection", 
        "features": [';  
            
        $endjson = ']}';
  
  $finaljson = $startjson;
  $indx = 0;

  foreach($row1 as $currentRow){
//print($finaljson);
      $g = geoPHP::load($currentRow['asText(omeka_neatline_records.coverage)'],'wkt');
//print ($g);    
  $g1 = $g->out('json');
    $props = array('fid' => $currentRow['item_id'], 'fill_color_select' => $currentRow['fill_color_select'], 'fill_opacity_select' => $currentRow['fill_opacity_select'], 'stroke_color_select' => $currentRow['stroke_color_select'], 'stroke_opacity_select' => $currentRow['stroke_opacity_select'], 'item_title' => $currentRow['item_title'], 'stroke_width' => $currentRow['stroke_width'],  'point_radius' => $currentRow['point_radius'], 'fill_color' => $currentRow['fill_color'], 'stroke_color'=>$currentRow['stroke_color'], 'fill_opacity'=>$currentRow['fill_opacity']);
    $finaljson = $finaljson . addGeo($g1, $indx, $props);
    $indx = $indx + 1;
  }
  $finaljson = $finaljson . $endjson;
           
print ($finaljson);

    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;

?>
