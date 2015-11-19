<?php

include('config_default.php');
if ($doFilter) {
    if ($filterType == 1) {
        echo "Filter features by " . $filterField .": <input type='text' id='textfilter'>";
    } elseif ($filterType == 2) {
        echo "<select id='selectfilter'>";
        foreach ($filterDropdown as $value) {
            echo "<option value='" . $value . "'>" . $value . "</option>";
        }
        echo "</select>";
    } else {
        echo "<select id='selectfilter'>";
        foreach ($filterDropdown as $value) {
            echo "<option value='" . $value . "'>" . $value . "</option>";
        }
        echo "</select>";
    }
echo "<!--<div id='rmvlayersbutton'>Remove All Layers</div>-->"
        . "<div id='filterbutton'>Filter Records</div>";    
} //end if
?>

