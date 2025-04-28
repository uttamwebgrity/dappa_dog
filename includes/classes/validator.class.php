<?php
class Validator{



	public function validate_email($email_id){
		if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email_id)){	
			return true;
		}else{
			return false;
		}	
	}
} 
?>