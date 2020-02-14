<?php 
$alpha = trim($_POST['alpha']); 
$beta = trim($_POST['beta']);
$es = trim($_POST['es']);

require_once('Normal.php');

function alertBack($str) {
	echo "
	<script type=\"text/javascript\">
		alert('" . $str . "')
		history.go(-1);
	</script>
	";
}

$titleStr = "독립인 두 표본수 계산(two-sided)";
?>
<html>
<head>
	<title><?=$titleStr?></title>
<?php

if (strlen($alpha) < 1 || strlen($beta) < 1 || strlen($es) < 1) {
	alertBack("alpha 와 beta, effect size를 다시 입력하시기 바랍니다.");
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

if ($es <='0.0') {
	alertBack("es는 0보다 큰 값을 가집니다.");
	exit;
}

$za = Quantile(1-$alpha/2);
$zb = Quantile($beta);
 

$ss1 = pow(($za+$zb)/($es),2);
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
				<TD> 유의수준(α) = <?=$alpha?> , 검정력(β) = <?=$beta?>,  effect size = <?=$es?> 인 경우<P>
&nbsp;&nbsp;&nbsp;&nbsp;  계산된 결과는 <B> <?=round($ss1,4)?> </B>  입니다. 
				<P>따라서 각 집단의 표본수는 <FONT COLOR="#ff0000"><B> <?=$ss11?> </B> </FONT>개입니다.
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