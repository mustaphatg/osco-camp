<?php
namespace App\Controllers;

use App\Models\FollowPostModel;
use App\Models\PostModel;

class Notifications extends BaseController
{


	public function index()
	{
		$fpm = new FollowPostModel();
		$pm = new PostModel();
		
		
		//array to enclose all post that user should be notified of
		$mynotys = [];
		
		$notys = $fpm->getMyNotifications($this->session->get("user"));
		foreach($notys as $noty){
			$id = $noty->post_id;
			
			//get single post from postModel, param : id
			$mynotys[] = $pm->getSinglePost($id);
		}
		
		$d["title"] = "My Notifications";
		$d["mynotys"] = $mynotys;
		
		return View("notifications", $d);
	}

	
}