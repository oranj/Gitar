<?php

foreach ($this->trace as $i => $block) {
	echo "\n";
	#printf( "\nStep %d.\n", $i + 1);
	foreach ($block as $key => $value) {
		if (is_array($value)) {
			echo "  $key: \n";
			foreach ($value as $key2 => $value2) {
				printf("    %-15s %s\n", $key2.':', $value2);
			}
		} else {
			printf("  %-10s %s\n", $key.':', $value);
		}
	}
}
echo "\n\n";
?>
