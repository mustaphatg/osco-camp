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

<?= form_open("/signup", 'class="row" onsubmit="return check()" ')?>

	<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
		
		<h3 class="text-center text-primary">Signup</h3>
		
		<?php	if(isset($er)) { echo $er; } ?>
		
		<div class="form-group">
			<input type="text" name="name" class="bg-dark text-primary form-control" placeholder="Name" value="<?= set_value('name')?>" required  >
		</div>
		
		<div class="form-group">
			<input type="text" name="username" class="bg-dark text-primary form-control" placeholder="Username" value="<?= set_value('username')?>" required  >
		</div>
		
		<div class="form-group">
			<input type="email" name="email" class="bg-dark text-primary form-control" placeholder="Email Address" value="<?= set_value('email')?>" required  >
		</div>
		
		<div class="form-group">
			<input type="password" name="password" class="bg-dark text-primary form-control" placeholder="Password" value="<?= set_value('password')?>" required  >
		</div>
		
		<div class="form-group">
		<select id="se" required name="faculty" class="custom-select form-control " >
			<option  unselect >Select Your Faculty</option>
			<option value="Environmental Science"  >Environmental Science</option>
			<option value="Management Science"  >Management Science</option>
			<option value="Applied Science"  >Applied Science</option>
			<option value="Engineering " >Engineering</option>
			<option value="ICT" >ICT</option>
		</select>
		</div>
		
		<input type="submit" class="btn btn-info btn-block" value="Signup" name="signup"  >
		<br>
		<a href="/login" go="" class="d-block text-center" >Login instead</a>
	</div>

<?= form_close()?>

<?= $this->endSection()?>


<?= $this->section("js")?>
<script type="text/javascript">
	var se = document.querySelector("#se")
	
	function check(){
		var ind = se.selectedIndex
		
		if(ind == 0){
			alert("Select a valid faculty")
			setTimeout(function(){
				$(".l").fadeOut();
			}, 1000)
			return false
		}

	}
	
</script>

<?= $this->endSection()?>