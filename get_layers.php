<?php
include('config.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query('SELECT DISTINCT exhibit_id FROM omeka_neatline_records');
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row1 as $key => $value){
        if(! in_array($value["exhibit_id"], $excludeExhibits)){
        $ev[] = $value["exhibit_id"];
        }
    }
    $evstring = implode(",", $ev);
}
    
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }

    $conn = null;
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sel = "SELECT DISTINCT id,title,narrative FROM omeka_neatline_exhibits WHERE id IN ($evstring)";
    $stmt = $conn->query($sel);
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    foreach ($row1 as $k => &$v) {
        foreach ($v as $k1 => &$v1){
            $v1 = escapeJsonString($v1);
        }
}
    echo json_encode($row1);
}
    
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
    
    function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\\"", "", "", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}

function debug_to_console( $data ) {
    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}
    ?>
