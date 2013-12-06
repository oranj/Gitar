<div class="breadcrumbs">
	<div class="inner">
		<div class="breadcrumb breadcrumb_link"><a href="/"> - repos -</a></div>
		<div class="sep"></div>
<?php

$first = true;
$last = count($this->links) - 1;
$i = 0;
foreach ($this->links as $link) {
	if (! $first) {
		echo '<div class="sep"></div>';
	}
	$first = false;
	if ($i == $last) {
		printf('<div class="breadcrumb">%s</div>', $link['base']);
	} else {
		printf('<div class="breadcrumb breadcrumb_link"><a href="%s">%s</a></div>', $link['path'], $link['base']);
	}
	$i++;
}
?>
		<div class="breadcrumb_last"></div>
	</div>

	<div class="clearing"></div>
</div>