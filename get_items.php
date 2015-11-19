<?php
include('config.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sel = "SELECT * FROM `omeka_element_texts` WHERE `element_id` = 53 AND `text` LIKE 'Stella'";
    $stmt = $conn->query($sel);
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($row1);
}
    
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
    
    ?>
