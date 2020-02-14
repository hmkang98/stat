<?php 
$alpha = trim($_POST['alpha']); 
$beta = trim($_POST['beta']);
$p0 = trim($_POST['p0']);
$p1 = trim($_POST['p1']); 

require_once('Normal.php');

function alertBack($str) {
	echo "
	<script type=\"text/javascript\">
		alert('" . $str . "')
		history.go(-1);
	</script>
	";
}

$titleStr = "단일 표본수 계산(two-sided)";
?>
<html>
<head>
	<title><?=$titleStr?></title>
<?php

if (strlen($alpha) < 1 || strlen($beta) < 1 || strlen($p0) < 1 || strlen($p1) < 1 ) {
	alertBack("alpha 와 beta, .p<sub>0</sub>,p<sub>1</sub>을 다시 입력하시기 바랍니다.");
	exit;
}

if (($beta <= '0.0') || ($beta >= '1.0')) {
	alertBack("beta는 0부터 1사이의 값을 가집니다.");
	exit;
}

if (($alpha <='0.0') || ($alpha >= '1.0')) {
	alertBack("alpha는 0부터 1사이의 값을 가집니다.");
	exit;
}

if (($p0 <='0.0') || ($p0 >= '1.0')) {
	alertBack("p<sub>0</sub>는 0부터 1사이의 값을 가집니다.");
	exit;
}
if (($p1 <='0.0') || ($p1 >= '1.0')) {
	alertBack("p<sub>1</sub>는 0부터 1사이의 값을 가집니다.");
	exit;
}
if (($p0 == $p1)) {
	alertBack("p<sub>0</sub>와 p<sub>1</sub>은 서로 다른 값을 가집니다.");
	exit;
}


$za = Quantile(1-$alpha/2);
$zb = Quantile($beta);
$up = pow($za*sqrt($p0*(1-$p0))+$zb*sqrt($p1*(1-$p1)),2);
$down = pow($p0-$p1,2);
$ss1 = $up/$down;
$ss11 = ceil($ss1);

?>
</head>
<body>
	<h2 align="center"><?=$titleStr?></h2>
	<table border=0 cellspacing=1 cellpadding=0 align=center>
	<tr>
		<td bgColor="#ff0000">
			<table border="0" cellspacing="1" cellpadding="10" align="center">
			<tr BGCOLOR="#f5f5f5">
				<TD> 유의수준(α) = <?=$alpha?> , 검정력(β) = <?=$beta?>, p<sub>0</sub>= <?=$p0?>, p<sub>1</sub>= <?=$p1?>인경우<p>
&nbsp;&nbsp;&nbsp;&nbsp;  계산된 결과는 <B> <?=round($ss1,4)?> </B>  입니다. 
				<P>따라서 표본수는 <FONT COLOR="#ff0000"><B> <?=$ss11?> </B> </FONT>개입니다.
				</TD>
			</tr>
			</TABLE>
		</TD>
	</tr>
	</table>
</body>
<?
$htmlfile = "announce.html";
$fp = fopen($htmlfile, "r");
$html = fread($fp, filesize($htmlfile));
echo($html);
?>
</html>