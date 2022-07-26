<html lang="en">
<head>
  <title>User Registration</title>
</head>
<body>

<p>|<a href="home.html">Home</a> | <a href="	pr.php">buy jewellery</a> | <a href="	login.php">log in</a> or register to buy <a href="reg.php"> register</a> </p>
<h1>register </h1>
<p> * = required field </p>
<form action="reg.php" method="post">
<h2>details</h2>
<tr><td>
    <p>
        <label for="fname">* first name:</label></td>
        <td><input type="text" name="fname" id="fname" autocomplete="off" required></td>
    </p>
    </tr>
    <tr><td>
    <p>
        <label for="lname">* last name:</label></td>
       <td> <input type="text" name="lname" id="lname" autocomplete="off" required></td>
    </p></tr>
    <tr><td>
    <p>
        <label for="dob">* date of birth:</label></td>
        <td><input type="date" name="dob" id="dob" autocomplete="off" required></td>
    </p></tr>
    <tr><td>
    <p>
        <label for="address">* address:</label></td>
        <td><input type="text" name="address" id="address" autocomplete="off" required></td>
    </p></tr>
    <tr><td>
    <p>
        <label for="tel_num1">* telephone number 1:</label></td>
        <td><input type="text" name="tel_num1" id="tel_num1" autocomplete="off" pattern=".{10}" title="phone number must be ten characters long" required></td>
    </p></tr>
    <tr><td>
    <p>
        <label for="tel_num2">telephone number 2:</label></td>
        <td><input type="text" name="tel_num2" id="tel_num2" autocomplete="off" pattern=".{10}" title="phone number must be ten characters long" ></td>
    </p></tr>
	<h2>login details</h2>
	<tr><td>
    <p>
        <label for="email">* email:</label></td>
        <td><input type="email" name="email" id="email" autocomplete="off" required></td>
    </p></tr>
	<tr><td>
    <p>
        <label for="p_word">* password:</label></td>
        <td><input type="password" name="p_word" id="p_word" autocomplete="off" pattern=".{8,}" title="Eight or more characters" required></td>
    </p></tr>
	<h2>banking details</h2>
	<tr><td>
    <p>
        <label for="sort_code">* sort code :</label></td>
        <td><input type="text" name="sort_code" id="sort_code" autocomplete="off" pattern=".{6}" title="enter a sort code of six characters" required></td>
    </p></tr>
	<tr><td>
    <p>
        <label for="bank_name">* bank name:</label></td>
        <td><input type="text" name="bank_name" id="bank_name" autocomplete="off" required></td>
    </p></tr>
	<tr><td>
    <p>
        <label for="baddress">* address:</label></td>
        <td><input type="text" name="baddress" id="baddress" autocomplete="off" required></td>
    </p></tr>
	<tr><td>
    <p>
        <label for="account_number">* account number:</label></td>
        <td><input type="text" name="account_number" id="account_number" autocomplete="off" pattern=".{10,12}" title="enter an accout number whith 10 to 12 characters" required></td>
    </p></tr>
	<tr><td>
    <p>
        <label for="bfname">* first name:</label></td>
        <td><input type="text" name="bfname" id="bfname" autocomplete="off" required></td>
    </p></tr>
	<tr><td>
    <p>
        <label for="blname">* last name:</label></td>
        <td><input type="text" name="blname" id="blname" autocomplete="off" required></td>
    </p></tr>
    <tr><td><input type="submit" name="submit" value="register" ></td>
</form>
<?php

//the submit button will use the post method to sednd the data 
if(isset($_POST['submit'])){
//a connection is made to the database using the connect.php file 
require_once('connect.php');

//the sql statment is placed in a vairable
// data is inserted into the users table from input fields
	$q1 = "INSERT INTO users (fname, lname, dob,admin_status) VALUES ('$_POST[fname]','$_POST[lname]','$_POST[dob]','n')";
	//the sql statment is executed
	$res1 = $db->query($q1);
	
		// this is used to update the foreign key of users_id
	 $uid =0;	
	 $max = "SELECT MAX(users_id) AS max_id FROM users";
		//the sql statment is executed
        $ures = $db->query($max);
                while($row = $ures->fetchRow(MDB2_FETCHMODE_ASSOC)){
                $uid=$row['max_id'];
                   //echo " the usrs id is:" ,$uid;
                }
		//$uid + 1;
	//the sql statment is placed in a vairable
	// data is inserted into the users table from input fields
	$q2 = "INSERT INTO u_address (address,users_id ) VALUES ('$_POST[address]','$uid')";
	//the sql statment is executed
	$res2 = $db->query($q2);
	
	//the sql statment is placed in a vairable
	// data is inserted into the users table from input fields
	$q3 = "INSERT INTO telephone (tel_num1, tel_num2,users_id) VALUES ('$_POST[tel_num1]','$_POST[tel_num2]','$uid')";
	//the sql statment is executed
	$res3 = $db->query($q3);
	
	$password = md5($_POST['p_word']);
	//the sql statment is placed in a vairable
	// data is inserted into the users table from input fields
	$q4 = "INSERT INTO u_login (email,p_word,users_id) VALUES ('$_POST[email]','$password','$uid')";
	//the sql statment is executed
	$res4 = $db->query($q4);

	
	//the sql statment is placed in a vairable
	// data is inserted into the users table from input fields
	$q5 = "INSERT INTO bank (sort_code, bank_name) VALUES ('$_POST[sort_code]','$_POST[bank_name]')";
	//the sql statment is executed
	$res5 = $db->query($q5);
	
	// this is used to update the foreign key of bank_id
	$bid =0;
        $max1 = "SELECT MAX(bank_id) AS max_id FROM bank";
		//the sql statment is executed
        $bres = $db->query($max1);
                while($row = $bres->fetchRow(MDB2_FETCHMODE_ASSOC)){
                $bid=$row['max_id'];
                  //echo " ",$bid;
                }
	
	//the sql statment is placed in a vairable
	// data is inserted into the users table from input fields
	$q6 = "INSERT INTO banking_user_add (baddress) VALUES ('$_POST[baddress]')";
	//the sql statment is executed
	$res6 = $db->query($q6);
	
	// this is used to update the foreign key of bank_user_add_id
	
	$ba =0;
        $max2 = "SELECT MAX(bank_user_add_id) AS max_id FROM banking_user_add";
		//the sql statment is executed
        $ares = $db->query($max2);
                while($row = $ares->fetchRow(MDB2_FETCHMODE_ASSOC)){
                $ba=$row['max_id'];
                  //echo " ",$ba;
                }
	//the sql statment is placed in a vairable
	// data is inserted into the users table from input fields
	$q7 = "INSERT INTO users_banking_details (account_number, bfname, blname,users_id,bank_user_add_id,bank_id) VALUES ('$_POST[account_number]','$_POST[bfname]','$_POST[blname]','$uid','$ba','$bid')";
	//the sql statment is executed
	$res7 = $db->query($q7);
	
	// the sql statments are checked for errors 
 if (PEAR::isError($res1)){
                die ($res1->getMessage(). $res1->getUserInfo());
            }
        if($res1&&$res2&&$res3&&$res4&&$res5&&$res6&&$res7&&$ures&&$bres&&$ares)
        {
		
				echo "<br>YOUR REGISTRATION IS COMPLETED...";
				echo "user created... redirecting to login";
				header( 'refresh:5, url = login.php' ) ;

			
			
			
			}
        $res1->free();
$db->disconnect();
}
?>


</body>
</html>