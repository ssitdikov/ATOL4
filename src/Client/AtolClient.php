<?php declare(strict_types=1);

namespace SSitdikov\ATOL\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\TokenRequest;
use SSitdikov\ATOL\Response\ResponseInterface;
use SSitdikov\ATOL\Response\TokenResponse;


/**
 * Basic methods for API
 *
 * @method TokenResponse getToken(TokenRequest $request)
 *
 * @package SSitdikov\ATOL\Client
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
class AtolClient
{

    /**
     * Client for HTTP Requests
     *
     * @var Client $httpClient
     */
    private $httpClient;

    /**
     * AtolClient constructor.
     *
     * @param string $version Version of API
     * @param string $url     Url api
     */
    public function __construct(
        string $version = 'v4',
        string $url = 'https://online.atol.ru/possystem/'
    ) {
        $this->httpClient = new Client(
            [
                'base_uri' => $url . $version . '/'
            ]
        );
    }

    /**
     * Call magic method for handling requests
     *
     * @param string $name Method name
     * @param array $arguments Method params
     *
     * @return ResponseInterface
     *
     * @throws \Exception
     */
    public function __call(string $name, array $arguments): ResponseInterface
    {
        /* @var RequestInterface $request */
        $request = array_shift($arguments);
        try {
            $response = $this->httpClient->request(
                $request->getHttpMethod(),
                $request->getUrl(),
                $request->getRequestParams()
            );
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
        } catch (GuzzleException $exception) {
            /* @todo Need add handler for exception */
        }

        if (isset($response)) {
            return $request->getResponse(
                \json_decode(
                    $response->getBody()->getContents(),
                    false
                )
            );
        }
        /* @todo Need change exception to Spl */
        throw new \Exception('Not response?');
    }

    /**
     * Set up external http client
     *
     * @param Client $client
     *
     * @return void
     */
    public function setClient(Client $client): void
    {
        $this->httpClient = $client;
    }

}
