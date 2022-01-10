<?php
namespace App\Controllers;

use App\Models\PostModel;
use App\Models\FollowPostModel;
use App\Models\CommentModel;


class Post extends BaseController
{
	
	//show create form
	public function add()
	{
		
		if(! $this->session->get("user")){
			$ref = "/add";
			return view("login", ["ref" =>$ref, "title"=>"osco camp - Login"]);
		}
		
		if(! $this->request->getPost("add")){
			return view("add-post", ["title"=>"osco camp - Add Post"]);
		}
		
		//image reference 
		$img = $this->request->getFile("image");
		
		$p = $this->request->getPost("post_body");
		$i = $img->getName();
		
		//if post is empty and no image is available
		if(!$p && !$i){
			return view("add-post", ["title"=>"osco camp - Add Post", "er" => "<div class='alert alert-danger'>You have to write some text or upload a photo.</div>"]);
		}
		
		//if there image to upload
		//if there z a valid name else null
		if($i){
			//image name
			$fn = strtotime("now").".jpg";
		}else{
			$fn = null;
		}
		
		$ii["post_by"] = $this->session->get("user");
		$ii["post_body"] = $this->request->getPost("post_body");
		$ii["image"] = $fn;
		$ii["time_stamp"] = strtotime("now");
		$ii["love"] = 0;
		$ii["settings"] = $this->request->getPost("background").",".$this->request->getPost("color");
		
		$pm = new PostModel();
		
		if($pm->addPost($ii)){
		
			if($i){
				//store image
				$img->store("post-image/", $fn);
			}
			

			//get last insert id by calling method of PostModel
			$bui = $pm->builder();
			$last_id = $bui->insertID();
			
			//insert into following_post tables for notification
			$fpm = new FollowPostModel();
			
			$iii["post_id"] = $last_id;
			$iii["username"] = $this->session->get("user");
			$iii["message"] = "no";
			$fpm->addNoty($iii);
			
			//redirect to home
			return redirect()->to("/");
			
		}else{
			die("An Error Occurred, Try Again");
		}
	
		
	}
	
	
	public function like_post()
	{
		$p_id = $this->request->getPost("post_id");
		
		if(!$p_id){
			return "no";
		}
		
		$pm = new PostModel();
		$pm_builder = $pm->builder();
		
		if($pm_builder->increment("love")){
			return "yes";
		}else{
			return "no";
		}
		
	}
	
	
	//for single post
	public function camp_post($id)
	{
		/* 
			if user is logged in
			update [message] Column in following_post table to yes
			where username is $_SESSION["user"] and post_id is $id
		*/
		if($this->session->get("user"))
		{
			$fpm = New FollowPostModel();
			$fpm->setMessageToNo($this->session->get("user"), $id);
		}
		
		$pm = new PostModel();
		
		//check whether post exist
		if(! $pm->postExist($id)){
			return View("errors/html/error_404.php");
		}
		
		//set data,  single post
		$d["title"] = "Osco Camp Post";
		$d["post"] = $pm->getSinglePost($id);
		
		//get all comments under this post 
		$cm = new CommentModel();
		$comments = $cm->getPostComments($id);
		
		//set data,  comments
		$d["comments"] = $comments;
		
		return View("camp-post", $d);
		
	}
	

	public function delete_post($id)
	{
		$pm = new PostModel();
		
		//check whether post exist
		if(! $pm->postExist($id)){
			return View("errors/html/error_404.php");
		}
		
		//delete post in postmodel
		$pm->deletePost($id);
		
		//delete Post in CommentModel
		$cm = new CommentModel();
		$cm->deleteComments($id);
		
		//delete following_post
		$fpm = new FollowPostModel();
		$fpm->deletePostFollowers($id);
		
		return redirect()->to("/me");
	}
	
	
	//to truncate table
	public function trunc()
	{
		if(! $this->request->getGet("yes")){
			echo "<a href='/post/trunc?yes=yes'>Truncate? </a>";
		}else{
			$pm = new PostModel();
			$cm = new CommentModel();
			$fpm = new FollowPostModel();
			
			$fpm->truncate();
			$cm->truncate();
			$pm->truncate();
			echo "<h1>done</h1>";
		}
		
	}	
	
	
	
}