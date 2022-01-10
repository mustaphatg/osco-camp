<?php $this->extend("layout_main")?>

<?= $this->section("css")?>
<style type="text/css">
	a[icon=user]{
		color:yellow;
	}
</style>
<?= $this->endSection()?>



<?= $this->section("body")?>


<ul class="list-group">

	<li class="list-group-item text-center">
		<img height="150" width="150" class="border rounded-circle img-fluid" src="/writable/uploads/user-image/<?=$usser->profile?>" >
	</li>
	<li class="list-group-item">
		<span class="badge badge-info">Name : </span>
		<?=ucfirst($usser->name)?>
	</li>
	<li class="list-group-item">
		<span class="badge badge-info">Username : </span>
		<?=ucfirst($usser->username)?>
	</li>
	<li class="list-group-item">
		<span class="badge badge-info">Department : </span>
		<?=ucfirst($usser->department)?>
	</li>
	<li class="list-group-item">
		<span class="badge badge-info">Faculty : </span>
		<?=ucfirst($usser->faculty)?>
	</li>
	<li class="list-group-item">
		<span class="badge badge-info">Reg. Date : </span>
		<?=ucfirst($usser->reg_date)?>
	</li>
	
</ul>

<br>

<?php if(count($posts) != 0) : ?>
	<?php foreach($posts as $post) : ?>
		
		<?php
			$time = $post->time_stamp;
			$date = date("D, M d Y", $time);
			$set = explode(",", $post->settings);
			$bg = $set[0];
			$cl = $set[1];
			
		?>
		
		
		<div style="border: 1px dashed <?=$cl?>" class="p-1 d-block rounded position-relative ">
		
			<span class="p-1 shadow d-block d-flex justify-content-between" >
				<span class="badge badge-info" ><?=$post->post_by?></span>
				<span class="badge badge-info" ><?=$date?></span>
			</span>
			
			<span class="d-block" style="color:<?=$cl?>" >
				<?=$post->post_body?>
				<?php if($post->image) : ?>
					<img class="img-fluid rounded" src="/writable/uploads/post-image/<?=$post->image?>">
				<?php endif; ?>
			</span>
			
			<br>
			<span class="d-block d-flex justify-content-end" >
				<?php if(isset($_SESSION["user"]) && $_SESSION["user"] == $usser->username): ?>
					<a href="delete-post/<?=$post->id?>" go="" class="btn btn-danger btn-sm mr-3" >delete post</a>
				<?php endif; ?>
				<a  href="/camp-post/<?=$post->id?>" go="" class="btn btn-primary btn-sm">view comments</a>
			</span>
			
		</div>
		<br>
		
	
	<?php endforeach ?>
<?php endif; ?>



<?= $this->endSection()?>