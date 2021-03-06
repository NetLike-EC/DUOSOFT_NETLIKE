<?php
# PHPlot Example: Bar chart, 3 data sets, shaded
require_once ('../../init.php');
require_once (RAIZs.'inc/phplot/phplot.php');

$data=$dataG;
/*$data = array(
  array('Prensa Escrita', 40), array('Radio', 30), array('Medico', 20),
  array('?', 10), array('Medico',  3), array('Referido',  7),
);*/

$plot = new PHPlot(1000, 500);
$plot->SetImageBorderType('plain');
$plot->SetTitle('Provenance of Clients ('.$dFI.' al '.$dFF.')');
$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);
$plot->SetYTitle('Quantity');
$plot->SetXTitle('Refered by');
# Main plot title:


# Make a legend for the 3 data sets plotted:
//$plot->SetLegend(array('Engineering', 'Manufacturing', 'Administration'));

# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');


/************************//////




# Turn on Y data labels:
$plot->SetYDataLabelPos('plotin');


# Format the Y Data Labels as numbers with 1 decimal place.
# Note that this automatically calls SetYLabelType('data').
$plot->SetPrecisionY(0);


/***************************//////


//FIEL TYPE and EXPORT
$plot->SetFileFormat('jpg');
$plot->SetIsInline(TRUE);
$graph_SetOutputFile=$GraphGen_name;
$plot->SetOutputFile(RAIZc.'com_reportes/res/'.$graph_SetOutputFile);
$plot->DrawGraph();
?>
