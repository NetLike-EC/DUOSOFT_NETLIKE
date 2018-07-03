<html>
<head>
<script language="javascript">

function shell(command)

{
   RegWsh = new ActiveXObject("WScript.Shell");
   RegWsh.Run(command);
}
</script> 
</head>

<body>

<input type="Button" value="OpenCalc" onclick="javascript:shell('
calc.exe');">

</body>





ese codgo permitwe abrir la calculadora de windows.
pero solo funciona en INTENET EXPLORER.

no en forefox.
seguire averiguando ya que una ves creo que me resulto bien.



saludos

</html>