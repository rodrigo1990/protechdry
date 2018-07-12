<?php 
class Session{

	public function __construct(){

	}

	public function controlarTiempoDeSesion(){

		if (!isset($_SESSION['timeout'])){
			$_SESSION['timeout'] = time();
		}
		else if (time() - $_SESSION['timeout'] > 18000){
			session_destroy();
			header("Location: index.php");
		}

	}//function
}//class


 ?>