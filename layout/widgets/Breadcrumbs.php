<?php


$first = true;
foreach ($this->links as $link) {
	if (! $first) {
		echo $this->separator;
	}
	$first = false;
	printf('<a href="%s">%s</a>', $link['path'], $link['base']);
}