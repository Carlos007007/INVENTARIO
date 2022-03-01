<?php
	session_destroy();
	
	if(headers_sent()){
		echo "<script> window.location.href='index.php?vista=login'; </script>";
	}else{
		header("Location: index.php?vista=login");
	}