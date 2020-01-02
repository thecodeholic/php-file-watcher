<?php
/**
 * User: TheCodeholic
 * Date: 1/2/2020
 * Time: 2:27 PM
 */

namespace tc\fswatcher;


/**
 * Class EventTypes
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package tc\fswatcher
 */
class EventTypes
{
    const FILE_ADDED = 'FILE_ADDED';
    const FILE_CHANGED = 'FILE_CHANGED';
    const FILE_DELETED = 'FILE_DELETED';

    public static function getTypes()
    {
        $reflection = new \ReflectionClass(self::class);
        return $reflection->getConstants();
    }
}
