<?php
// session is started
session_start();
//session is ended 
session_destroy();
// logout message displayed
echo 'You have been logged out. go to the<a href="home.html"> home page</a>';
echo 'or <a href="login.php"> login</a>';
?>