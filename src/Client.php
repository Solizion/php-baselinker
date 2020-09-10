<?php

namespace BaselinkerClient;

use BaselinkerClient\Journal\GetJournalListParameters;
use BaselinkerClient\Journal\GetJournalListResponse;
use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    /** @var string */
    private $url = '';

    /** @var string */
    private $apiKey;

    /** @var HttpClientInterface */
    private $client;

    public function __construct(string $url, string $apiKey)
    {
        $this->url = $url;
        $this->apiKey = $apiKey;
        $this->client = HttpClient::create();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function getJournalList(GetJournalListParameters $parameters): GetJournalListResponse
    {
        $parameters->validate();
        $paramData = $parameters->toRequest();

        return new GetJournalListResponse(
            $this->doRequest($paramData, 'getJournalList')
        );
    }

    public function setClient(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function doRequest(array $paramData, string $method): array
    {
        $request = $this->client->request(
            'POST',
            $this->url,
            [
                'body' => [
                    'token' => $this->apiKey,
                    'method' => $method,
                    'parameters' => json_encode($paramData),
                ],
            ]
        );

        try {
            return $request->toArray();
        } catch (ClientExceptionInterface $e) {
            return $this->generateErrorResponse('CLIENT_EXCEPTION', $e->getMessage());
        } catch (DecodingExceptionInterface $e) {
            return $this->generateErrorResponse('DECODING_EXCEPTION', $e->getMessage());
        } catch (RedirectionExceptionInterface $e) {
            return $this->generateErrorResponse('REDIRECTION_EXCEPTION', $e->getMessage());
        } catch (ServerExceptionInterface $e) {
            return $this->generateErrorResponse('SERVER_EXCEPTION', $e->getMessage());
        } catch (TransportExceptionInterface $e) {
            return $this->generateErrorResponse('TRANSPORT_EXCEPTION', $e->getMessage());
        }
    }

    protected function generateErrorResponse(string $code, string $message): array
    {
        return [
            'status' => 'ERROR',
            'error_code' => $code,
            'error_message' => $message,
        ];
    }
}
