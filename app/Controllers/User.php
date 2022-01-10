<?php
namespace App\Controllers;


use App\Models\UserModel;
use App\Models\PostModel;

class User extends BaseController
{
	
	//show profile of cur_user
	public function me()
	{
		if(! $this->session->get("user")){
			return View("about", ["ref" => "/me", "title" => "About"]);
		}
		
		$um = new UserModel();
		$username = $this->session->get("user");

		$q = $um->find($username);
		
		//get user's topics
		$pm = new PostModel();
		$pm = $pm->builder();
		$user_name = $q->username;
		$user_posts = $pm->where(["post_by" => $user_name ])->findAll();
		
		$d["title"] = ucfirst($q->name);
		$d["usser"] = $q;
		$d["posts"] = $user_posts;
		
		return View("user", $d);
	}
	
	
	public function camp_user($user = null)
	{
		if($user == null){
			return View("error/html/error_404", ["message"=>"NoNo"]);
		}
		
		$um = new UserModel();
		$q = $um->find($user);
		
		//get user's topics
		$pm = new PostModel();
		$pm = $pm->builder();
		$user_name = $q->username;
		$user_posts = $pm->where(["post_by" => $user_name ])->findAll();
		
		$d["title"] = ucfirst($q->name);
		$d["usser"] = $q;
		$d["posts"] = $user_posts;
		
		return View("user", $d);
	}
	
	
	
	public function logout()
	{
		$this->session->remove("user");
		return redirect()->to("login");
	}
	
	
	//to show login form
	public function login_form()
	{
		//uri string of previous post
		$ref = $this->request->getGet("referral");
		$ref = base64_decode($ref);
		return View("login", ["title"=>"osco camp - Login", "ref" => $ref]);
	}
	
	
	
	public function login()
	{
		
		$ref = $this->request->getGet("referral");
		//check whether the referral begins with a forward slash /
		if(preg_match("/^\//", $ref)){
			//do nothing
		}else{
			//it does not start with /, append slash
			$ref = "/".$ref;
		}


		$a = [
			"username" => "required|alpha_dash",
			"password" => "required"
		];
		
		if($this->validate($a)){
		
			$uname = trim($this->request->getPost("username"));
			$pword = trim($this->request->getPost("password"));
			$db = db_connect();
			$build = $db->table("user");
			$w = ["username" => $uname, "password" => $pword];
			$q = $build->where($w);
			$n = $build->countAllResults();
			
			if($n == 1){
				//set session
				$this->session->set("user", $uname);
				
				if($this->request->getGet("referral")){
					return redirect()->to($ref);  //$ref is set above from get variable
				}else{
					return redirect()->to("/");
				}
				
			}else{
				//not found
				return View("login", ["title"=>"osco camp - Login", "er" => "<div class='alert alert-info'>The credentials you submitted do not match our records.</div>"]);
			}
			
			
		}else{
			$e = $this->validator->listErrors();
			return View("login", ["title"=>"osco camp - Login", "er" => $e]);
		}
		
	}
	
	
	
	public function signup()
	{
		
		if(! $this->request->getPost("signup")){
			return View("signup", ["title"=>"osco camp - Signup"]);
		}
		
		$a = [
			"name" =>[
				"label" => "name",
				"rules" => "required|alpha_numeric_space"
			],
			"username" =>[
				"label" => "username",
				"rules" => "required|alpha_dash|is_unique[user.username]",
				"errors" => [
					"is_unique" => "The username has been used."
				]
			],
			"password" =>[
				"label" => "password",
				"rules" => "required"
			],
			"email" =>[
				"label" => "email address",
				"rules" => "required|valid_email|is_unique[user.email]",
				"errors" => [
					"is_unique" => "The email has been used."
				]
			],
			"faculty" =>[
				"label" => "faculty",
				"rules" => "required"
			]
		];
		
		if($this->validate($a)){
			
			$i["name"] = trim($this->request->getPost("name"));
			$i["username"] = trim($this->request->getPost("username"));
			$i["email"] = trim($this->request->getPost("email"));
			$i["password"] = trim($this->request->getPost("password"));
			$i["faculty"] = $this->request->getPost("faculty");
			$i["reg_date"] = date("d-m-Y");
			$i["profile"] = "default.jpg";
			
			$u = new UserModel();
			if($u->register($i)){
				$this->session->set("user", $i["username"]);
				return redirect()->to("/");
			}else{
				die("An error occurred");
			}
			
			
		}else{
			$e = $this->validator->listErrors();
			return View("signup", ["title"=>"osco camp - Signup", "er" => $e]);
		}
	
	}
	
	
	
	//to truncate table
	public function trunc()
	{
		if(! $this->request->getGet("yes")){
			echo "<a href='/user/trunc?yes=yes'>Truncate? </a>";
		}else{
			$um = new UserModel();
			$um->truncate();
			echo "<h1>done</h1>";
		}
		
	}	
	
	
	
}