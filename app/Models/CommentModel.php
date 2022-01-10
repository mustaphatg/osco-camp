<?php
namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model {

	protected $table = "comment";
	protected $returnType = "object";
	protected $primaryKey = "post_id";
	protected $allowedFields = ["comment_by", "comment_body", "post_id", "time_stamp"];
	
	
	public function addComment($i)
	{
		if($this->insert($i)){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	
	/* 
	usually called from camp_post method in Post controller
	*/
	public function getPostComments($post_id)
	{
		$gg = $this->where("post_id", $post_id)->orderBy("id", "asc")->findAll();
		return $gg;
	}
	
	
	public function deleteComments($post_id)
	{
		$this->delete($post_id);
	} 
	
	
}

?>