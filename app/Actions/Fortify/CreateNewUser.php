<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'company_email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => isset($input['name']) ? $input['name'] : null,
            'email' => isset($input['email']) ? $input['email'] : null,
            'password' => Hash::make($input['password']),
            'role' => $input['role'],
            'selected_company' => isset($input['selected_company']) ? $input['selected_company'] : null,
//            'company_name' => isset($input['company_name']) ? $input['company_name'] : null,
//            'company_email' => isset($input['company_email']) ? $input['company_email'] : null,
            'eid' => isset($input['eid']) ? $input['eid'] : null,
            'nic' => isset($input['nic']) ? $input['nic'] : null,
            'career_role' => isset($input['career_role']) ? $input['career_role'] : null,
            // if the role is 1, then the user is approved or else not approved
            'approved' => $input['role'] == 1 ? true : false,

        ]);
    }
}
