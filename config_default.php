<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "Omeka";
$doFilter = 1; //should a filter be included? 1 for yes, 0 for no
$filterType = 1; //NOT IMPLEMENTED 1 is a filter text box, 2 is a dropdown with listed elements, 3 is a dropdown with all elements
$filterField = "Architect";//which field to filter on if filterType = 1
$filterDropdown = array("Architect", "Building Material");//list of items in the dropdown for filter NOT IMPLEMENTED
?>