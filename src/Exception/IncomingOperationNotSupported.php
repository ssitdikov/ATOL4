<?php declare(strict_types=1);

namespace SSitdikov\ATOL\Exception;

use Throwable;

/**
 * Class IncomingOperationNotSupported
 *
 * @package SSitdikov\ATOL\Exception
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
class IncomingOperationNotSupported extends \InvalidArgumentException
{
    public const CODE = 32;

    /**
     * IncomingOperationNotSupported constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        /**
         * If we have PatternMismatch value - replace message to correct
         */
        preg_match('#PatternMismatch: .+#', $message, $failed_field);
        if (isset($failed_field[0])) {
            $message = 'Error in field: ' . str_replace('PatternMismatch: #/', '', $failed_field[0]);
        }
        parent::__construct($message, $code, $previous);
    }


}
