<?php
include('config.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query('SELECT DISTINCT exhibit_id FROM omeka_neatline_records');
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row1 as $key => $value){
        $ev[] = $value["exhibit_id"];
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
    echo json_encode($row1);
}
    
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
    
    ?>
