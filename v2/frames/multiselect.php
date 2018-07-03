<div class="well well-sm">
	<label><input type="checkbox" id="checkallcb"> <?php echo $cfg[t][checkA] ?> </label> <span class="label label-default"><?php echo $cfg[t][withS] ?></span> 
	<div class="btn-group">
		<button class="btn btn-default btn-xs" name="accm" value="<?php echo md5('enable') ?>" type="submit" id="vAcc"><?php echo $cfg[b][ena] ?></button>
		<button class="btn btn-default btn-xs" name="accm" value="<?php echo md5('delete') ?>" type="submit" id="vAcc"><?php echo $cfg[b][del] ?></button>
		<button class="btn btn-default btn-xs" name="accm" value="<?php echo md5('disable') ?>" type="submit" id="vAcc"><?php echo $cfg[b][dis] ?></button>
	</div>
</div>