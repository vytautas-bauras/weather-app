<?php

namespace App\Controller;

use App\Exception\ResponseLoggableException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * AbstractAPIController provides helper methods for handling API requests
 * @package App\Controller
 */
abstract class AbstractAPIController extends AbstractController
{
    const DEFAULT_ERROR_MESSAGE = 'An error occurred while processing the request.';

    protected function createErrorResponse($httpCode = 500, $errorMessage = self::DEFAULT_ERROR_MESSAGE)
    {
        return new JsonResponse([
            'error' => $errorMessage
        ], $httpCode);
    }

    protected function createErrorResponseFromLoggableException(ResponseLoggableException $exception)
    {
        return $this->createErrorResponse(
            500,
            self::DEFAULT_ERROR_MESSAGE . ' ' . $exception->getMessage()
        );
    }

    protected function createErrorResponseFromException(\Exception $exception)
    {
        if($exception instanceof ResponseLoggableException) {
            return $this->createErrorResponseFromLoggableException($exception);
        }

        return $this->createErrorResponse();
    }
}