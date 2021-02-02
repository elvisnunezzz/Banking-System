<?php

	if (isset($_COOKIE['customer_id'])) {
	    unset($_COOKIE['customer_id']); 
	    setcookie('customer_id', '', 1);
	}

	if (isset($_COOKIE['customer_name'])) {
	    unset($_COOKIE['customer_name']); 
	    setcookie('customer_name', '', 1);
	}

	echo "You successfully logout <br><br>";
	echo '<a href="index.html">project home page</a>';