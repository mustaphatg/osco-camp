<?php
namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\FollowPostModel;

class Comment extends BaseController
{

	public function add_comment($from = null)
	{
		if(! $this->request->getPost("comment_body")){
			return "no";
		}
		
		$i["comment_by"] = $this->session->get("user");
		$i["comment_body"] = $this->request->getPost("comment_body");
		$i["time_stamp"] = strtotime("now");
		$i["post_id"] = $this->request->getPost("post_id");
		
		$cm = new CommentModel();
		if($cm->addComment($i)){
			
			$fpm = new FollowPostModel();
			
			//comment has been added,  
			//update other users who are following post message column to yes
			//update message to yes where username != $user and post_id = $post_id
			$fpm->setMessageToYes($this->session->get("user"), $this->request->getPost("post_id"));
			
			//next is to insert the user username and post_id into following_post table
			$ii["username"] = $this->session->get("user");
			$ii["post_id"] = $this->request->getPost("post_id");
			$ii["message"] = "no";
			//insert
			$fpm->addNoty($ii);
			
			//if request is from camp-post i.e not ajax
			//redirect to post
			if($from == "camp"){
				return redirect()->to(base_url()."/camp-post/".$this->request->getPost("post_id"));
			}
			
			//request is from ajax
			return "ok";
			
		}else{
			return "no";
		}
		
	}
	

	
}