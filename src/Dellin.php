<?php

declare(strict_types=1);

namespace mrssoft\dellin;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as PsrUtils;
use GuzzleHttp\Utils;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Dellin
{
    public string $apiUrl = 'https://api.dellin.ru/v2/';

    private string $appKey;

    private ClientInterface $httpClient;

    public function __construct(string $appKey, ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->appKey = $appKey;
    }

    public function calculate(CalculateRequest $request): CaluculateResponse
    {
        try {
            $httpRequest = $this->buildHttpRequest('POST', 'calculator.json', $request);
            $response = $this->httpClient->send($httpRequest);
            $rawResponse = $this->getResponseContent($response);
            return new CaluculateResponse($rawResponse);
        } catch (ClientException|ServerException $e) {
            $message = $this->getErrorContent($e);
            throw new RequestException($message, $e->getCode());
        }
    }

    private function buildHttpRequest(string $method, string $path, Arrayable $payload): RequestInterface|MessageInterface
    {
        $payload = $payload->toArray();
        $payload['appkey'] = $this->appKey;

        $request = new Request($method, $this->apiUrl . $path, [
            'Accept' => 'application/json;charset=UTF-8'
        ]);

        if ($payload === null) {
            return $request;
        }

        if ($method === 'GET') {
            return PsrUtils::modifyRequest($request, [
                'query' => Query::build($payload)
            ]);
        }

        return $request->withHeader('Content-Type', 'application/json;charset=UTF-8')
                       ->withBody(PsrUtils::streamFor(Utils::jsonEncode($payload)));
    }

    private function getResponseContent(ResponseInterface $response): array
    {
        return Utils::jsonDecode((string)$response->getBody(), true);
    }

    private function getErrorContent(ClientException $exception): string
    {
        $content = $this->getResponseContent($exception->getResponse());

        $message = '';
        if (isset($content['errors'])) {
            if (is_array($content['errors'])) {
                foreach ($content['errors'] as $error) {
                    $message = (is_array($error['fields'])) ? implode(' ', $error['fields']) . ' ' : $error['fields'] . ' ';
                    $message .= (isset($error['detail'])) ? $error['detail'] . ' ' : '';
                    $message .= (isset($error['title'])) ? $error['title'] . '. ' : '';
                }
            } else {
                return print_r($content, true);
            }
        }

        return $message;
    }
}