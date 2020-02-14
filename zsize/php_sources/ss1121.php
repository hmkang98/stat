<?php 
$alpha = trim($_POST['alpha']); 
$beta = trim($_POST['beta']);
$ovalue = trim($_POST['ovalue']);
$alter = trim($_POST['alter']); 
$sigma2 = trim($_POST['sigma2']); 

require_once('Normal.php');

function alertBack($str) {
	echo "
	<script type=\"text/javascript\">
		alert('" . $str . "')
		history.go(-1);
	</script>
	";
}

$titleStr = "단일 표본수 계산(one-sided)";
?>
<html>
<head>
	<title><?=$titleStr?></title>
<?php

if (strlen($alpha) < 1 || strlen($beta) < 1 || strlen($ovalue) < 1 || strlen($alter) < 1|| strlen($sigma2) < 1) {
	alertBack("alpha 와 beta, μ<sub>0</sub>,μ<sub>1</sub>,분산을 다시 입력하시기 바랍니다.");
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
if (($ovalue == $alter)) {
	alertBack("μ<sub>0</sub>와 μ<sub>1</sub>은 서로 다른 값을 가집니다.");
	exit;
}

if ($sigma2 <='0.0') {
	alertBack("분산는 0보다 큰 값을 가집니다.");
	exit;
}

$es = ($ovalue-$alter)/sqrt($sigma2);
$za = Quantile(1-$alpha);
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
				<TD> 유의수준(α) = <?=$alpha?>, 검정력(β) = <?=$beta?>, μ<sub>0</sub>= <?=$ovalue?>, μ<sub>1</sub> = <?=$alter?>, 분산(σ²) = <?=$sigma2?>인경우<p>
&nbsp;&nbsp;&nbsp;&nbsp;effect size 는 &nbsp;<B><?=round($es,4)?></B> 이고,<P>
&nbsp;&nbsp;&nbsp;&nbsp;계산된 결과 는 <B> <?=round($ss1,4)?> </B>  입니다. 
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