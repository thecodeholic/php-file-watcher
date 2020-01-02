<?php
/**
 * User: TheCodeholic
 * Date: 12/24/2019
 * Time: 8:36 AM
 */

use tc\fswatcher\Event;
use tc\fswatcher\Watcher;

require __DIR__ . '/vendor/autoload.php';

$path = $argv[1];

$watcher = new Watcher($path, function (Event $event) {
    echo "File \"$event->file\" was $event->type".PHP_EOL;
});
$watcher->watch();
