<html>
<body>
<p>|<a href="users.php">users home</a> | <a href="	pr.php">buy jewellery</a> | <a href="logout.php">logout</a> |  <a href="userspurchases.php"> view purchases</a>  | </p>
<?php
//start of session 
session_start();
//if user does not login they are redirected to a purchase page where they cannot purchase a product 
if(!isset($_SESSION['email'])){
    die(header("location: pr2.php"));
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
	
	<p></p>
	
	
	<?php
	$i++;
	}
	?>

<?php
 
//a connection is made to the database using the connect.php file 
require_once('connect.php');
//data from the form pr.php is collected in the respective variables
    $stock1 = $_GET['stock1'];
	$stock2 = $_GET['stock2'];
	$id = $_GET['id'];
	$sid = $_GET['sid'];
	$pid = $_GET['pid'];
	$sqt = $_GET['sqt'];
	$pr = $_GET['pr'];
    
	
	
	 // value1 is the stock in the store 	
	$value1= $stock1;
	// value2 is the stock in the admmin wants to move
	$value2= $stock2;
	// value3 is value1 minus value2 this is done to get the remainig stock when a purchase has been made
	$value3= $value1 - $value2;
	// value4 multiplies the $value2 , $sid variables to get the total cost of products purchased
	$value4= $value2 * $sid;
	
	// store1 or store2 is updated with the value3 depending on which store the purchase was made from 
	$q = "update stores set store_stock = $value3 where store_id = $id";	
	
	//the sql statment is executed and checked for errors 
	$result= $db->query($q);
	if($value3 <'0'){
		die(header("location: purerror.php")) ;
	}
if (PEAR::isError($result)){
	
    die ($result->getMessage(). $result->getUserInfo());
	
}
		// the purchase information is inserted into the purchase table 
        else( $q2 = "insert into purchase (product_id, store_id,users_id,total,qtty_pur) VALUES ('$pid','$id','$sqt','$value4','$stock2')");{
		
		//the sql statment is executed and checked for errors 
        $result2= $db->query($q2);
		if (PEAR::isError($result2)){
		die ($result2->getMessage(). $result2->getUserInfo());}
		
    } 

        $result->free();
$db->disconnect();

?>
<p>you have successfully purchased <?php echo $stock2; ?> <?php echo $pr; ?> for <?php echo "£", $value4; ?> </p>
</html>
</body>