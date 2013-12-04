<?php


function see() {
	$args = func_get_args();
	$backtrace = debug_backtrace();
	ob_start();

	foreach ($backtrace as $i => $trace) {
		if (! in_array($trace['function'], array('see', 'drop', 'call_user_func_array'))) {
			break;
		}
	}

	echo "vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv\n\n";
	echo $backtrace[$i-1]['file'].':'.$backtrace[$i-1]['line']."\n\n";

	foreach ($args as $i => $arg) {
		printf('--------------------------- ARG %02d ---------------------------'.PHP_EOL.PHP_EOL, $i);
		print_r($arg);
		echo PHP_EOL.PHP_EOL;
	}
	echo '^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^'.PHP_EOL;
	$html = ob_get_clean();

	echo "<pre>".htmlentities($html)."</pre><!---\n\n\n$html\n\n\n-->\n";
}

function drop() {
	call_user_func_array('see', func_get_args());
	exit;
}

function json_success($data = array()) {
	echo json_encode(array(
		'status' => 'success',
		'data' => $data
	));
	exit;
}

function json_failure($errorId, $message) {
	echo json_encode(array(
		'status' => 'error',
		'error' => $errorId,
		'message' => $message
	));
	exit;
}


function makeTitle() {
	return 'Gita'.(str_repeat('r', rand(1, 5))).'<span id="metal">r</span>'.(str_repeat('r', rand(1,5)));
}


function mydate($timestamp){
	if (is_null($timestamp)) { return 'Never'; }
	if (is_string($timestamp)) { $timestamp = strtotime($timestamp); }
	$days = floor((time() - $timestamp) / 86400);

	if ($days == 0) {
		return 'Today';
	} else if ($days < 7) {
		return sprintf("%d day%s ago", $days, $days > 1 ? 's' : '');
	} else if ($days < 34) {
		$weeks = floor($days / 7);
		return sprintf('%d week%s ago', $weeks, $weeks > 1 ? 's' : '');
	} else if ($days < 365) {
		$months = floor($days / 30);
		return sprintf("%d month%s ago", $months, $months > 1 ? 's':'');
	} else {
		$years = floor($days / 365);
		return sprintf("%d year%s ago", $years, $years > 1 ? 's':'');
	}
}