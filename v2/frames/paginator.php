<div class="well well-sm">
    <div class="row">
    	<div class="col-md-2"><span class="label label-default"><?php echo $cfg[t][show] ?> <strong><?php echo intval($TR) ?></strong> <?php echo $cfg[t][rows] ?></span></div>
        <div class="col-md-6">
			<ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
    	</div>
        <div class="col-md-4 text-right"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>