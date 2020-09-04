<?php


namespace ApiV1;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ErrorResponse
{
    public static function output(
        string $error_message,
        $error_code,
        string $human_formatted_message,
        $code = JsonResponse::HTTP_NOT_FOUND
    ) :JsonResponse
    {
        Log::error(
            $error_message,
            ['code' => $error_code]
        );

        return response()->json(
            [
                'error' => $human_formatted_message
            ],
            $code
        );
    }
}
