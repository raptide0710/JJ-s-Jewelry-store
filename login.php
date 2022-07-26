<html>

<body>
<?php
//session is started
session_start();
//fucntion is defined
function users_login(){

//the variables are defined
if (isset($_POST['usid']) and isset($_POST['passw'])and isset($_POST['id'])){
$uid = $_POST['id'];
$email = $_POST['usid'];
$password = $_POST['passw'];

//a connection is made to the database using the connect.php file 
 require_once('connect.php');
// error message is displayed if user has not filled a field
$chkuid = substr($_POST['id'],0,1);
$chkemail = substr($_POST['usid'],0,1);
$chkpwd = substr($_POST['passw'], 0,1);
if ($chkuid == '')
{
 echo "<font color='red'><b>No user_id entered, please try again</b></font><br><br>";
}
elseif ($chkemail == '')
{
 echo "<font color='red'><b>No email entered, please try again</b></font><br><br>";
}
elseif ($chkpwd == '')
{
 echo "<font color='red'><b>No password entered, please try again</b></font><br><br>";
}
else 
{ 
//the password is decrypted so it can be checked with the password that is input in the login screen
 $encrypted_value = md5($password);
 
 //the sql statment is placed in a vairable
 //the u_login table is selected to the details entered in the login screen are checked with the database 
 $query = "select * from u_login
 where email ='$email'
 and p_word='$encrypted_value' 
 and users_id ='$uid'";
 
 //the sql statment is connected to the database to collect the information and placed in a vairable 
 $result = $db->query($query);
 if (PEAR::isError($result)){
 die($result->getMessage(). $result->getUserInfo());
}
// if the login screen details do not match the database the following error message is displayed 
if ($result == false)
{

	echo "User not recognized, please try again"; exit;
}
//if the details mathch the user is redirected to the admin page or the user page depending on the details they used to login with 
else
{	
	$success=0;
	while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)){
	$ud = $row['users_id'];
	$usd = $row['email'];
	$psd = $row['p_word'];


	$success=1;
	echo "user verified... redirecting<br>";
	}
	if ($success==1){
		if ($ud == '1')
		{
			header( 'refresh:0, url = admin.php' ) ;
			$_SESSION['email'] = $email;
			$_SESSION['p_word'] = $password;
			
		echo "Admin";
		}
		elseif ($ud >= '2')
		{
			header( "refresh:0, url = users.php") ;
			$_SESSION['email'] = $email;
			$_SESSION['p_word'] = $password;
		echo "Customer";
		}
	
	}
	else {echo "<font color='red'><b>User not verified, please try again.</b></font><br><br>";}
} 
}
}
}
?>

<p>|<a href="home.html">Home</a> | <a href="	pr.php">buy jewellery</a> | <a href="	login.php">log in</a> or register to buy <a href="reg.php"> register</a> </p>

<form name="login" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
<?php users_login(); ?>
Enter your id <input type="number" name="id"  ></input><br><br>
Enter your email <input type="email" name="usid" ></input><br><br>
Enter your password <input type="password" name="passw" pattern=".{8,}" title="Eight or more characters" ></input><br><br>
<input type="submit" name="submit1" value="log in"></input>
</form>
<h4><left>New customer? </left><a href="reg.php" style="color:blue">Register now</a></h4>
 <form action="home.html">
<input type="submit" name="submit2" value="Back"></input>
</form>

</body>
</html>