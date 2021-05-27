<?php

namespace OnlineUniConverter\Exceptions;

class HttpServerException extends Exception
{
    /**
     * @param int $httpStatus
     *
     * @return HttpServerException
     */
    public static function serverError(int $httpStatus = 500)
    {
        return new self('An unexpected error occurred at OnlineUniConverter\'s servers. Try again later.',
            $httpStatus);
    }

    /**
     * @param \Throwable $previous
     *
     * @return HttpServerException
     */
    public static function networkError(\Throwable $previous)
    {
        return new self('OnlineUniConverter\'s servers are currently unreachable.', 0, $previous);
    }

    /**
     * @param int $code
     *
     * @return HttpServerException
     */
    public static function unknownHttpResponseCode(int $code)
    {
        return new self(sprintf('Unknown HTTP response code ("%d") received from the API server', $code));
    }
}
