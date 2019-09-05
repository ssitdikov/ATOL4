<?php declare(strict_types=1);

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Exception\GeneralErrorFactory;
use SSitdikov\ATOL\Response\ResponseInterface;
use SSitdikov\ATOL\Response\TokenResponse;

/**
 * Class TokenRequest
 *
 * @package SSitdikov\ATOL\Request
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
class TokenRequest implements RequestInterface
{
    /**
     * Login
     *
     * @var string $login
     */
    private $login;

    /**
     * Password
     *
     * @var string $pass
     */
    private $pass;

    /**
     * TokenRequest constructor.
     *
     * @param string $login Login
     * @param string $pass Password
     */
    public function __construct(string $login, string $pass)
    {
        $this->login = $login;
        $this->pass = $pass;
    }

    /**
     * @inheritDoc
     */
    public function getRequestParams(): array
    {
        return [
            'json' => [
                'login' => $this->login,
                'pass' => $this->pass
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function getHttpMethod(): string
    {
        return self::METHOD_POST;
    }

    /**
     * @inheritDoc
     */
    public function getUrl(): string
    {
        return 'getToken';
    }

    /**
     * @inheritDoc
     *
     * @return TokenResponse
     */
    public function getResponse(\stdClass $response): ResponseInterface
    {
        if (isset($response->error)) {
            return GeneralErrorFactory::getException($response->error);
        }
        return new TokenResponse($response);
    }


}
