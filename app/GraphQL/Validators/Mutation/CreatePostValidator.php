<?php

namespace App\GraphQL\Validators\Mutation;

use Nuwave\Lighthouse\Validation\Validator;

class CreatePostValidator extends Validator
{
    public function rules(): array
    {
        return [
            'input.body' => ['required', 'string', 'min:20', 'max:280'],
        ];
    }

    public function messages(): array
    {
        return [
            'input.body.min'      => 'A post needs to be at least 20 characters long.',
            'input.body.max'      => 'A post cannot exceed 280 characters.',
            'input.body.required' => 'Post body cannot be empty.',
        ];
    }
}
