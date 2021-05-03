<?php
// include php data file
include_once 'php/data.php';

// include custom php functions
include_once 'php/functions.php';

// set cookies
if(isset($_POST['submit'])) {
	// print_r($_POST);
	$postArray = $_POST;
	$popArray = array_pop($postArray);
	if(isset($popArray['21days']) && $popArray['21days'] == 1) {
		setcookie('trackData', $popArray['email'], EXPIRY21);
	} else {
		setcookie('trackData', $popArray['email']);
	}
	// print_r($_COOKIE);
}

// open comms to database
try {
	$pdo = new PDO('mysql:host='.AUTH_HOST.'; dbname='.AUTH_DB.'', AUTH_USER, AUTH_PWD);
} catch (PDOException $e) {
	die("ERROR!: Could not connect: ".$e->getMessage()."<br/>");
}

// after the page reloads
if (isset($_COOKIE['trackData'])) {
	// set query using cookie data
	$sql = "SELECT * FROM track_visitors WHERE email = '".$_COOKIE['trackData']."' ORDER BY id DESC LIMIT 1";
	if ($result = $pdo->query($sql)) {
		$checked = 0;
		while ($row = $result->fetch()) {
			foreach($row as $name => $value) {
				if ($value != NULL) {
					$formValues[$name][1] = 'hidden';
					$formValues[$name][3] = $value;
				}
				if ($name == '21days' && $value == 1) {
					$checked = 1;
				}
			}
		}
		// print_r($formValues);
	} else {
		echo "ERROR: Could not execute $cookieSql. " . print_r($pdo->errorInfo());
	}
}

// create slices of form values array
$formEmail = array_slice($formValues, 2, 2);
// print_r($formEmail);
$formAddress = array_slice($formValues, 4, 4);
// print_r($formAddress);

//include external header file
include_once 'header.php';
?>

<div id="wrapper">
  <div id="content">
    <h1>COVID-19</h1>
    <h2>Track &amp; Trace Compliance</h2>
    <h2>QUICK CHECK-IN</h2>
    <h1><?php echo COMPANY; ?></h1>
    <h3><?php echo ADDRESS; ?></h3>
<?php if(!isset($_POST['submit']))	: ?>
		<script>
			// set javascript variables and pass php arrays
			var detailsNode = '';
			var formEmail = <?php echo json_encode($formEmail); ?>;
			var formAddress = <?php echo json_encode($formAddress); ?>;
		</script>

    <form id="track-trace" action="trackntrace.php" method="post">
<?php
// check if cookie is not set
if (!isset($_COOKIE['trackData'])) :
	// display form fields 'first' and 'last' name
	formBlocks($formValues, 0, 2);
?>
			<div id="details">
<?php
	// display form fields 'email' and 'phone'
	formBlocks($formValues, 2, 2);
?>
				<!-- dynamic switch for form fields -->
				<p id="switch_form" onclick="change_form(formAddress, 2, 6)">
					<i class="far fa-envelope"></i>
      		Enter postal address instead
				</p>
			</div><!-- end details -->
<?php
else : // if cookie is set
	$count = 0;
	foreach($formValues as $name => $value) {
		if($value[3] != '' && $count < 8) {
			echo '<input id="'.$name.'" type="'.$value[1].'" name="'.$name.'" value="'.$value[3].'" />'.PHP_EOL;
		}
		$count++;
	}
?>
			<div class="notice">
				<h2>Hi <?php echo htmlspecialchars($formValues['first'][3]); ?></h2>
				<p style="font-size: small;">Your details have been remembered<br />Just change details below<br />and click button to 'check in'</p>
			</div><!-- end #notice -->
<?php
endif; // ends cookie check

// display option list titles
foreach($selectLists as $name => $value) :
?>
    <fieldset>
      <label for="<?php echo $value[0]; ?>"><?php echo $value[1]; ?></label><br />
      <select id="<?php echo $value[0]; ?>" name="<?php echo $value[0]; ?>">
      	<option value="" disabled selected>Select an option</option>
<?php
// get data for option list from database
$sql = "SELECT `id`, `text` FROM `".$name."`";
selectList($sql);
?>
      </select>
    </fieldset>
<?php endforeach; ?>

      <p>Your details may be shared with the NHS on request. If you are under 13, please ask a parent/guardian to register on your behalf but if not possible, <label for="u13">tick here </label><input id="u13" type="checkbox" name="u13" value="1" /> and provide your parent/guardian’s mobile no. when you check in. Should you have any questions about your data please see our
      <a href="#">Privacy&nbsp;Policy</a>.</p>
<?php if ($checked == 1) : ?>
  	<p><input id="21days" type="checkbox" name="21days" value="1" checked /><label for="21days"> Remember me on this device for 21 days</label></p>
<?php else : ?>
		<p><input id="21days" type="checkbox" name="21days" value="1" /><label for="21days"> Remember me on this device for 21 days</label></p>
<?php endif; ?>
      <input id="submit" type="submit" name="submit" value="Check In" />
    </form><!-- end #track-trace -->

<?php
else : // if $_POST is set
	// build sql string
	$sql = updateRecords($postArray);
	// update database
	if($pdo->query($sql)) :
?>

		<div class="notice">
			<h2>SUCCESS!</h2>
			<p>Thank you for Checking In</p>
		</div><!-- end #notice -->

<?php
	else : // if database not updated
		echo "ERROR: Could not execute $sql. " . print_r($pdo->errorInfo());
	endif; // ends if database updated
endif; // ends if $_POST is not set
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
