<?php
// include php data file
include_once 'php/data.php';

// include custom php functions
include_once 'php/functions.php';

// after the page reloads
if (isset($_COOKIE['trackData'])) {
	foreach($_COOKIE['trackData'] as $name => $value) {
		$form_values[$name][3] = $value;
		$form_values[$name][4] = 'off';
	}
	$form_email = array_slice($form_values, 2, 2);
	$form_address = array_slice($form_values, 4, 4);
	//print_r($form_values);
}

// open comms to database
try {
	$pdo = new PDO('mysql:host='.AUTH_HOST.'; dbname='.AUTH_DB.'', AUTH_USER, AUTH_PWD);
} catch (PDOException $e) {
	die("ERROR!: Could not connect: ".$e->getMessage()."<br/>");
}

//include external header file
include_once 'header.php';
?>

<div id="wrapper">
  <div id="content">
    <h1>COVID-19</h1>
    <h2> Track &amp; Trace Compliance</h2>
    <h2>QUICK CHECK-IN</h2>
    <h1><?php echo COMPANY; ?></h1>
    <h3><?php echo ADDRESS; ?></h3>
<?php if(!isset($_POST['submit']))	: ?>
    <form id="track-trace" acton="index.php" method="post">

<?php formBlocks($form_values, 0, 2); ?>

			<script>
				var detailsNode = '';
				var formEmail = <?php echo json_encode($form_email); ?>;
				var formAddress = <?php echo json_encode($form_address); ?>;
			</script>
			<div id="details">

<?php formBlocks($form_values, 2, 2); ?>

			<p id="switch_form" onclick="change_form(formAddress, 2, 6)">
				<i class="far fa-envelope"></i>
      	Enter postal address instead
			</p>
		</div><!-- end #details -->
<?php
$select_lists = [
  'numbers' => 'How many guests are with you?',
  'duration' => 'How long do you plan to stay?'
];
foreach($select_lists as $name => $value) :
?>
    <fieldset>
      <label for="<?php echo $name; ?>"><?php echo $value; ?></label><br />
      <select id="<?php echo $name; ?>" name="<?php echo $name; ?>">
      	<option value="" disabled selected>Select an option</option>
<?php
$sql = "SELECT `id`, `text` FROM `".$name."`";
selectList($sql);
?>
      </select>
    </fieldset>
<?php endforeach; ?>
      <p>Your details may be shared with the NHS on request. If you are under 13, please ask a parent/guardian to register on your behalf but if not possible, tick here <input type="checkbox" name="u13" value="1" /> and provide your parent/guardian’s mobile no. when you check in. Should you have any questions about your data please see our<br />
      <a href="#">Privacy Policy</a>.</p>
      <p><input type="checkbox" name="remember" value="1" /> Remember me on this device for 21 days</p>
      <input id="submit" type="submit" name="submit" value="Check In" />
    </form><!-- end #track-trace -->
<?php
else :
	// set cookies
	$postArray = $_POST;
	$removeSubmit = array_pop($postArray);
	if(isset($_POST['remember']) && $_POST['remember'] == 1) {
		foreach($postArray as $name => $value) {
			setcookie('trackData['.$name.']', htmlentities(''.$value.''), EXPIRY);
		}
	} else {
		foreach($postArray as $name => $value) {
			setcookie('trackData['.$name.']', htmlentities(''.$value.''));
		}
	}

	if (isset($_COOKIE['track_data'])) :

	// update database
	$sql = updateRecords($postArray);
	if(!$pdo->query($sql)) {
		echo "ERROR: Could not execute $sql. " . print_r($pdo->errorInfo());
	}
?>
		<div id="notice">
			<h2>SUCCESS!</h2>
			<p>Thank you for Checking In</p>
		</div><!-- end #notice -->
<?php
	endif;
endif;
?>
    <hr />
    <p>View our <a href="#">Privacy Policy</a>.</p>
  </div><!-- end #content-->

<?php
//include external footer file
include_once 'footer.php';

//close db comms
$pdo = null;
?>
