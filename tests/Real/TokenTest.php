<?php declare(strict_types=1);

namespace SSitdikov\ATOL\Tests\Real;

use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Client\AtolClient;
use SSitdikov\ATOL\Request\TokenRequest;
use SSitdikov\ATOL\Response\TokenResponse;

/**
 * Class TokenTest
 *
 * @package SSitdikov\ATOL\Tests\Real
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
class TokenTest extends TestCase
{

    /**
     * Get auth data from file
     *
     * @see https://online.atol.ru/files/ffd/test_sreda.txt
     *
     * @return void
     */
    public function testRealAuth(): void
    {
        $client = new AtolClient('v4', 'https://testonline.atol.ru/possystem/');
        $success_token_request = new TokenRequest('v4-online-atol-ru', 'iGFFuihss');
        $response = $client->getToken($success_token_request);

        self::assertEquals(get_class($response), TokenResponse::class);
        self::assertNotEmpty($response->getToken());
        self::assertNotEmpty($response->getTimestamp());

        $fail_token_request = new TokenRequest('login', 'password');
        $this->expectException(\Exception::class);
        $client->getToken($fail_token_request);
    }
}
