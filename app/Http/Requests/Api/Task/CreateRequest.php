<?php

namespace App\Http\Requests\Api\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'status' => [
                'required',
                Rule::in(Task::STATUSES),
            ],
            'board_id' => [
                'required',
                'int',
                Rule::exists('boards', 'id')->where(
                    function($query) {
                        $query->where('user_id', '=', Auth::user()->id);
                    }),
            ],
        ];
    }
}
