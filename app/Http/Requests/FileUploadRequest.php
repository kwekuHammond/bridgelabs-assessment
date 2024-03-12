<?php

namespace App\Http\Requests;

use App\custom\FileType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FileUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fileType' => ['required', 'string', Rule::in(FileType::VALID_TYPES)],
            'description' => ['sometimes', 'nullable'],
            'file' => [
                'required',
                'file',
                 Rule::when(function(){return $this->fileType === FileType::IMAGE;}, ['mimes:png,jpeg,jpg,bmp', 'max:4096']),
                 Rule::when(function(){return $this->fileType === FileType::VIDEO;}, ['mimes:mp4,mkv,mpeg', 'max:8192']),
                 Rule::when(function(){return $this->fileType === FileType::DOCUMENT;}, ['mimes:docx,pdf,xlsx,ppt', 'max:4096']),
                 Rule::when(function(){return $this->fileType === FileType::AUDIO;}, ['mimes:mp3,wav,aac, mp4, x-wav, webm', 'max:4096']),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'fileType.in' => ':attribute must be either of the following: ' . implode(',', FileType::VALID_TYPES)
        ];
    }
}
