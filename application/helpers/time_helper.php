<?php

function minutes ($timeStr) {
	$arr = explode(':', $timeStr);

	return $arr[0] * 60 + $arr[1];
}