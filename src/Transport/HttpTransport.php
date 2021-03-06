<?php

namespace OnlineUniConverter\Transport;

use OnlineUniConverter\OnlineUniConverter;
use OnlineUniConverter\Exceptions\HttpClientException;
use OnlineUniConverter\Exceptions\HttpServerException;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\MessageFactory;
use Http\Message\StreamFactory;
use Http\Message\UriFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class HttpTransport
{
    protected $options;
    protected $httpClient;
    protected $messageFactory;

    /**
     * HttpTransport constructor.
     *
     * @param $options
     */
    public function __construct($options)
    {
        $this->options = $options;
        $this->httpClient = $this->createHttpClientInstance();
    }

    /**
     * Creates a new instance of the HTTP client.
     *
     * @return HttpClient
     */
    protected function createHttpClientInstance(): HttpClient
    {
        $httpClient = $this->options['http_client'] ?? Psr18ClientDiscovery::find();
        $httpClientPlugins = [
            new HeaderDefaultsPlugin([
                'User-Agent' => 'OnlineUniConverter-php/v' . OnlineUniConverter::VERSION . ' (https://github.com/OnlineUniConverter/OnlineUniConverter-php)',
            ]),
            new RedirectPlugin()
        ];

        return new PluginClient($httpClient, $httpClientPlugins);
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->options['apiHost'] ?? 'https://api.media.io/v2';
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @return MessageFactory
     */
    public function getMessageFactory(): MessageFactory
    {
        return $this->options['message_factory'] ?? MessageFactoryDiscovery::find();
    }

    /**
     * @return UriFactory
     */
    public function getUriFactory(): UriFactory
    {
        return $this->options['uri_factory'] ?? UriFactoryDiscovery::find();
    }

    /**
     * @return StreamFactory
     */
    public function getStreamFactory(): StreamFactory
    {
        return $this->options['stream_factory'] ?? StreamFactoryDiscovery::find();
    }

    /**
     * @param       $path
     * @param array $query
     *
     * @return ResponseInterface
     * @throws \OnlineUniConverter\Exceptions\Exception
     */
    public function get(string $path, array $query = []): ResponseInterface
    {
        if (count($query) > 0) {
            $path .= '?' . http_build_query($query);
        }

        return $this->sendRequest($this->getMessageFactory()->createRequest('GET', $path, [
            'accept-encoding' => 'application/json'
        ]));
    }

    /**
     * @param string $url
     *
     * @return StreamInterface
     */
    public function download(string $url)
    {
        return $this->sendRequest($this->getMessageFactory()->createRequest('GET', $url), false)->getBody();
    }

    /**
     * @param $path
     * @param $body
     *
     * @return ResponseInterface
     */
    public function post(string $path, array $body): ResponseInterface
    {
        return $this->sendRequest($this->getMessageFactory()->createRequest('POST', $path, [
            'content-type' => 'application/json',
            'accept-encoding' => 'application/json'
        ], json_encode($body)));
    }

    /**
     * @param $path
     * @param $body
     *
     * @return ResponseInterface
     */
    public function put(string $path, array $body): ResponseInterface
    {
        return $this->sendRequest($this->getMessageFactory()->createRequest('PUT', $path, [
            'content-type' => 'application/json',
            'accept-encoding' => 'application/json'
        ], json_encode($body)));
    }

    /**
     * @param $path
     *
     * @return ResponseInterface
     */
    public function delete(string $path): ResponseInterface
    {
        return $this->sendRequest($this->getMessageFactory()->createRequest('DELETE', $path, [
            'accept-encoding' => 'application/json'
        ]));
    }

    /**
     * @param $path
     * @param string|resource|StreamInterface $file
     * @param array $additionalParameters
     *
     * @return ResponseInterface
     */
    public function upload($path, $file, array $additionalParameters = []): ResponseInterface
    {
        $builder = new MultipartStreamBuilder($this->getStreamFactory());
        foreach ($additionalParameters as $parameter => $value) {
            $builder->addResource($parameter, strval($value));
        }

        // file
        $builder->addResource('file', $file, ['filename' => $additionalParameters['name']]);

        // start time
        $builder->addResource('x:timestamp', time());

        $multipartStream = $builder->build();
        $boundary = $builder->getBoundary();

        $request = $this->getMessageFactory()->createRequest(
            'POST',
            $path,
            ['Content-Type' => 'multipart/form-data; boundary=' . $boundary],
            $multipartStream
        );

        return $this->sendRequest($request, false);
    }

    /**
     * @param RequestInterface $request
     *
     * @param bool $authenticate
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    protected function sendRequest(RequestInterface $request, $authenticate = true)
    {
        try {
            if ($authenticate) {
                $request = $request->withHeader('Authorization', 'Bearer ' . $this->options['apiKey']);
            }
            $response = $this->getHttpClient()->sendRequest($request);
        } catch (\Http\Client\Exception $exception) {
            throw HttpServerException::networkError($exception);
        }

        if (!in_array($response->getStatusCode(), [200, 201, 204])) {
            $this->handleErrors($response);
        }

        return $response;
    }

    /**
     * Throw the correct exception for this error.
     *
     * @throws \OnlineUniConverter\Exceptions\Exception
     */
    protected function handleErrors(ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();
        switch ($statusCode) {
            case 400:
                throw HttpClientException::badRequest($response);
            case 401:
                throw HttpClientException::unauthorized($response);
            case 402:
                throw HttpClientException::paymentRequired($response);
            case 403:
                throw HttpClientException::forbidden($response);
            case 404:
                throw HttpClientException::notFound($response);
            case 422:
                throw HttpClientException::unprocessable($response);
            case 500 <= $statusCode:
                throw HttpServerException::serverError($statusCode);
            default:
                throw HttpServerException::unknownHttpResponseCode($statusCode);
        }
    }
}
