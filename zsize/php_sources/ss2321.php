<?php 
$alpha = trim($_POST['alpha']); 
$n = trim($_POST['n']);
$p0 = trim($_POST['p0']);
$p1 = trim($_POST['p1']); 
$p2 = trim($_POST['p2']);

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

$titleStr = "검정력 계산(one-sided) : p<sub>0</sub>> p<sub>2</sub>인 경우";
?>
<html>
<head>
	<title><?=$titleStr?></title>
<?php

if (strlen($alpha) < 1 || strlen($n) < 1 || strlen($p0) < 1|| strlen($p1) < 1|| strlen($p2) < 1) {
	alertBack("alpha 와 각 집단의 표본수, p<sub>0</sub>,p<sub>1</sub>,p<sub>2</sub>을 다시 입력하시기 바랍니다.");
	exit;
}

if ($n <= '0.0') {
	alertBack("표본수는 0보다 큰 값을 가집니다.");
	exit;
}

if (($alpha <='0.0') || ($alpha >= '1.0')) {
	alertBack("alpha는 0부터 1사이의 값을 가집니다.");
	exit;
}
if ($p0 <='0.0') {
	alertBack("p<sub>0</sub>는 0보다 큰 값을 가집니다.");
	exit;
}
if ($p1 <='0.0') {
	alertBack("p<sub>1</sub>는 0보다 큰 값을 가집니다.");
	exit;
}
if ($p2 <='0.0') {
	alertBack("p<sub>2</sub>는 0보다 큰 값을 가집니다.");
	exit;
}
$za = Quantile(1-$alpha);
$beta = ($za *sqrt(2*$p0*(1-$p0)/$n)-($p1-$p2))/sqrt($p1*(1-$p1)/$n+$p2*(1-$p2)/$n);
$power = 1-calculate($beta);
?>
</head>
<body>
	<h2 align="center"><?=$titleStr?></h2>
	<table border=0 cellspacing=1 cellpadding=0 align=center>
	<tr>
		<td bgColor="#ff0000">
			<table border="0" cellspacing="1" cellpadding="10" align="center">
			<tr BGCOLOR="#f5f5f5">
				<TD> 유의수준(α) = <?=$alpha?>, 각 집단의 표본수 = <?=$n?>, p<sub>0</sub>= <?=$p0?>, p<sub>1</sub>= <?=$p1?>, p<sub>2</sub>= <?=$p2?>인경우<p>
&nbsp;&nbsp;&nbsp;&nbsp;계산된 결과는 <B> <?=round($power,4)?> </B>  입니다.<P> 
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