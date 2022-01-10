<!DOCTYPE html>
<html>
<head>
<title> <?php if(isset($title)) echo $title; ?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" >
<link rel="stylesheet" href="/inc/bootstrap44.min.css "  >
<link rel="stylesheet" href="/inc/ionicons/css/ionicons.min.css"  >
<?= $this->renderSection("css")?>
<style type="text/css">

/* icon 4 navigation*/
.menu-nav a{
	display:inline-block;
	font-size:20px;
	text-decoration:none;
}

[drk]{
	background:rgb(0,0,0,.7);
}

#c{
	color:white;
}



/* for loader*/
.l{
	position:fixed;
	background:rgb(0,0,0,.7);
	top:0px;
	left:0px;
	z-index:99999;
	height:100%;
	width:100%;
	display:flex;
	justify-content:center;
	align-items:center;
}

/* tag for notifications*/
sup{
	color:red;
	font-weight:bold;
}

/* a tag for profile*/
a[pr]{
	text-decoration:underline;
}

@media screen and (min-width:500px){
	.mm{
		width: 70%;
	}
}
</style>
</head>
<body class="py-5 bg-dark"  >

<!-- spinner when loading  -->
<div id="l" class="l">
	<div class="spinner-border text-primary">   </div>
</div>

<?php
	if(isset($_SESSION["user"]))
	{
		$cur_user = $_SESSION["user"];
		$db_conn = db_connect();
		//select table
		$db_bui = $db_conn->table("following_post");
		
		$ww = $db_bui->where(["username" => $cur_user, "message" => "yes"]);
		//get number of comments
		$nu = $db_bui->countAllResults();
		if($nu == 0)
		{
			$number_of_notifications = "";
		}
		else{
			$number_of_notifications = $nu;
		}
	}	
	else{
		$number_of_notifications = "";
	}
?>
	
	<div class="container-fluid ">
		<div class="row">
			<nav class="bg-dark shadow fixed-top navbar navbar-expand-lg col-12 col-lg-8 offset-lg-2" >
				
				<a href="http://osco-camp.epizy.com" class="font-weight-bold text-warning navbar-brand">OSCO CÂMP</a>
				
				<div class="dropleft d-lg-none position-relative">
					<a href="#dr" class="hv"  data-target="#dr" data-toggle="dropdown" ><span style="font-size:20px" class="ion-md-more" ></span></a>
					<div class=" dropdown-menu" id="dr" >
						<?php if(isset($_SESSION["user"])): ?>	
							<a href="" go class="dropdown-item" >Refresh</a>
							<a href="/about" go class="dropdown-item" >About</a>
							<a href="/logout" go class="dropdown-item">Log out</a>
						<?php else: ?>
							<a href="" go class="dropdown-item" >Refresh</a>
							<a href="/about" go class="dropdown-item" >About</a>
							<a href="/login?referral=<?=base64_encode(uri_string())?>" go class="dropdown-item">Log in</a>
						<?php endif; ?>
					</div>
				</div>
				
				<div class=" justify-content-end collapse navbar-collapse">
					<!-- desktop nav-->
					<div class="menu-nav d-flex w-50 justify-content-around">
						<a icon="home" go href="/" >  <span class="ion-ios-home" ></span>  </a>
						<a icon="add" go href="/add" > <span class="ion-ios-add-circle" ></span>  </a>
						<a icon="noty" go href="/notifications" >  <span class="ion-ios-notifications" > </span> <sup><?=$number_of_notifications?></sup> </a>
						<a icon="user" go href="/me" > <span class="ion-ios-person" ></span> </a>
					</div>
					<?php if(isset($_SESSION["user"])): ?>
					<a href="/logout" go class="">log out</a>
					<?php else: ?>
					<a href="/login?referral=<?=base64_encode(uri_string())?>" go class="">log in</a>
					<?php endif; ?>
				</div>
				
			</nav>
		</div>
	</div>
	


	<div class="container-fluid" >
		<div class="row">
			<div   style="overflow-y:scroll;"  class=" py-3 col-12 col-lg-8 offset-lg-2" >
				<div class="mm">
					<?= $this->renderSection("body")?>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<div  class="bg-dark menu-nav bg-ark d-flex d-lg-none py-2 justify-content-around fixed-bottom">
		<a icon="home" go href="/" > <span class="ion-ios-home" ></span> </a>
		<a icon="add" go href="/add" ><span class="ion-ios-add-circle" ></span></a>
		<a icon="bell" go href="/notifications" ><span class="ion-ios-notifications" ></span> <sup><?=$number_of_notifications?></sup> </a>
		<a icon="user" go href="/me" > <span class="ion ion-ios-person" ></span> </a>
	</div>
	
	

<script type="text/javascript" src="/inc/jquery-3.min.js"></script>
<script type="text/javascript" src="/inc/popper.js"></script>
<script type="text/javascript" src="/inc/bootstrap44.min.js"></script>
<script type="text/javascript">
	$(window).on("load", function(){
		$(".l").fadeOut()
	})
	
	$("a[go]").click(function(){
		var f = this.href
			$(".l").fadeIn()
	}) 
	
	$("form").submit(function(){
		$(".l").fadeIn()
	}) 
	
</script>
<?= $this->renderSection("js")?>
</body>
</html>