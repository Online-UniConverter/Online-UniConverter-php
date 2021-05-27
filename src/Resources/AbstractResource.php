<?php

namespace OnlineUniConverter\Resources;

use OnlineUniConverter\Hydrator\HydratorInterface;
use OnlineUniConverter\Transport\HttpTransport;

abstract class AbstractResource
{
    /**
     * @var HttpTransport
     */
    protected $httpTransport;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * AbstractResource constructor.
     *
     * @param HttpTransport     $httpTransport
     * @param HydratorInterface $hydrator
     */
    public function __construct(HttpTransport $httpTransport, HydratorInterface $hydrator)
    {
        $this->httpTransport = $httpTransport;
        $this->hydrator = $hydrator;
    }
}
