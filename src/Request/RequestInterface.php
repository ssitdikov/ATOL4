<?php declare(strict_types=1);

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Response\ResponseInterface;

/**
 * Interface RequestInterface
 *
 * @package SSitdikov\ATOL\Request
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
interface RequestInterface
{
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';

    /**
     * Request HTTP method
     *
     * @return string
     */
    public function getHttpMethod(): string;

    /**
     * Request params
     *
     * @return array
     */
    public function getRequestParams(): array;

    /**
     * Request url
     *
     * @return string
     */
    public function getUrl(): string;

    /**
     * Response handler
     *
     * @param \stdClass $response Response result
     *
     * @return ResponseInterface
     *
     * @throws \Exception
     */
    public function getResponse(\stdClass $response): ResponseInterface;
}
