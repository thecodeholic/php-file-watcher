<?php
/**
 * User: TheCodeholic
 * Date: 1/2/2020
 * Time: 1:01 PM
 */

namespace tc\fswatcher;

/**
 * Class Watcher
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package tc
 */
class Watcher
{
    private $path;
    private $filesMap = [];
    private $options = null;
    private $callback = null;

    public function __construct($path, $callback, $options = [])
    {
        if (!file_exists($path)) {
            throw new InvalidPathException($path);
        }
        $this->options = new Options();
        foreach ($options as $key => $value) {
            if (!property_exists($this->options, $key)) {
                throw new InvalidOptionException($key, Options::class);
            } else {
                $this->options->$key = $value;
            }
        }

        $this->callback = $callback;
        $this->path = $path;
    }

    /**
     * Start watching of the file/folder
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    public function watch()
    {
        $this->filesMap = $this->readPath($this->path);
        while (true) {
            $this->clearStats();
            $this->checkPath($this->path);
            sleep($this->options->watchInterval);
        }
    }

    /**
     * Clear statistics for the watching files
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    public function clearStats()
    {
        foreach ($this->filesMap as $file => $time) {
            clearstatcache(false, $file);
        }
    }


    /**
     * Find all files in given path and create an associative array where
     * key is file or folder path and value is when it was modified
     *
     * @param string $path file or folder path
     * @return array
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    public function readPath($path)
    {
        $filesMap = [];
        $filesMap[$path] = filemtime($path);
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $actualPath = $path . '/' . $file;
                $filesMap[$actualPath] = filemtime($actualPath);
                if (is_dir($actualPath)) {
                    $tmp = $this->readPath($actualPath);
                    $filesMap = $filesMap + $tmp;
                }
            }
        }
        return $filesMap;
    }


    /**
     * Compares current status of the folder to previous status and if something
     * is modified prints the result
     *
     * @param $path
     * @throws InvalidEventTypeException
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    function checkPath($path)
    {
        $eventFiles = [];
        $currentStatus = $this->readPath($path);
        // Detect deleted files and modifications...
        foreach ($this->filesMap as $file => $time) {
            if (!isset($currentStatus[$file])) {
                $eventFiles[] = new Event(EventTypes::FILE_DELETED, $file);
            } else if ($currentStatus[$file] !== $time) {
                $eventFiles[] = new Event(EventTypes::FILE_CHANGED, $file);
            }
        }
        // Detect new files
        foreach ($currentStatus as $file => $time) {
            if (!isset($this->filesMap[$file])) {
                $eventFiles[] = new Event(EventTypes::FILE_ADDED, $file);
            }
        }
        $this->filesMap = $currentStatus;

        if ($this->options->cacheChanges && $eventFiles){
            $this->triggerEvent(new BatchEvent($eventFiles));
        } else {
            foreach ($eventFiles as $event) {
                $this->triggerEvent($event);
            }
        }
    }

    protected function triggerEvent($event)
    {
        if ($this->callback && $this->callback instanceof \Closure) {
            call_user_func($this->callback, $event);
        }
    }
}
