<?php
namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model {

	protected $table = "post";
	protected $returnType = "object";
	protected $primaryKey = "id";
	protected $allowedFields = ["post_by", "post_body", "image", "time_stamp","love", "settings"];
	
	
	
	public function addPost($ii)
	{
		if($this->insert($ii)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	public function getSinglePost($id)
	{
		$g = $this->find($id);
		return $g;
	}
	
	
	//check whether post exist
	public function postExist($id)
	{
		if($this->find($id)) return TRUE;
		else return FALSE;
	}
	
	
	public function deletePost($id)
	{
		$q = $this->find($id);
		$image = $q->image;
		unset($q);
		
		if(! empty($image)){
			unlink("writable/uploads/post-image/".$image);
		}
		
		$this->delete($id);
	}
	

}

?>