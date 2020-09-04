<?php


namespace ApiV1;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class PagedResponse
{
    public static function output(LengthAwarePaginator $collection, array $additional_meta = [])
    {
        $meta = [
            "showing" => $collection->count(),
            "total" => $collection->total(),
            "current_page" => $collection->currentPage(),
            'last_page' => $collection->lastPage(),
            "next_page_url" => $collection->nextPageUrl()
        ];

        if( !empty($additional_meta) )
        {
            $meta = array_merge($meta, $additional_meta);
        }

        return response()->json(
            [
                "meta" => $meta,
                "data" => $collection->items(),
            ],
            JsonResponse::HTTP_OK
        );
    }
}
