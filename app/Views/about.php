<?php $this->extend("layout_main")?>

<!-- css -->
<?= $this->section("css")?>
<style type="text/css">
	#user{
		color:yellow;
	}
</style>
<?= $this->endSection()?>


<!-- body -->
<?= $this->section("body")?>

<div class="text-primary">
	<h3 class="text-center">Dear User</h3>
	
	
	<p class="text-justify">
		We really appreciate you for visiting our site.
		This mini web-app was created solely for the student of Osun State College of Technology
		(Esa-Oke). It should serve as:<br>
		1. The students collective voice towards the management.<br>
		2. The online forum of the school.<br>
		3. A means by which we share important information to other students.
	</p>
	
	<?php if(! isset($_SESSION["user"])): ?>
	<div class="py-2 text-center border rounded" >
		For our best user experience<br>
		<div class="btn-group">
			<?php
				if(! isset($ref)) $ref = null;
			?>
			<a href="/login?referral=<?=base64_encode($ref)?>" class="btn btn-primary ">Login</a>
			<a href="/signup" class="btn btn-primary" >Signup</a>
		</div>
	</div><br>
	<?php endif; ?>
	
	<p class="text-center text-warning">The osco câmp's team</p>
	
	<br>
</div>



<?= $this->endSection()?>