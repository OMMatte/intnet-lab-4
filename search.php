<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>PHP/PostgreSQL-test</title>
	<script type="application/javascript">
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
	
	
</head>
<body>

	<?php
		//phpinfo();
		$link = pg_connect("host=psql-vt2013 dbname=mathlin user=mathlin password=K5YKOU4tof");
		$result = pg_exec($link, "select * from bostader");
		$numrows = pg_numrows($result);
	?>
	<form action="result.php" method="post">
		Area, Min: 
		<input class="FormElement" name="minArea" type="text" size="3" maxlength="3" value="" onkeypress="return isNumberKey(event)"> 
		 Max:
		<input class="FormElement" name="maxArea" type="text" size="3" maxlength="3" value="" onkeypress="return isNumberKey(event)"> 
		<br />
		Antal rum, Min:
		<select name="minRooms">
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
		 <select name="maxRooms">
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
		<input class="FormElement" name="minPrice" type="text" size="9" maxlength="9" value="" onkeypress="return isNumberKey(event)"> 
		 Max:
		<input class="FormElement" name="maxPrice" type="text" size="9" maxlength="9" value="" onkeypress="return isNumberKey(event)"> 
		<br />
		Avgift, Min: 
		<input class="FormElement" name="minFee" type="text" size="5" maxlength="5" value="" onkeypress="return isNumberKey(event)"> 
		 Max:
		<input class="FormElement" name="maxFee" type="text" size="5" maxlength="5" value="" onkeypress="return isNumberKey(event)"> 
		<br />
		Län:
		<select name="location">
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
		<select name="object">
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
			<button type="submit" name="formSubmit" value="Submit">Search</button>
	</form>
	<?php
		pg_close($link);
	?>
</body> 
</html>
