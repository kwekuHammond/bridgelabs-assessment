<?php

use App\custom\FileType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

function successfulJsonResponse(mixed $data = [], string $message = 'Request processed successfully', $statusCode = 200): JsonResponse
{
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $data
    ], $statusCode);
}

function errorJsonResponse(array $errors = [], string $message = 'Something went wrong, please try again later', $statusCode = 500): JsonResponse
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'errors' => $errors
    ], $statusCode);
}

function paginatedSuccessfulJsonResponse($data = [], int $statusCode = 200): JsonResponse
{
    $responseData = $data->response()->getData();
    $metaData = $responseData->meta;
    $linksData = $responseData->links;

    return response()->json([
        'success' => true,
        'data' => $data,
        'meta' => [
            'first' => $linksData->first,
            'last' => $linksData->last,
            'prev' => $linksData->prev,
            'next' => $linksData->next,
            'currentPage' => $metaData->current_page,
            'perPage' => $metaData->per_page,
            'total' => $metaData->total,
            'links' => $metaData->links,
        ]
    ], $statusCode);
}

function generateFileName(string $fileType): string
{
    return match ($fileType) {
        FileType::DOCUMENT => uniqid('DOC'),
        FileType::VIDEO => uniqid('VID'),
        FileType::IMAGE => uniqid('IMG'),
        default => uniqid(),
    };
}

function storagePath(string $fileType): string
{
    return 'public/uploads/' . $fileType;
}

function arrayKeyToSnakeCase(array $data): array
{
    $newData = [];
    foreach ($data as $key => $datum) {
        $newData[Str::snake($key)] = $datum;
    }
    return $newData;
}
