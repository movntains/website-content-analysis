<?php

declare(strict_types=1);

namespace App\Http\Requests\Scan;

use Illuminate\Foundation\Http\FormRequest;

class StoreScanRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'url' => ['required', 'url'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'url.required' => 'You must provide a URL to scan.',
            'url.url' => 'The URL must be a valid URL.',
        ];
    }
}
