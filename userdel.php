<html>
<body>
<p><a href="admin.php">Home</a> | <a href="	stock.php">view/move wearhouse stock</a> | <a href="	store1.php">view/move store 1 stock</a> | <a href="	store2.php">view/move store 2 stock</a> | <a href="userdel.php">view/delete users</a> | <a href="purchases.php">purchases</a> | <a href="bank.php">user banking details</a> | <a href="logout.php">logout</a> |  </p>

<h1>delete/view users</h1>
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
//the sql statment is placed in a vairable
// the tables users,u_login,telephone,u_address are selected and the foreign keys in each of the tables are linked to the primary key of users_id in the users table

$query ="select * from users,u_login,telephone,u_address
where users.users_id=u_login.users_id 
and users.users_id = telephone.users_id
and users.users_id = u_address.users_id 
and admin_status = 'n'";

 //the sql statment is executed  and checked for errors 
$result = $db->query($query);

if (PEAR::isError($result)){
die($result->getMessage());
}
?>
<table border=5>
	<tr>
	<td>user Id</td>
	<td>First Name</td>
	<td>Last Name</td>
	<td>date of birth</td>
	<td>admin status</td>
	<td>telephone number 1</td>
	<td>telephone number 2</td>
	<td>email</td>
	<th>address</th>
	<th>delete</th>
	
	</tr>
<?php
$i=0;
//MDB2_FETCHMODE_ASSOC makes sure the columns are named after the table atributes instead of numerical 
while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)){
	// the information from the tables are called and put into a table 
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">
	<td><?php echo $row["users_id"]; ?></td>
	<td><?php echo $row["fname"]; ?></td>
	<td><?php echo $row["lname"]; ?></td>
	<td><?php echo $row["dob"]; ?></td>
	<td><?php echo $row["admin_status"]; ?></td>
	<td><?php echo $row["tel_num1"]; ?></td>
	<td><?php echo $row["tel_num2"]; ?></td>
	<td><?php echo $row["email"]; ?></td>
	<td><?php echo $row["address"]; ?></td>
	 <td><a href="delete.php?id=<?php echo $row['users_id']; ?>">Delete</a></td>
	</tr>
	<?php
	$i++;
	}
	?>
</table>


<button onclick="window.print()">Print this report</button>
</body>
</html>