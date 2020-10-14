<?php
function sell_log($message) {
    $row = "\n" . date('Y/m/d h:i:s') . " " . $message;
    file_put_contents(WP_CONTENT_DIR . '/log.txt', $row, FILE_APPEND);
}