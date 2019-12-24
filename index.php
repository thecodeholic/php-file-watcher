<?php
/**
 * User: TheCodeholic
 * Date: 12/24/2019
 * Time: 8:36 AM
 */

$path = $argv[1];
$previousDate = filemtime($path);

$filesMap = [];
readPath($path, $filesMap);
echo "Watching \"$path\" changes..." . PHP_EOL;
while (true) {
    clearStats();
    checkPath($path);
    sleep(1);
}

/**
 * Clear statistics for the watching files
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 */
function clearStats()
{
    global $filesMap;
    foreach ($filesMap as $file => $time) {
        clearstatcache(false, $file);
    }
}

/**
 * Compares current status of the folder to previous status and if something
 * is modified prints the result
 *
 * @param $path
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 */
function checkPath($path)
{
    global $filesMap;
    $currentStatus = [];
    readPath($path, $currentStatus);
    // Detect deleted files and modifications...
    foreach ($filesMap as $file => $time) {
        if (!isset($currentStatus[$file])) {
            echo "File \"$file\" was deleted..." . PHP_EOL;
        } else if ($currentStatus[$file] !== $time) {
            echo "File \"$file\" was modified..." . PHP_EOL;
        }
    }
    // Detect new files
    foreach ($currentStatus as $file => $time) {
        if (!isset($filesMap[$file])) {
            echo "File \"$file\" was added..." . PHP_EOL;
        }
    }
    $filesMap = $currentStatus;
}

/**
 * Find all files in given path and create an associative array where
 * key is file or folder path and value is when it was modified
 *
 * @param string $path file or folder path
 * @param array $filesMap associative array where key is file or folder path
 * and value is when it was modified
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 */
function readPath($path, &$filesMap)
{
    if (is_dir($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $actualPath = $path . '/' . $file;
            $filesMap[$actualPath] = filemtime($actualPath);
            if (is_dir($actualPath)) {
                readPath($actualPath, $filesMap);
            }
        }
    }
    $filesMap[$path] = filemtime($path);
}
