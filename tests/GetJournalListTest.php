<?php declare(strict_types=1);

use BaselinkerClient\Client;
use BaselinkerClient\Journal\GetJournalListParameters;
use BaselinkerClient\Journal\GetJournalListResponse;
use BaselinkerClient\Lib\Exceptions\InvalidParameterException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetJournalListTest extends TestCase
{
    /** @var Client */
    private $client;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new Client(
            'http://test/',
            'test'
        );
    }

    public function testCorrectResponse()
    {
        $expectedResponse = [
            'status' => 'SUCCESS',
            'logs' => [
                [
                    'id' => 1,
                    'order_id' => 2,
                    'log_type' => 3
                ],
                [
                    'id' => 2,
                    'order_id' => 3,
                    'log_type' => 4
                ]
            ]
        ];

        $responses = [
            new MockResponse(json_encode($expectedResponse)),
        ];

        $this->client->setClient(
            new MockHttpClient($responses)
        );

        $params = new GetJournalListParameters(
            1,
            [1, 2]
        );

        $result = $this->client->getJournalList($params);

        $this->assertEquals(
            $expectedResponse,
            $result->getData()
        );

        $this->assertEquals(
            $expectedResponse['logs'],
            $result->getLogs()
        );
    }

    public function testDecodingErrorResponse()
    {
        $responses = [
            new MockResponse(['test']),
        ];

        $this->client->setClient(
            new MockHttpClient($responses)
        );

        $params = new GetJournalListParameters(
            1,
            [1, 2]
        );

        $result = $this->client->getJournalList($params);

        $this->assertTrue(
            $result->checkError()
        );

        $this->assertEquals(
            [
                'status' => 'ERROR',
                'error_code' => 'DECODING_EXCEPTION',
                'error_message' => 'Syntax error for "http://test/".',
            ],
            $result->getData()
        );
    }

    public function testParamsToRequest()
    {
        $params = new GetJournalListParameters(
            1,
            [1, 2],
            1
        );

        $params->validate();
        $requestData = $params->toRequest();

        $this->assertEquals(
            [
                'last_login_id' => 1,
                'logs_types' => [1, 2],
                'order_id' => 1
            ],
            $requestData
        );
    }

    public function testValidationException()
    {
        $params = new GetJournalListParameters(
            null,
            [1, 2]
        );

        $this->expectException(InvalidParameterException::class);
        $params->validate();
    }

    public function testResponseGeneration()
    {
        $response = new GetJournalListResponse(
            [
                'status' => 'SUCCESS',
                'error_code' => 'TEST_ERROR',
                'error_message' => 'test'
            ]
        );

        $this->assertFalse(
            $response->checkError()
        );

        $this->assertEquals(
            [
                'status' => 'SUCCESS',
                'error_code' => 'TEST_ERROR',
                'error_message' => 'test'
            ],
            $response->getData()
        );
    }

    public function testResponseErrorValidation()
    {
        $response = new GetJournalListResponse(
            [
                'status' => 'ERROR',
                'error_code' => 'TEST_ERROR',
                'error_message' => 'test'
            ]
        );

        $this->assertTrue(
            $response->checkError()
        );

        $this->assertEquals(
            [
                'status' => 'ERROR',
                'error_code' => 'TEST_ERROR',
                'error_message' => 'test'
            ],
            $response->getErrorMessage()
        );

        $this->assertEquals(
            [
                'status' => 'ERROR',
                'error_message' => 'test',
                'error_code' => 'TEST_ERROR',
            ],
            $response->getErrorMessage()
        );
    }
}
