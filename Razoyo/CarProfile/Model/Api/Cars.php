<?php
declare(strict_types=1);

namespace Razoyo\CarProfile\Model\Api;

use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;
use Psr\Log\LoggerInterface;

class Cars
{
    private const API_TOKEN_FIELD_NAME = 'your-token';
    private const API_BASE_URL = 'https://exam.razoyo.com/api/';
    private const API_CARS_ENDPOINT = 'cars/';
    private const TOKEN = 'token';

    /**
     * @param SessionManagerInterface $session
     * @param LoggerInterface $logger
     * @param ClientFactory $clientFactory
     */
    public function __construct(
        private SessionManagerInterface $session,
        private LoggerInterface $logger,
        private ClientFactory $clientFactory
    ) {
    }

    /**
     * @param string $carId
     * @return array
     * @throws LocalizedException
     */
    public function getCarById(string $carId): array
    {
        $endPoint = self::API_BASE_URL . self::API_CARS_ENDPOINT . $carId;
        $token = $this->session->getData(self::TOKEN);
        $response = $this->fetchApiData($endPoint, $token);
        $responseBody = $response->getBody()->getContents();
        return Utils::jsonDecode($responseBody, true)['car'];
    }

    /**
     * Get car list from API
     *
     * @return array
     * @throws LocalizedException
     */
    public function getCarList(): array
    {
        $endPoint = self::API_BASE_URL . self::API_CARS_ENDPOINT;
        $response = $this->fetchApiData($endPoint);
        $token = $response->getHeader(self::API_TOKEN_FIELD_NAME)[0];
        $this->session->setData(self::TOKEN, $token);
        $responseBody = $response->getBody()->getContents();

        return Utils::jsonDecode($responseBody, true)['cars'];
    }


    /**
     * API request with provided params
     *
     * @param string $endPoint
     * @param string $token
     * @return ResponseInterface
     * @throws LocalizedException
     */
    private function fetchApiData(string $endPoint, string $token = ""): ResponseInterface
    {
        /** @var Client $client */
        $client = $this->clientFactory->create();
        $headers = $this->getHeaders();

        if ($token) {
            $headers["Authorization"] = "Bearer " . $token;
        }

        try {
            $response = $client->request(
                'GET',
                $endPoint,
                [
                    'headers' => $headers,
                ]
            );
        } catch (GuzzleException $exception) {
            $this->logger->error($exception->getMessage());
            if ($exception->getCode() === 401 || $exception->getCode() === 403) {
                throw new LocalizedException(__('You are not authorized to access this resource. Try again'));
            } else {
                throw new LocalizedException(__('An error occurred while processing your request.'));
            }
        }

        return $response;
    }

    /**
     * @return string[]
     */
    private function getHeaders(): array
    {
        return [
            "Content-Type" => "application/json",
        ];
    }
}
