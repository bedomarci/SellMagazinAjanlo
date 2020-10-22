<?php
function sell_log( $message, $clear = false ) {
	$row  = "\n" . date( 'Y/m/d h:i:s' ) . " " . $message;
	$mode = ( $clear ) ? 0 : FILE_APPEND;
	file_put_contents( WP_CONTENT_DIR . '/log.txt', $row, $mode );
}