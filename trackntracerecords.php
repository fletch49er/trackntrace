<?php
// include php data file
include_once 'php/data.php';

// include custom php functions
include_once 'php/functions.php';

// open comms to database
try {
	$pdo = new PDO('mysql:host='.AUTH_HOST.'; dbname='.AUTH_DB.'', AUTH_USER, AUTH_PWD);
} catch (PDOException $e) {
	die("ERROR!: Could not connect: ".$e->getMessage()."<br/>");
}



$sql = "SELECT v.first, v.last, v.email, v.phone, v.address1, v.address2, v.townCity, v.postcode, v.u13, v.timestamp, n.text AS numbers, d.text AS duration FROM visitors AS v INNER JOIN numbers AS n ON v.numbers = n.id INNER JOIN duration AS d ON v.duration = d.id";

//include external header file
include_once 'header.php';
?>

<div id="wrapper">
  <div id="content">
		<h1>COVID-19</h1>
    <h2> Track &amp; Trace Records</h2>
    <h1><?php echo COMPANY; ?></h1>
    <h3><?php echo ADDRESS; ?></h3>
		<table>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Phone Number</th>
				<th>Address Line 1</th>
				<th>Address Line 2</th>
				<th>Town/City</th>
				<th>Postcode</th>
				<th>Size of Party</th>
				<th>Duration of stay</th>
				<th>U13</th>
				<th>Timestamp</th>
			</tr>
<?php
//execute query
if ($result = $pdo->query($sql)) :
	while($row = $result->fetch()) :
?>
			<tr>
				<td><?php echo $row['first']; ?></td>
				<td><?php echo $row['last']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td><?php echo $row['phone']; ?></td>
				<td><?php echo $row['address1']; ?></td>
				<td><?php echo $row['address2']; ?></td>
				<td><?php echo $row['townCity']; ?></td>
				<td><?php echo $row['postcode']; ?></td>
				<td><?php echo $row['numbers']; ?></td>
				<td><?php echo $row['duration']; ?></td>
				<td><?php echo $row['u13']; ?></td>
				<td><?php echo $row['timestamp']; ?></td>

			</tr>
<?php
	endwhile;
else :
	echo "ERROR: Could not execute $sql1.".print_r($pdo->errorInfo());
endif;
?>
		</table>

<?php
//include external footer file
include_once 'footer.php';

//close db comms
$pdo = null;
?>
</div><!-- end #wrapper -->
