<?php

namespace App\Http\Actions;

use App\Http\Resources\FileResource;
use App\Models\File;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoadFilesAction
{
    public function handle(Request $request): JsonResponse
    {
        logger()->info('### LOADING FILES ###');
        try {

            return paginatedSuccessfulJsonResponse(
                FileResource::collection(
                    File::query()->paginate($request->perPage ?? 10)
                )
            );

        } catch (Exception $exception) {
            report($exception);
        }
        return errorJsonResponse();
    }
}
