<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

trait ResponseHelpers
{
    protected function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message,$code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json(['error' => $message], $code);
    }

    protected function showAll(Collection $collection, $code = Response::HTTP_OK)
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $instance, $code = Response::HTTP_OK)
    {
        return $this->successResponse(['data' => $instance], $code);
    }
}