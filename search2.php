<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<script src="sorttable.js" charset="utf-8"></script>
	<title>PHP/PostgreSQL-test</title>
	<script type="application/javascript">
		function loadfunc(){

			var request =  get_XmlHttp();
			request.open("POST", "result2.php", true);
			request.send();
		
			request.onreadystatechange = function() {
				if (request.readyState == 4) {
					document.getElementById("txtHint").innerHTML = request.responseText;
				}
			}
		};
	
	
		function isNumberKey(evt)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			return true;
		}
		function search()
		{
			window.location = 'result.php';
		}
	</script>
	<script>
	// create the XMLHttpRequest object, according browser
	function get_XmlHttp() {
		// create the variable that will contain the instance of the XMLHttpRequest object (initially with null value)
		var xmlHttp = null;

		if(window.XMLHttpRequest) {		// for Forefox, IE7+, Opera, Safari, ...
			xmlHttp = new XMLHttpRequest();
		}
		else if(window.ActiveXObject) {	// for Internet Explorer 5 or 6
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		return xmlHttp;
	}

	// sends data to a php file, via POST, and displays the received answer
	function ajaxrequest() {
		var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
		var rooms1 = document.getElementById('minRooms');
		var rooms2 = document.getElementById('maxRooms');
		var location = document.getElementById('location');
		var object = document.getElementById('object');
		
		// create pairs index=value with data that must be sent to server
		var  the_data = 'minArea='+document.getElementById('minArea').innerHTML+
						'&maxArea='+document.getElementById('maxArea').innerHTML+
						'&minRooms='+rooms1.options[rooms1.selectedIndex].value+
						'&maxRooms='+rooms2.options[rooms2.selectedIndex].value+
						'&minPrice='+document.getElementById('minPrice').innerHTML+
						'&maxPrice='+document.getElementById('maxPrice').innerHTML+
						'&minFee='+document.getElementById('minFee').innerHTML+
						'&maxFee='+document.getElementById('maxFee').innerHTML+
						'&location='+location.options[location.selectedIndex].value+
						'&object='+object.options[object.selectedIndex].value+
						'&orderBy=pris'; 

		request.open("POST", "result2.php", true);			// set the request

		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		// adds  a header to tell the PHP script to recognize the data as is sent via POST
		request.send(the_data);		// calls the send() method with datas as parameter

		// Check request status
		// If the response is received completely, will be transferred to the HTML tag with
		request.onreadystatechange = function() {
			if (request.readyState == 4) {
				document.getElementById("txtHint").innerHTML = request.responseText;
			}
		}
	}
	</script>
	
</head>
<body onload="loadfunc()">

	<?php
		//phpinfo();
		$link = pg_connect("host=psql-vt2013 dbname=mathlin user=mathlin password=K5YKOU4tof");
		$result = pg_exec($link, "select * from bostader");
		$numrows = pg_numrows($result);
	?>
	<form>
		Area, Min: 
		<input class="FormElement" id="minArea" type="text" size="3" maxlength="3" value="" onkeypress="return isNumberKey(event)"> 
		 Max:
		<input class="FormElement" id="maxArea" type="text" size="3" maxlength="3" value="" onkeypress="return isNumberKey(event)"> 
		<br />
		Antal rum, Min:
		<select id="minRooms" onchange="ajaxrequest()">
			<?php
				$roomResult = pg_query("SELECT DISTINCT rum FROM bostader ORDER BY rum");
				$rows = pg_numrows($roomResult);
				for($ri = 0; $ri < $rows; $ri++) {
					$row = pg_fetch_array($roomResult, $ri);
					echo "<option value='", $row["rum"], "'>", $row["rum"], "</option>";
				}    
			?>
		</select>
		 Max: 
		 <select id="maxRooms" onchange="ajaxrequest()">
			<?php
				$roomResult = pg_query("SELECT DISTINCT rum FROM bostader ORDER BY rum");
				$rows = pg_numrows($roomResult);
				for($ri = 0; $ri < $rows; $ri++) {
					$row = pg_fetch_array($roomResult, $ri);
					if($ri + 1 == $rows) {
						echo "<option selected value='", $row["rum"], "'>", $row["rum"], "</option>";
					} else {
						echo "<option value='", $row["rum"], "'>", $row["rum"], "</option>";
					}
				}    
			?>
		</select>
		<br />
		Pris, Min: 
		<input class="FormElement" id="minPrice" type="text" size="9" maxlength="9" value="" onkeypress="return isNumberKey(event)"> 
		 Max:
		<input class="FormElement" id="maxPrice" type="text" size="9" maxlength="9" value="" onkeypress="return isNumberKey(event)"> 
		<br />
		Avgift, Min: 
		<input class="FormElement" id="minFee" type="text" size="5" maxlength="5" value="" onkeypress="return isNumberKey(event)"> 
		 Max:
		<input class="FormElement" id="maxFee" type="text" size="5" maxlength="5" value="" onkeypress="return isNumberKey(event)"> 
		<br />
		Län:
		<select id="location" onchange="ajaxrequest()">
			<option value='Samtliga'>Samtliga</option>
			<?php
				$lanResult = pg_query("SELECT DISTINCT lan FROM bostader ORDER BY lan");
				$rows = pg_numrows($lanResult);
				for($ri = 0; $ri < $rows; $ri++) {
					$row = pg_fetch_array($lanResult, $ri);
					echo "<option value='", $row["lan"], "'>", $row["lan"], "</option>";
				}    
			?>           
		</select>
		<br />
		Boendetyp:
		<select id="object" onchange="ajaxrequest()">
			<option value='Samtliga'>Samtliga</option>
			<?php
				$objResult = pg_query("SELECT DISTINCT objekttyp FROM bostader ORDER BY objekttyp");
				$rows = pg_numrows($objResult);
				for($ri = 0; $ri < $rows; $ri++) {
					$row = pg_fetch_array($objResult, $ri);
					echo "<option value='", $row["objekttyp"], "'>", $row["objekttyp"], "</option>";
				}    
			?>                
		</select>
		<br />
		<br />
		<br />
		<br />
	</form>
	<br>
	<div id="txtHint"><b>Table will go here!</b></div>

</body> 
</html>
