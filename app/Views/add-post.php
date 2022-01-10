<?php $this->extend("layout_main")?>

<!-- css -->
<?= $this->section("css")?>
<style type="text/css">
	a[icon=add]{
		color:yellow;
	}
	
	#txx{
		color:#2196F3;
		background:#343a40;
	}
</style>
<?= $this->endSection()?>



<!--body  -->
<?= $this->section("body")?>

	<?=form_open_multipart("/add", 'class=""') ?>
		<?php if(isset($er)) echo $er; ?>
		
		<div class="row">
			<div class="col-6">
				<select name="background" onchange="backgroundChange(this)" class="form-control custom-select" >
					<option value=" #343a40" >Dark</option>
					<option value="#2196F3" >Blue</option>
					<option value="#F44336" >Red</option>
					<option value="#4CAF50" >Green</option>
					<option value="#ffeb3b" >Yellow</option>
					<option value="#FFFFFF" >White</option>
				</select>
			</div>
			<div class="col-6 form-group">
				<select name="color" onchange="colorChange(this)" class="form-control custom-select" >
					<option value="#2196F3" >Blue</option>
					<option value="#F44336" >Red</option>
					<option value="#4CAF50" >Green</option>
					<option value="#ffeb3b" >Yellow</option>
					<option value="#FFFFFF" >White</option>
				</select>
			</div>
		</div>
	
		<div class="form-group">
			<textarea id="txx" rows="3" name="post_body" class="form-control" >Hello guys...</textarea>
		</div>
		
		<div class="">
			<img id="imm" class=" d-block mx-auto "  ><br>
			<label class="btn btn-info" >
				<input id="image"  onchange="imageChange()" type="file" name="image" style="visibility:hidden; width:0.1px; height:o.1px; z-index:-1; "   >
				<span class="ion-ios-image" ></span> Add Image
			</label>
		</div>
		
		<div class="form-group">
			<input type="submit" class="btn btn-info btn-block"  name="add" value="POST" >
		</div>
	
	<?= form_close()?>

<?= $this->endSection()?>


<?= $this->section("js")?>

<script type="text/javascript">
	var tx = $("#txx")
	
	function backgroundChange(t){
		var v = t.value
		tx.css("background-color", v)
	}
	
	function colorChange(t){
		var v = t.value
		tx.css("color", v)
	}
	
	function imageChange(){
		var fi = document.querySelector("#image").files[0]
		var nt = fi.type
		//if type do not matches the rule return
		if(! nt.match(/^image\/.+$/)){
			alert("Image type is not supported")
			return;
		}
		
		var imm = document.querySelector("#imm")
		imm.height = 100
		imm.width = 100
		imm.src = URL.createObjectURL(fi)
		imm.onload = function(){
			URL.revokeObjectURL(imm.src)
		}
	}
	
</script>

<?= $this->endSection()?>