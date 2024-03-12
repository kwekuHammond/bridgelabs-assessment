<?php

namespace App\Http\Controllers;

use App\Http\Actions\DeleteFileAction;
use App\Http\Actions\LoadFilesAction;
use App\Http\Actions\UpdateFileAction;
use App\Http\Actions\UploadFileAction;
use App\Http\Requests\FileUpdateRequest;
use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LoadFilesAction $action): JsonResponse
    {
        return $action->handle($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileUploadRequest $request, UploadFileAction $action): JsonResponse
    {
        return $action->handle($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file): JsonResponse
    {
        return successfulJsonResponse(new FileResource($file));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FileUpdateRequest $request, File $file, UpdateFileAction $action): JsonResponse
    {
        return $action->handle($request, $file);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file, DeleteFileAction $action): JsonResponse
    {
        return $action->handle($file);
    }
}
