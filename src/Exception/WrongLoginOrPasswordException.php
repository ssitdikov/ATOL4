<?php declare(strict_types=1);

namespace SSitdikov\ATOL\Exception;

/**
 * Class WrongLoginOrPasswordException
 *
 * @package SSitdikov\ATOL\Exception
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
class WrongLoginOrPasswordException extends \RuntimeException
{
    public const CODE = 12;
}
