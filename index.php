<?php
//include database login details
include_once 'php/data.php';

//include database login details
include_once 'php/functions.php';

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
      <h3><?php echo NAME; ?></h3>
      <h5><?php echo ADDRESS; ?></h5>
      <form id="track-trace"> <!--acton="" method="post" -->
        <fieldset>
          <label for="first">First name*: </label><br />
          <input id="first" type="text" name="first" placeholder="first name" required />
        </fieldset>
        <fieldset>
          <label for="last">Last name*:</label><br />
          <input id="last" type="text" name="last" placeholder="last name" required />
        </fieldset>
        <fieldset>
        <label for="email">Email:</label><br />
        <input id="email" type="email" name="email" placeholder="yourname@domain.com" />
        </fieldset>
        <fieldset>
        <label for="phone">Phone number:</label><br />
        <input id="phone" type="tel" name="phone" placeholder="01234 567890" />
      </fieldset>
      <p onclick="">
        Enter postal address instead
      </p>
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
	$sql = "SELECT `text`, `value` FROM `".$name."`";
	selectList($sql);
?>
        </select>
      </fieldset>
<?php endforeach; ?>
        <p>Your details may be shared with the NHS on request. If you are under 13, please ask a parent/guardian to register on your behalf but if not possible, tick here <input type="checkbox" name="u13" value="1" /> and provide your parent/guardian’s mobile no. when you check in. Should you have any questions about your data please see our<br />
        <a href="#">Privacy Policy</a>.</p>
        <p><input type="checkbox" name="remember" value="1" /> Remember me on this device for 21 days</p>
        <input id="" type="submit" value="Check In" />
      </form><!-- end #track-trace -->
      <hr />
      <p>View our <a href="#">Privacy Policy</a>.</p>
    </div><!-- end #content-->
  </div><!-- end #wrapper -->
<?php
//include external footer file
include_once 'footer.php';

//close db comms
$pdo = null;
?>
