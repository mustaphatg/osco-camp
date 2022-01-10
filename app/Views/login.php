<?php $this->extend("layout_main")?>

<?= $this->section("css")?>
<style type="text/css">
	a[icon=user]{
		color:yellow;
	}
</style>
<?= $this->endSection()?>


<!-- body -->
<?= $this->section("body")?>

	<?php
		if(! isset($ref)) { $ref = null; }
		$submit_url = "/login?referral=".$ref
	?>

	<?= form_open($submit_url, 'class="row" ')?>
	
		<div class="my-3 col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
			
			<h3 class="text-center text-primary">Login</h3>
			
			<?php	if(isset($er)) { echo $er; } ?>
			
			<div class="form-group">
				<input type="text" name="username" class="bg-dark text-primary form-control" placeholder="Your username" value="<?= set_value('username')?>" required  >
			</div>
			
			<div class="form-group">
				<input type="password" name="password" class="bg-dark text-primary form-control" placeholder="Your password" value="<?= set_value('password')?>" required  >
			</div>
			
			<input type="submit" class="btn btn-info btn-block" value="Login" name="login"  >
			<br>
			<a href="signup" go="" class="d-block text-center" >Signup instead</a>
		</div>
	
	<?= form_close()?>

<?= $this->endSection()?>