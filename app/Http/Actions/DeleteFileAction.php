<?php

namespace App\Http\Actions;

use App\Models\File;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteFileAction
{
    public function handle(File $file): JsonResponse
    {
        logger()->info('### DELETING FILE ###');
        try {

            DB::beginTransaction();

            $file->delete();

            if (Storage::disk('local')->exists($file->path)) {
                Storage::disk('local')->delete($file->path);
            }

            Db::commit();
            
            logger()->info('### FILE DELETED ###');

            return successfulJsonResponse(statusCode: Response::HTTP_NO_CONTENT);

        } catch (Exception $exception) {
            DB::rollBack();
            report($exception);
        }
        return errorJsonResponse();
    }
}
