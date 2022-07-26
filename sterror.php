<html>
<body>
<p><a href="admin.php">Home</a> | <a href="	stock.php">view/move wearhouse stock</a> | <a href="	store1.php">view/move store 1 stock</a> | <a href="	store2.php">view/move store 2 stock</a> | <a href="userdel.php">view/delete users</a> | <a href="purchases.php">purchases</a> | <a href="bank.php">user banking details</a> | <a href="logout.php">logout</a> |  </p>

<h1>store 2 move stock</h1>
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
$admin_email = $_SESSION['email'];

//the sql statment is placed in a vairable
//selects the user that logged in by matching the email with the user id
$q = "select users_id from u_login 
where email = '$admin_email'";

//the sql statment is connected to the database to collect the information and placed in a vairable 
$res = $db->query($q);

while($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
    $admin_id = $row['users_id'];
}

//the sql statment is placed in a vairable
//the user id is then selected with the use of the variable $admin_id
$get_admin = "select * from u_login 
where users_id = '$admin_id' ";

//the sql statment is executed
$admin = $db->query($get_admin);


$admin_details = $admin ->fetchRow(MDB2_FETCHMODE_ASSOC);

//the sql statment is placed in a vairable
//the foreign key of users_id in the u_loggin table is matched with the primary key of users_id in the users table 
// with the use of the variable $admin_id the id of the logged in user is matched with the user_id in the users table to get users details 
$admin_name = "select * from u_login,users 
where users.users_id = u_login.users_id 
and users.users_id = '$admin_id'";
$res1 = $db->query($admin_name);
?>

<?php
$i=0;

while ($row = $res1->fetchRow(MDB2_FETCHMODE_ASSOC)){
?>

	<p>Logged in as: <?php echo $row["fname"]; ?> <?php echo $row["lname"]; ?>  | username/email: <?php echo $row["email"]; ?></p>

	<?php
	$i++;
	}
	?>


<p>error occured stock cannot go bellow zero please try to move a different ammount of stock</p>
<p>go back and try again <a href="stock.php">stock warehouse</a> | <a href="store1.php">store 1</a> | <a href="	store2.php">store 2 </a></p>
</body>
</html>