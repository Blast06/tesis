<?php

namespace App\Traits;

trait ResponseHelpers
{
    public function responseOne($data, $status = 200)
    {
        return response()->json(['data' => $data], $status);
    }

    public function responseMessage($data, $status = 200)
    {
        return response()->json(['message' => $data], $status);
    }
}