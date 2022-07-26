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

 

<?php  
//the sql statment is placed in a vairable
// the tables stores,product,stock_warehouse are selected and the foreign keys are linked to the primary keys to call the data from the table containing the primary key
// only data from store 2 is called 
$q ="select * from stores,product,stock_warehouse
where product.product_id=stores.product_id
and stores.stock_id=stock_warehouse.stock_id
and store_pr_id='2' order by store_id ";
 //the sql statment is executed and checked for errors 
$res = $db->query($q);

if (PEAR::isError($res)){
die($res->getMessage());
}
?>
<table border=5>
	<tr>
	<th>store id</th>
	<th>store name</th>
	<th>product_id</th>
	<th>product name</th>
	<th>product cost</th>
	<th>product type</th>
	<th>product description</th>
	<th>store stock</th>
	<th>stock qtty select</th>
	<th>move stock</th>
	</tr>
<?php
$i=0;
//MDB2_FETCHMODE_ASSOC makes sure the columns are named after the table atributes instead of numerical 
while ($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
// the information from the tables are called and put into a table 
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">
	<td><?php echo $row["store_id"]; ?></td>
	<td><?php echo $row["store_name"]; ?></td>
	<td><?php echo $row["product_id"]; ?></td>
	<td><?php echo $row["product_name"]; ?></td>
	<td><?php echo "£", $row["product_cost"]; ?></td>
	<td><?php echo $row["product_type"]; ?></td>
	<td><?php echo $row["product_description"]; ?></td>
	<td><?php echo $row["store_stock"]; ?></td>
	<?php
	//a form is created to send the data to 
	?>
	<form action="updatestock.php" method="post">
	<input type="hidden" name="id" value="<?php echo $row["store_id"]; ?>" id="id" readonly></input>
	<input type="hidden" name="sp" value="<?php echo $row["store_pr_id"] = '1'; ?>" id="sp" readonly></input>
	<input type="hidden" name="pid" value="<?php echo $row["product_id"]; ?>" id="pid" readonly></input>
	<input type="hidden" name="stock1" value="<?php echo $row["store_stock"]; ?>" id="stock1" readonly></input>
	
	 <td><input type="number" name="stock2" id="stock2" required ></input><br></td>
	 <td><button type="subbmit" formmethod="post">move</button><br></td>
	</form>
	
	</tr>
	<?php
	$i++;
	}
	
	?>
</table>
<button onclick="window.print()">Print this page</button>
</body>
</html>