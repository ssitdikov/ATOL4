<?php declare(strict_types=1);

namespace SSitdikov\ATOL\Response;

/**
 * Class TokenResponse
 *
 * @package SSitdikov\ATOL\Response
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
class TokenResponse implements ResponseInterface
{

    /**
     * Token for next requests
     *
     * @var string $token
     */
    private $token;

    /**
     * Date time of answer
     *
     * @var \DateTime $timestamp
     */
    private $timestamp;

    /**
     * TokenResponse constructor.
     *
     * @param \stdClass $response Result of TokenRequest
     */
    public function __construct(\stdClass $response)
    {
        $this->token = $response->token;
        $this->timestamp = new \DateTime($response->timestamp);
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

}
