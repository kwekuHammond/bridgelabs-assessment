<?php

namespace App\Http\Actions;

use App\Http\Requests\FileUpdateRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateFileAction
{
    public function handle(FileUpdateRequest $request, File $file): JsonResponse
    {
        logger()->info('### UPDATING FILE ###');
        $payload = $request->validated();

        try {

            if (empty($payload))
                return successfulJsonResponse(new FileResource($file->refresh()));

            $dataForUpdate = $this->dataForUpdate($request);

            if (!empty($dataForUpdate)) {
                if (Storage::disk('local')->exists($file->path)) {
                    Storage::disk('local')->delete($file->path);
                }
                $file->update($dataForUpdate);
            }

            logger()->info('### FILE UPDATED ###');

            return successfulJsonResponse(new FileResource($file->refresh()));

        } catch (Exception $exception) {
            report($exception);
        }
        return errorJsonResponse();
    }

    private function dataForUpdate(FileUpdateRequest $request): array
    {
        $data = [];
        $payload = $request->validated();

        if ($request->has('file')) {

            $file = $request->validated('file');
            $filePath = $file->store(storagePath($payload['fileType']));

            $data = [
                'name' => $file->getClientOriginalName(),
                'description' => $payload['description'],
                'type' => $payload['fileType'],
                'mime' => $file->getClientMimeType(),
                'path' => $filePath,
                'url' => env('APP_URL') . Storage::disk('local')->url($filePath)
            ];
        }

        if ($request->filled('description')) {
            $data = [
                ...$data,
                'description' => $payload['description']
            ];
        }
        return $data;

    }
}
