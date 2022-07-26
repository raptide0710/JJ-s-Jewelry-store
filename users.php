<html>
<body>
<p>|<a href="users.php">users home</a> | <a href="	pr.php">buy jewellery</a> | <a href="logout.php">logout</a> |  <a href="userspurchases.php"> view purchases</a>  | </p>
<h1>users home</h1>
<?php
//start of session 
session_start();
//if user does not login they are redirected to the login page
if(!isset($_SESSION['email'])){
    die(header("location: login.php"));
}
//a connection is made to the database using the connect.php file 
require_once('connect.php');

	
// collect email in a variable
$user_email = $_SESSION['email'];

//the sql statment is placed in a vairable
//selects the user that logged in by matching the email with the user id
$q = "select users_id from u_login 
where email = '$user_email'";

//the sql statment is connected to the database to collect the information and placed in a vairable 
$res = $db->query($q);


while($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
    $user_id = $row['users_id'];
}

//the sql statment is placed in a vairable
//the user id is then selected with the use of the variable $user_id
$get_user = "select * from u_login 
where users_id = '$user_id' ";

//the sql statment is executed
$user = $db->query($get_user);


$user_details = $user ->fetchRow(MDB2_FETCHMODE_ASSOC);

//the sql statment is placed in a vairable
//the foreign key of users_id in the u_loggin table is matched with the primary key of users_id in the users table 
// with the use of the variable $user_id the id of the logged in user is matched with the user_id in the users table to get users details 
$user_name = "select * from u_login,users 
where users.users_id = u_login.users_id 
and users.users_id = '$user_id'";
$res1 = $db->query($user_name);
?>

<?php
$i=0;

while ($row = $res1->fetchRow(MDB2_FETCHMODE_ASSOC)){
?>
	<p>Logged in as: <?php echo $row["fname"]; ?> <?php echo $row["lname"]; ?>  | username/email: <?php echo $row["email"]; ?></p>
	<p><?php echo $row["fname"]," ", $row["lname"];?>  you will now be able to purchase products and view the purchases you have made</p>
	<p>use the navigation bar above to navigate the website</p>
	<?php
	$i++;
	}
	?>


<p></p>
</body>
</html>