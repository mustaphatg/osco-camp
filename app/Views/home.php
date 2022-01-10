<?php $this->extend("layout_main")?>

<?= $this->section("css")?>
<style type="text/css">
	a[icon=home]{
		color:yellow;
	}
	
	/* hover on icon like, comment, menu*/
	.hv{
		padding:7px;
		border-radius:5px;
	}
	.hv:hover {
		background:rgb(0,0,0,0.5);
	}
	
	.over{
		display:none;
		visibility:hidden;
		height:0px;
		width:0px;
	}
	
	.sending{
		display:block;
		visibility:visible;
		background:rgb(0,0,0,.7);
		width:100%;
		padding:5px;
		height:100%;
		justify-content:center;
		align-items:center;
		position:absolute;
		top:0px;
		left:0px;
	}
	
	.br{
		word-break:break-word;
	}

</style>
<?= $this->endSection()?>


<!-- body -->
<?= $this->section("body")?>

	<?php 
		$d = db_connect();
		$builder = $d->table("comment");
	 ?>
	 
	<?php foreach($posts as $post): ?>
		<?php
			$s = explode(",", $post->settings);
			$bg = $s[0]; //the first is background
			$cl = $s[1]; //the second is color
			$date = date("D, M d ", $post->time_stamp);
		?>
		<!-- post -->
		<div style="border:1px dashed <?=$cl?>" id="post-<?=$post->id?>" class="position-relative p-1 rounded" >
			
			<p class="shadow p-1 d-flex justify-content-between">
				<a style="color:#fff" href="/camp-user/<?=$post->post_by?>" go="" pr="" class="badge badge-info text-capitalize" >	<?=$post->post_by?> </a>
				<span class="badge badge-info" ><?=$date?></span>
			</p> <!--  end of info part -->
			
			
			<?php
				$builder->where("post_id", $post->id);
				$num_comment = $builder->countAllResults();
				$builder->resetQuery();
				
				$builder->where("post_id", $post->id);
				$comments = $builder->orderBy("id", "asc")->get(5)->getResultArray();
			?>
			
			<!-- body part  -->
			<p  style="color:<?=$cl?>" >
				
				<!-- post body text-->
				<span style="background:<?=$bg?>" class="br d-block text-capitalize ">
					<?=nl2br($post->post_body)?>
					<?php if($post->image) : ?>
						<img class="img-fluid rounded" src="/writable/uploads/post-image/<?=$post->image?>">
					<?php endif; ?>
				</span>
				
				<!-- love & comment buttom -->
				<span class="d-block d-flex p-1 justify-content-around">
					<!-- heart  -->
					<span id="lv-<?=$post->id?>" onclick="likePost('<?=$post->id?>')" class="hv">
						<i style="color:<?=$cl?>" class="ion-md-thumbs-up" ></i>
						<i id="num_love-<?=$post->id?>"><?=$post->love?></i>
					</span>
					
					<!-- text icon encloser -->
					<span class="hv" data-target="#post-com<?=$post->id?>" data-toggle="collapse" >
					<!-- text icon  -->
						<i style="color:<?=$cl?>" class="ion-ios-text" ></i> <i id="num_com-<?=$post->id?>" ><?=$num_comment?></i>
						
						<!-- collapse -->
						<div id="post-com<?=$post->id?>" class="collapse">
							<span class="d-block" style="color:<?=$cl?>" >comments:</span>
							<!-- list of comments -->
							<ul class="list-group" id="commentlist-<?=$post->id?>" >
							<?php
								foreach($comments as $comment){
									$comment_body = nl2br($comment["comment_body"]);
									
									echo <<< END
										<li class="list-group-item" style="background:#f5f5f5">
											<a pr="" go="" href="/camp-user/{$comment['comment_by']}" class="d-block text-capitalize" >{$comment["comment_by"]}</a>
											<span class=""  style="color:black">$comment_body</span>
										</li>
									END;
								}
								
								if($num_comment > 5){
									echo "<a go='' href='/camp-post/{$post->id}' class='d-block text-center ' >view all comments</a>";
								}
								
							?>
							</ul>
							
							<!-- textarea fir comment -->
							<?php if(isset($_SESSION["user"])): ?>
							
							<br>
							<div class="d-flex flex-column">
								<textarea style="height:70px" class="w-100 form-control" placeholder="write a comment..." id="textarea-<?=$post->id?>" ></textarea>
								<span class="d-flex d-block justify-content-end">
									<button onclick="sendComment('<?=$post->id?>')" class="w-50 btn btn-sm btn-info" >
										<span class="d-block">SEND <i class="ion-ios-paper-plane" ></i></span>
									</button>
								</span>
							</div>		
							<?php else: ?>
								<u><a href="/login?referral=<?=base64_encode(uri_string()."#post-".$post->id)?>" go style="color:<?=$cl?>" >Login to comment</a></u>
							<?php endif; ?>
							<!-- end textarea for comment -->
							
						</div> <!-- end collapse  -->
						
					</span> <!-- end of text icon encloser -->
					
				</span> <!-- end of love & comment button -->
			</p> <!-- end of body part -->
			
			<!-- post overlay -->
			<div id="overlay-<?=$post->id?>" class="over d-flex">
				<span class="spinner-border spinner-border-sm  text-info"></span>
			</div>
				
		</div><br><!-- end of post  -->
	
	<?php endforeach; ?>
	
	
	<br>
	<div  class="">
		<?=$links?>
	</div>
	

<?= $this->endSection()?>





<?= $this->section("js")?>
<script type="text/javascript">

	

	function sendComment(id){
		var post_id = $("#post-"+id)
		var post_overlay = $("#overlay-"+id)
		var text_area = $("#textarea-"+id)[0]
		var com_list = $("#commentlist-"+id)
		
		if(text_area.value == ""){
			return;
		}
		//get value
		var tx = text_area.value
		text_area.value = "" // remove value
		
		//add to comments list
		var m = "<li class=' list-group-item ' style='background:#f5f5f5' >"+ tx +"</li>"
		com_list.append(m)
		
		//show loading signal
		post_overlay.addClass("sending")
		
		$.post("/add-comment/not", {comment_body: tx, post_id: id}, function(er){
			if(er == "no"){
				alert("couldn't submit your comment")
			}else{
				//increment value
				var num_com = $("#num_com-"+id)
				var nnc = parseInt(num_com.text()) + 1
				num_com.text(nnc)
			}
		})
		.fail(function(){
			alert("An Error Occurred")
		})
		.always(function(){
			post_overlay.removeClass("sending")
		})

	}
	
	
	function likePost(id){
		var post_overlay = $("#overlay-"+id)
		var lv = document.querySelector("#lv-"+id)
		
		if(lv.hasAttribute("yes")){
			alert("Cant Like twice")
			return
		}
		
		//show loading signal
		post_overlay.addClass("sending")
		
		$.post("/like-post", {post_id: id}, function(er){
			if(er == "no"){
				alert("couldn't submit your comment")
			}else{
				var num_lov = $("#num_love-"+id)
				var nnc = parseInt(num_lov.text()) + 1
				num_lov.text(nnc)
				lv.setAttribute("yes", "g")
			}
		})
		.fail(function(){
			alert("An Error Occurred")
		})
		.always(function(){
			post_overlay.removeClass("sending")
		})
		
	}
	
	
</script>
<?= $this->endSection()?>


