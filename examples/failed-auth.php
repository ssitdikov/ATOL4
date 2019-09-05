<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use SSitdikov\ATOL\Client\AtolClient;
use SSitdikov\ATOL\Exception\IncomingOperationNotSupported;
use SSitdikov\ATOL\Exception\WrongLoginOrPasswordException;
use SSitdikov\ATOL\Request\TokenRequest;

/**
 * @see https://online.atol.ru/files/ffd/test_sreda.txt
 */
$client = new AtolClient('v4', 'https://testonline.atol.ru/possystem/');
$token_request = new TokenRequest('', 'iGFFuihss');
//$token_request = new TokenRequest('v4-online-atol-ru', 'iGFFuihss');

try {
    $token = $client->getToken($token_request);
} catch (WrongLoginOrPasswordException $exception) {
    // неверный пароль
} catch (IncomingOperationNotSupported $exception) {
    // неверные параметры
}