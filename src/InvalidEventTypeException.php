<?php
/**
 * User: TheCodeholic
 * Date: 1/2/2020
 * Time: 2:29 PM
 */

namespace tc\fswatcher;


use Throwable;

/**
 * Class InvalidEventTypeException
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package tc\fswatcher
 */
class InvalidEventTypeException extends \Exception
{
    public function __construct($eventType, $code = 0, Throwable $previous = null)
    {
        parent::__construct("The following event type \"$eventType\" is not supported", $code, $previous);
    }
}
