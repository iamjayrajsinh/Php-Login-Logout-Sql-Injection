<?php
	// include 'config.php';
	// session start
	session_start();
	// unset all sessions
  session_unset();
  // destroy all sessions
  session_destroy();
  // redirect to login
  header("location: index.php");

?>