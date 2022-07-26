<html>
<body>

<p>|<a href="home.html">Home</a> | <a href="pr.php">buy jewellery</a> | <a href="	login.php">log in</a> or register to buy <a href="reg.php"> register</a> |  </p>


<h1>buy jewellery </h1>

<p><a href="login.php">log in</a> or register to buy <a href="reg.php"> register</a> <br>users who do not have an account and users who are not logged in will not be able to purchase products</p>
<p>on this page you will only be able to view the products available</p>
<?php  

//a connection is made to the database using the connect.php file 
require_once('connect.php');

//the sql statment is placed in a vairable
// the tables stores,product are selected and the foreign keys are linked to the primary keys to call the data from the table containing the primary key
//the store tock must me more than 0 for the row to be displayed
$q ="select * from stores,product where product.product_id=stores.product_id and store_stock > 0";


$res = $db->query($q);

if (PEAR::isError($res)){
die($res->getMessage());
}

?>
<table border=5>
	<tr>
	<th>store</th>
	<th>product_name</th>
	<th>product description</th>
	<th>product type</th>
	<th>product cost</th>
	<th>stock remaining</th>
	<th>select qtty</th>
	<th>purchase </th>
	</tr>
<?php
$i=0;
//MDB2_FETCHMODE_ASSOC makes sure the columns are named after the table atributes instead of numerical 
while ($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)){
// the information from the tables are called and put into a table 
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">
	<td><?php echo "store", $row["store_pr_id"]; ?></td>
	<td><?php echo $row["product_name"]; ?></td>	
	<td><?php echo  $row["product_description"]; ?></td>
	<td><?php echo  $row["product_type"]; ?></td>
 	<td><?php echo "£", $row["product_cost"]; ?></td>
	<td><?php echo  $row["store_stock"]; ?></td>
	<form action="#" method="get" >
		 <td><input type="number" name="stock2" id="stock2"  ></input><br></td>
	 <td><button type="subbmit" formmethod="get">purchase</button><br></td>
	</form>
	
	</tr>
	<?php
	$i++;
	}

	
	?>
</table>

</body>
</html>