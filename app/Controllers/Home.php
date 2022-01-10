<?php namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CommentModel;

class Home extends BaseController
{
	public function index()
	{
		$pm = new PostModel();
		$cm = new CommentModel();
		$b = $pm->builder();
		$bb = $cm->builder();
		//$b->truncate();
		
		$d["title"] = "Oscotech Online Community";
		$d["posts"] = $pm->orderBy("id", "desc")->paginate(20);
		$d["links"] = $pm->pager->links();
		
		return view('home', $d);
	}
	
	
	public function about()
	{
		return View("about", ["title" => "About Osco Camp"]);
	}
	
	
	public function g()
	{
		echo current_url(True);
	}
	
	
	public function h()
	{

		echo cwd();
	
	}

}