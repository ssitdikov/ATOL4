<?php declare(strict_types=1);

namespace SSitdikov\ATOL\Tests\Basic;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Client\AtolClient;
use SSitdikov\ATOL\Request\TokenRequest;
use SSitdikov\ATOL\Response\TokenResponse;

/**
 * Class Auth
 *
 * @package SSitdikov\ATOL\Tests\Basic
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
class TokenTest extends TestCase
{

    /**
     * Default client for API
     *
     * @var AtolClient $atolClient
     */
    private $atolClient;

    /**
     * Set up default params
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->atolClient = $this->getMockBuilder(AtolClient::class)
            ->addMethods(['getToken'])->getMock();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * Basic test for checking type hinting
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testMakeRequest(): void
    {
        $generated_token = md5(random_bytes(2));
        $timestamp = new \DateTime();
        $response = \json_decode(
            '{
                    "token": "' . $generated_token . '",
                    "timestamp":"' . $timestamp->format('j.m.Y H:i:s') . '"
                    }',
            false
        );
        $token_request = new TokenRequest('', '');
        self::assertEquals(
            $token_request->getResponse($response),
            new TokenResponse($response)
        );
    }

    /**
     * Basic auth example
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testGetToken(): void
    {
        $generated_token = md5(random_bytes(6));
        $timestamp = new \DateTime();
        $http_response = \json_decode(
            '{
                    "token": "' . $generated_token . '",
                    "timestamp":"' . $timestamp->format('j.m.Y H:i:s') . '"
                    }',
            false
        );
        $response = new TokenResponse(
            $http_response
        );
        $this->atolClient->expects(self::once())
            ->method('getToken')->willReturn($response);

        $login = md5(random_bytes(6));
        $pass = md5(random_bytes(6));
        $token_request = new TokenRequest($login, $pass);
        $token = $this->atolClient->getToken(
            $token_request
        );
        self::assertEquals(
            $token_request::METHOD_POST,
            $token_request->getHttpMethod()
        );
        self::assertEquals(
            [
                'json' => [
                    'login' => $login,
                    'pass' => $pass
                ]
            ],
            $token_request->getRequestParams()
        );
        self::assertEquals('getToken', $token_request->getUrl());
        self::assertEquals($generated_token, $token->getToken());
        self::assertEquals(
            $timestamp->getTimestamp(),
            $token->getTimestamp()->getTimestamp()
        );
    }

    /**
     * Handle exceptions
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testGetTokenException(): void
    {
        $response_message = '{"error":
                        {"error_id":"", "code":12,"text":"message","type":"system"}
                    }';
        $response = new BadResponseException(
            $response_message,
            new Request('getToken', ''),
            new Response(403, [], $response_message)
        );
        $login = md5(random_bytes(6));
        $pass = md5(random_bytes(6));
        $token_request = new TokenRequest($login, $pass);

        $http_client = $this->getMockBuilder(Client::class)->getMock();
        $atol_client = new AtolClient();
        $http_client->expects(self::once())
            ->method('request')->willThrowException($response);
        $atol_client->setClient($http_client);

        $this->expectException(\Exception::class);
        $atol_client->getToken($token_request);
    }

}
