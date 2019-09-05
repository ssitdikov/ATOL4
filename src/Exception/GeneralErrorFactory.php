<?php declare(strict_types=1);

namespace SSitdikov\ATOL\Exception;

/**
 * Class GeneralErrorFactory
 *
 * @package SSitdikov\ATOL\Exception
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
class GeneralErrorFactory
{

    public static $exceptions = [
        WrongLoginOrPasswordException::CODE => WrongLoginOrPasswordException::class,
        IncomingOperationNotSupported::CODE => IncomingOperationNotSupported::class
    ];

    /**
     * @param $error
     *
     * @return \Exception
     */
    public static function getException($error): \Exception
    {
        $exception = self::$exceptions[$error->code] ?? \Exception::class;
        throw new $exception($error->text, $error->code);
    }
}
