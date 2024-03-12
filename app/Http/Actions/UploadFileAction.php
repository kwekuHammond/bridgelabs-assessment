<?php

namespace App\Http\Actions;

use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadFileAction
{
    public function handle(FileUploadRequest $request): JsonResponse
    {
        logger()->info('### FILE UPLOAD INITIATED ###');
        logger($request->except('file'));
        try {
            $payload = $request->validated();
            $file = $request->validated('file');

            $filePath = $file->store(storagePath($payload['fileType']));

            $storedFile = File::create([
                'name' => $file->getClientOriginalName(),
                'description' => $payload['description'],
                'type' => $payload['fileType'],
                'mime' => $file->getClientMimeType(),
                'path' => $filePath,
                'url' => env('APP_URL') . Storage::disk('local')->url($filePath)
            ]);

            return successfulJsonResponse(new FileResource($storedFile), statusCode: Response::HTTP_CREATED);

        } catch (Exception $exception) {
            report($exception);
        }
        return errorJsonResponse();
    }
}
