<?php
namespace App\Models;

use CodeIgniter\Model;

class FollowPostModel extends Model {

	protected $table = "following_post";
	protected $returnType = "object";
	protected $primaryKey = "post_id";
	protected $allowedFields = ["post_id", "username", "message"];
	
	
	//called from Post controller, when user create a post and also from comment controller when user leave comments
	public function addNoty($i)
	{
		$user = $i["username"];
		$post_id = $i["post_id"];
		
		//check whether user record is in following_post table
		$w = ["post_id" => $post_id, "username"=>$user ];
		$b = $this->builder();
		$b->where($w);
		$num = $b->countAllResults();
		
		//if the number of returned is not equal to 1
		if($num == 0){
			//user record is not there, then insert
			$this->insert($i);
		}
		
	}
	
	
	//usually called from comment controller, when user comments on a post
	//used to set other user users message column to yes
	public function setMessageToYes($username, $post_id)
	{
		$this->where(["username !=" => $username, "post_id" => $post_id])->set(["message" => "yes"])->update();
	}
	
	
	
	
	/* 
		user just clicked on a post from notification page
		to set user message column to no
		usually called from Camp_post method in Post controller
	*/
	public function setMessageToNo($username, $post_id)
	{
		$w = ["username" => $username, "post_id" => $post_id];
		$this->where($w)->set(["message"=> "no"])->update();
	}
	
	
	
	//get user notifications
	//called from Notifications controller
	public function getMyNotifications($username)
	{
		$gg = $this->where(["username" => $username, "message" => "yes"])
			 ->findAll();
		return $gg;
	}
	
	
	public function deletePostFollowers($post_id)
	{
		$this->delete($post_id);
	} 
	
	
}

?>