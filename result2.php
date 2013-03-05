<?php
	//phpinfo();
	$link = pg_connect("host=psql-vt2013 dbname=mathlin user=mathlin password=K5YKOU4tof");
	$result = pg_exec($link, "select * from bostader");
	$numrows = pg_numrows($result);

	$minArea = $_POST['minArea'];
	$maxArea = $_POST['maxArea'];
	$minRooms = $_POST['minRooms'];
	$maxRooms = $_POST['maxRooms'];
	$minPrice = $_POST['minPrice'];
	$maxPrice = $_POST['maxPrice'];
	$minFee = $_POST['minFee'];
	$maxFee = $_POST['maxFee'];
	$location = $_POST['location'];
	$object = $_POST['object'];
	$orderBy = $_POST['orderBy'];
	
echo "<table border='1' id='resTable' class='sortable'> 
<tr> 
<th style='cursor: pointer;'>Län</th> 
<th style='cursor: pointer;'>Objekttyp</th> 
<th style='cursor: pointer;'>Adress</th> 
<th style='cursor: pointer;'>Area</th> 
<th style='cursor: pointer;'>Rum</th> 
<th style='cursor: pointer;'>Pris</th> 
<th style='cursor: pointer;'>Avgift</th></tr>";

if($minArea != "")
	$minArea = "area>='" . $minArea . "' AND "; 
if($maxArea != "")
	$maxArea = "area<='" . $maxArea . "' AND ";
if($minPrice != "")
	$minPrice = "pris>='" . $minPrice . "' AND "; 
if($maxPrice != "")
	$maxPrice = "pris<='" . $maxPrice . "' AND ";
if($minFee != "")
	$minFee = "avgift>='" . $minFee . "' AND "; 
if($maxFee != "")
	$maxFee = "avgift<='" . $maxFee . "' AND ";
if($location != "Samtliga")
	$location = "lan='" . $location . "' AND ";
else
	$location = "";
if($object != "Samtliga")
	$object = "objekttyp='" . $object . "' AND ";
else
	$object = "";
$minRooms = "rum>='" . $minRooms . "' AND ";
$maxRooms = "rum<='" . $maxRooms . "'";
 
$string = "SELECT * FROM bostader WHERE " . $minArea . $maxArea . $minPrice . $maxPrice . $minFee . $maxFee . $location . $object . $minRooms . $maxRooms . " ORDER BY " . $orderBy;

$result = pg_query($string);
$numrows = pg_numrows($result);
for($ri = 0; $ri < $numrows; $ri++) {
echo "<tr>\n";
$row = pg_fetch_array($result, $ri);
echo " <td>", $row["lan"], "</td>";
echo " <td>", $row["objekttyp"], "</td>";
echo " <td>", $row["adress"], "</td>";
echo " <td>", $row["area"], "</td>";
echo " <td>", $row["rum"], "</td>";
echo " <td>", $row["pris"], "</td>";
echo " <td>", $row["avgift"], "</td>";
}

echo "</table>";
pg_close($link);
?>