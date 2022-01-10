<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {

	protected $table = "user";
	protected $returnType = "object";
	protected $allowedFields = ["name", "username", "email", "password","department", "faculty", "reg_date", "profile"];
	protected $primaryKey = "username";
	
	
	public function register($v)
	{
		if($this->insert($v)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	

}

?>