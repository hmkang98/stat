<?php 
$alpha = trim($_POST['alpha']); 
$es = trim($_POST['es']);
$n = trim($_POST['n']);

require_once('Norper.php');
require_once('Normal.php');

function alertBack($str) {
	echo "
	<script type=\"text/javascript\">
		alert('" . $str . "')
		history.go(-1);
	</script>
	";
}

$titleStr = "검정력 계산(two-sided)";
?>
<html>
<head>
	<title><?=$titleStr?></title>
<?php

if (strlen($alpha) < 1 || strlen($n) < 1 || strlen($es) < 1) {
	alertBack("alpha 와 각 그룹의 표본수, effect size를 다시 입력하시기 바랍니다.");
	exit;
}

if ($n <= '0.0') {
	alertBack("각 그룹의 표본수는 0보다 큰 값을 가집니다.");
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

$Za = Quantile(1-$alpha/2.);
$beta1 = $Za-$es*sqrt($n/2.);
$beta2 = -$Za-$es*sqrt($n/2.);
$power = 1-calculate($beta1)+calculate($beta2);
?>
</head>
<body>
	<h2 align="center"><?=$titleStr?></h2>
	<table border=0 cellspacing=1 cellpadding=0 align=center>
	<tr>
		<td bgColor="#ff0000">
			<table border="0" cellspacing="1" cellpadding="10" align="center">
			<tr BGCOLOR="#f5f5f5">
				<TD> 유의수준(α) = <?=$alpha?> , effect size = <?=abs($es)?>, 각 그룹의 표본수 = <?=$n?>인 경우 <p>
&nbsp;&nbsp;&nbsp;&nbsp;계산된 결과는 <B> <?=round($power,4)?> </B>  입니다. <P>
						따라서 검정력은 약<FONT COLOR="#ff0000"><B> <?=round($power,2)?> </B> </FONT>입니다.
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