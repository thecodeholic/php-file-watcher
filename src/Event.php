<?php
/**
 * User: TheCodeholic
 * Date: 1/2/2020
 * Time: 2:26 PM
 */

namespace tc\fswatcher;


/**
 * Class Event
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package tc\watcher
 */
class Event
{
    public $type = null;
    public $file = null;

    public function __construct($type, $path)
    {
        if (!in_array($type, EventTypes::getTypes())) {
            throw new InvalidEventTypeException($type);
        }

        $this->type = $type;
        $this->file = $path;
    }

    public function isDeletion()
    {
        return $this->type === EventTypes::FILE_DELETED;
    }

    public function isAddition()
    {
        return $this->type === EventTypes::FILE_ADDED;
    }

    public function isModification()
    {
        return $this->type === EventTypes::FILE_CHANGED;
    }
}
