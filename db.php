<html>
<head><title>PHP/PostgreSQL-test</title></head>
<body>
<?php
//phpinfo();
$link = pg_connect("host=pgsql3 dbname=mathlin user=mathlin password=K5YKOU4tof");
$result = pg_exec($link, "select * from bostader");
$numrows = pg_numrows($result);
?>
<table border="1"> <tr> <th>Adress</th> </tr>
<?php
for($ri = 0; $ri < $numrows; $ri++) {
echo "<tr>\n";
$row = pg_fetch_array($result, $ri);
echo " <td>", $row["adress"], "</td>";
}
pg_close($link);
?>
</table> </body> </html>
