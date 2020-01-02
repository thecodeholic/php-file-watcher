<?php
/**
 * User: TheCodeholic
 * Date: 1/2/2020
 * Time: 2:13 PM
 */

namespace tc\fswatcher;


use Throwable;

/**
 * Class InvalidOptionException
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package tc\watcher
 */
class InvalidOptionException extends \Exception
{
    public function __construct($option, $className, $code = 0, Throwable $previous = null)
    {
        parent::__construct("The option \"$option\" is not supported on \"$className\"", $code, $previous);
    }
}
