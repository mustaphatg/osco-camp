<?php $this->extend("layout_main")?>

<?= $this->section("css")?>
<style type="text/css">
	a[icon=bell]{
		color:yellow;
	}
</style>
<?= $this->endSection()?>



<?= $this->section("body")?>

<h4 class="text-primary text-center">Notifications</h4>

<?php foreach($mynotys as $post): ?>
	<?php
		//first is background
		$set = explode(",", $post->settings);
		$bg = $set[0];
		$cl = $set[1];
	?>
	<div  style="border:1px dashed<?=$cl?>" class="mt-2 p-1 rounded post">
		
		<span  class="shadow text-info d-block">
			<a style="color:#fff" href="/camp-user/<?=$post->post_by?>" pr="" go="" class="badge badge-info text-capitalize" ><?=$post->post_by?></a>
		</span> <!--  end of info part -->
		
		<span class="p-1 d-block" style="color:<?=$cl?>"  >
			<?=$post->post_body?>
			<?php if($post->image) : ?>
				<img class="img-fluid rounded" src="/writable/uploads/post-image/<?=$post->image?>">
			<?php endif; ?>
		</span>
		
		<span class="d-block d-flex justify-content-end" >
			<a go="" href="/camp-post/<?=$post->id?>" class="btn btn-sm btn-primary">view comments</a>
		</span>
		
	</div>
	<br>

<?php endforeach; ?>


<?= $this->endSection()?>