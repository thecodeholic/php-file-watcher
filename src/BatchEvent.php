<?php
/**
 * User: TheCodeholic
 * Date: 1/2/2020
 * Time: 3:37 PM
 */

namespace tc\fswatcher;


/**
 * Class BatchEvent
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package tc\fswatcher
 */
class BatchEvent
{
    /**
     * @var Event[]
     */
    public $eventFiles = [];

    public function __construct($eventFiles)
    {
        $this->eventFiles = $eventFiles;
    }
}
