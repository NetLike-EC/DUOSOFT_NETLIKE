<?php
$tp=vParam('tp',$_GET['tp'],$_POST['tp']);
$vp=vParam('vp',$_GET['vp'],$_POST['vp']);
if($tp=='cod'){
	$cp='prod_cod';
}
if($tp=='nom'){
	$cp='prod_nom';
}



//if($cod) $paramS['cod'].=" AND prod_cod LIKE '%".$cod."%' ";
if(($tp)&&($vp)){
	$paramF.=" WHERE ".$cp." LIKE '%".$vp."%' ";
}

$query_RSp='SELECT * FROM tbl_inv_productos '.$paramF.' ORDER BY prod_id DESC';
//$query_RSp=sprintf('SELECT * FROM tbl_inv_productos %s ORDER BY prod_id DESC',
//GetSQLValueString($paramS,''));
$RSpt = mysql_query($query_RSp) or die(mysql_error());
$row_RSpt = mysql_fetch_assoc($RSpt);
$totalRows_RSpt = mysql_num_rows($RSpt);
if ($totalRows_RSpt>0) {
$pages = new Paginator;
	$pages->items_total = $totalRows_RSpt;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSp = mysql_query($query_RSp.' '.$pages->limit) or die(mysql_error());
	$row_RSp = mysql_fetch_assoc($RSp);
	$totalRows_RSp = mysql_num_rows($RSp);
	$viewPaginator='
	<div class="pag_port_tit">
		<span class="pagination"><ul>'.$pages->display_pages().'</ul></span>
		<span class="pull-right">'.$pages->display_items_per_page().'</span>
	</div>';
}
$ms='miart';?>
<div class="container-fluid">
<?php //echo '<hr><h1>'.$query_RSp.'</h1>'; ?>
<?php include('_fra_top.php');
sLOG('g');?>
<div class="portlet box <?php echo $iColor ?>">
<div class="portlet-title">
	<div class="row-fluid">
    	<div class="span4"><h4><i class="<?php echo $btn1_ico ?>"></i> Listado</h4></div>
        <div class="span8"><?php echo $viewPaginator ?></div>
    </div>
</div>
<div class="portlet-body">
<div class="well well-small">
	<div class="row-fluid">
    	<div class="span8"><form method="get" action="<?php $_SESSION['urlc'] ?>" class="form-search">
<select name="tp">
	<option value="cod" <?php if($tp=='cod'){ ?> selected<?php } ?>>Codigo</option>
    <option value="nom" <?php if($tp=='nom'){ ?> selected<?php } ?>>Nombre</option>
</select>
<input type="text" name="vp" autocomplete="off" value="<?php echo $vp ?>" class="input-medium search-query">
 <button type="submit" class="btn">Buscar</button>
</form></div>
        <div class="span4"><?php if($paramF){ ?>Resultados Busqueda:  <a class="btn"><?php echo $totalRows_RSpt; ?></a> Ver <a href="<?php $_SESSION['urlc'] ?>" class="btn">Todos</a><?php } ?></div>
    </div>

</div>
<?php if($totalRows_RSp>0){ ?>
<table class="table table-bordered table-condensed table-striped" id="itm_table">
<thead>
	<tr>
        <th>ID</th>
        <th>Activo</th>
        <th>Nombre</th>
        <th>Codigo</th>
        <th>Tipo / Categoria</th>
        <th>Marca</th>
        <th></th>
        <th><abbr title="Inventario">Exis</abbr></th>
        <th>Accion</th>
	</tr>
</thead>
<tbody>
	<?php
    do {
		$detProdTip=detInvTip($row_RSp['tip_cod']);
		$detProdCat=detInvCat($detProdTip['cat_cod']);
		$detProdMar=detInvMar($row_RSp['mar_id']);
		$detProd_id=$row_RSp['prod_id'];
		$detProd_cod=$row_RSp['prod_cod'];
		$detProd_stat=fnc_status($row_RSp['prod_id'], $row_RSp['prod_stat'],'_fncts.php' );
		
		$detProd_img=fnc_image_exist('db/prod/',$row_RSp['prod_img'],TRUE);
		$viewImage='<div class="item text-center">
		<a href="'.$detProd_img['norm'].'" data-rel="fancybox-button" class="fancybox-button">
		<div class="zoom"><img src="'.$detProd_img['thumb'].'" class="img-tiny"/>
		<div class="zoom-icon"></div></div></a></div>';	
		$detProd_link='<a href="inv_form_prod.php?id='.$row_RSp['prod_id'].'">
        <abbr title="'.$row_RSp['prod_cod'].'">'.$row_RSp['prod_nom'].'</abbr></a>';
	?>
	  <tr>
        <td><?php echo $detProd_id ?></td>
        <td><?php echo $detProd_stat ?></td>
        <td><?php echo $detProd_link ?></td>
        <td><small><?php echo $detProd_cod?></small></td>
	    <td><?php echo $detProdTip['tip_nom'] ?> 
        <span class="label"><small><?php echo $detProdCat['cat_nom']; ?></small></span></td>
        <td><?php echo $detProdMar['mar_nom'] ?></td>
        <td><?php echo $viewImage ?></td>
        <td><?php echo stock_existente_producto($row_RSp['prod_id']); ?></td>
        <td>
			<div class="btn-group list">
				<a href="kardex.php?id=<?php echo $row_RSp['prod_id']; ?>" class="btn mini">KARDEX</a> 
                <a href="inv_form_prod.php?id=<?php echo $row_RSp['prod_id']; ?>" class="btn mini blue">
				<i class="icon-edit"></i> Editar</a>
				<a href="_fncts.php?id=<?php echo $row_RSp['prod_id']; ?>&action=DEL" class="btn mini red" onClick="return aconfirm('DEL')">
				<i class="icon-trash"></i> Eliminar</a>
			</div>
        </td>
	    </tr>
	  <?php } while ($row_RSp = mysql_fetch_assoc($RSp)); ?>
</tbody>
</table>
<div class="well"><?php echo $viewPaginator ?></div>
<?php mysql_free_result($RSp);
}else{ echo '<div class="alert alert-error"><h4>No Existen Productos en Inventario</h4></div>';
} ?>
</div>
</div>
</div>