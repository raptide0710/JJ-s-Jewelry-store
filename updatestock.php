<html>
<body>
<p><a href="admin.php">Home</a> | <a href="	stock.php">view/move wearhouse stock</a> | <a href="	store1.php">view/move store 1 stock</a> | <a href="	store2.php">view/move store 2 stock</a> | <a href="userdel.php">view/delete users</a> | <a href="purchases.php">purchases</a> | <a href="bank.php">user banking details</a> | <a href="logout.php">logout</a> |  </p>

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

<?php  

//a connection is made to the database using the connect.php file 
require_once('connect.php');

//data from the form store1.php and store2.php is collected in the respective variables
    $stock1 = $_POST['stock1'];
	$stock2 = $_POST['stock2'];
	$id = $_POST['id'];
	$pid = $_POST['pid'];
	$sp = $_POST['sp'];
 // value1 is the stock in the store 	
	$value1= $stock1;
// value2 is the stock in the admmin wants to move
	$value2= $stock2;
// value3 is value1 minus value2 this is done to get the remainig stock when stock is moved to a different store
	$value3= $value1 - $value2;

// store1 or store2 is updated with the value3 depending on which store the stock was moved from 
	$q = "update stores set store_stock = $value3 
	where store_id = $id ";	
	//the sql statment is executed and checked for errors 
	$res= $db->query($q);
	
if($value3 <'0'){
		die(header("location: sterror.php")) ;
	}
	if (PEAR::isError($res)){
		die ($res->getMessage(). $res->getUserInfo());
	
}
// the stock that was moved is added to the stock of store1 or store2 
        else( $q2 = "update stores 
		set store_stock = store_stock + $value2 
		where product_id = $pid 
		and store_pr_id = $sp");{
		
		//the sql statment is executed and checked for errors 
        $res2= $db->query($q2);
		if (PEAR::isError($res2)){
		die ($res2->getMessage(). $res2->getUserInfo());}
		
    } 

        $res->free();
$db->disconnect();

?>
<p> you have successfully moved <?php echo "$stock2"?> quantity of stock to store <?php echo "$sp"?></p>
</body>

</html>