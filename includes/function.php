<?php
	function Redirect_to($NewLocation){
		header("Location:".$NewLocation);
		exit();
	}
?>