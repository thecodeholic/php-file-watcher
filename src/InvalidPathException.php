<?php
/**
 * User: TheCodeholic
 * Date: 1/2/2020
 * Time: 1:02 PM
 */

namespace tc\fswatcher;


use Throwable;

/**
 * Class InvalidPathException
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package tc
 */
class InvalidPathException extends \Exception
{
    public function __construct($path, $code = 0, Throwable $previous = null)
    {
        parent::__construct("The following path \"$path\" does not exist", $code, $previous);
    }
}
