<?php $this->extend("layout_main")?>

<?= $this->section("css")?>
<style type="text/css">
	a[icon=bell]{
		color:yellow;
	}
</style>
<?= $this->endSection()?>

<?= $this->section("body")?>


	<?php
		//first is background
		$set = explode(",", $post->settings);
		$bg = $set[0];
		$cl = $set[1];
		$time = $post->time_stamp;
		$date = date("D, M d Y", $time);
	?>
	
	<!-- post  -->
	<div class="rounded post p-1" style="border: 1px dashed<?=$cl?>" >
		
		<span  class="shadow p-2 d-block d-flex justify-content-between" >
			<a href="/camp-user/<?=$post->post_by?>" pr="" go class="badge badge-info text-capitalize" ><?=$post->post_by?></a>
			<span class="badge badge-info" ><?=$date?></span>
		</span><br>
		
		<span class="p-2 text-white " >
			<?=nl2br($post->post_body)?>
			<?php if($post->image) : ?>
				<img class="img-fluid rounded" src="/writable/uploads/post-image/<?=$post->image?>">
			<?php endif; ?>
		</span>
		
	</div><br>
	
	
	<!-- loop comments -->
	<?php foreach($comments as $comment) : ?>
		
		<?php
			$time = $comment->time_stamp;
			$date = date("D, M d Y", $time);
		?>
		
		<div class="my-1 rounded post p-1" style="border: 1px dashed<?=$cl?>">
			
			<span class="shadow p-2 d-block d-flex justify-content-between" >
				<a href="/camp-user/<?=$comment->comment_by?>" pr="" go class="badge badge-info text-capitalize" ><?=$comment->comment_by?></a>
				<span class="badge badge-info" ><?=$date?></span>
			</span><br>
			
			<span class="my-2 p-2 text-white " >
				<?=nl2br($comment->comment_body)?>
			</span>
			
		</div><br>
		
	<?php endforeach;  ?>
	
	
	<?php if(isset($_SESSION["user"])): ?>
		<form method="post" action="<?=base_url()?>/add-comment/camp" >
			<div class="d-flex flex-column">
				
				<input type="hidden" name="post_id" value="<?=$post->id?>"   >
				<textarea required="required" name="comment_body" class="form-control w-100" style="height:70px" placeholder="write a comment..."  ></textarea>
				
				<span class="d-block d-flex justify-content-end" >
					<button class="btn btn-primary">
						SEND <span class="ion-ios-paper-plane" ></span>
					</button>
				</span>
				
			</div>
		</form>
	<?php else: ?>
		<a href="/login?referral=<?=base64_encode(uri_string())?>" class="d-block text-center">Login to comment</a>
	<?php endif; ?>


<?= $this->endSection()?>