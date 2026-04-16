<?php

namespace Src\Http\Response;

final class ResponsePayload
{
    public static function success(array $data, string $message = ''): array
    {
        return [
            'type' => 'success',
            'message' => $message,
            'data' => $data
        ];
    }

    public static function error(string $message): array
    {
        return [
            'type' => 'error',
            'message' => $message,
        ];
    }
}