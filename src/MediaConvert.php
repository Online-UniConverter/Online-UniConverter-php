<?php

namespace MediaConvert;

use MediaConvert\Hydrator\HydratorInterface;
use MediaConvert\Hydrator\JsonMapperHydrator;
use MediaConvert\Resources\ExportsResource;
use MediaConvert\Resources\ImportsResource;
use MediaConvert\Resources\TasksResource;
use MediaConvert\Resources\UsersResource;
use MediaConvert\Transport\HttpTransport;
use Http\Client\HttpClient;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaConvert
{
    const VERSION = '2.0.0';

    /**
     * @var array
     */
    protected $options;

    /**
     * @var HttpClient
     */
    protected $httpTransport;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * Api constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('apiKey');
        $resolver->setAllowedTypes('apiKey', 'string');

        $resolver->setDefined('http_client');
        $resolver->setAllowedTypes('http_client', [HttpClient::class, ClientInterface::class]);
    }

    /**
     * @return HttpTransport
     */
    public function getHttpTransport(): HttpTransport
    {
        if ($this->httpTransport === null) {
            $this->httpTransport = new HttpTransport($this->options);
        }

        return $this->httpTransport;
    }

    /**
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface
    {
        if ($this->hydrator === null) {
            $this->hydrator = new JsonMapperHydrator();
        }
        return $this->hydrator;
    }

    /**
     * @return UsersResource
     */
    public function users(): UsersResource
    {
        return new UsersResource($this->getHttpTransport(), $this->getHydrator());
    }

    /**
     * @return TasksResource
     */
    public function tasks(): TasksResource
    {
        return new TasksResource($this->getHttpTransport(), $this->getHydrator());
    }

    /**
     * @return ImportsResource
     */
    public function imports(): ImportsResource
    {
        return new ImportsResource($this->getHttpTransport(), $this->getHydrator());
    }

    /**
     * @return ExportsResource
     */
    public function exports(): ExportsResource
    {
        return new ExportsResource($this->getHttpTransport(), $this->getHydrator());
    }
}
