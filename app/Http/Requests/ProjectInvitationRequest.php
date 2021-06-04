<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class ProjectInvitationRequest extends FormRequest
{
    protected $errorBag = 'invitation';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('manage', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email:filter',
                'exists:users,email',
                function ($attribute, $value, $fail) {
                    $invitee = User::whereEmail($this->email)->first();
                    if ($this->route('project')->members->contains($invitee)) {
                        $fail('This user is already a member of this project');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'The user you are inviting must have an account',
        ];
    }
}
