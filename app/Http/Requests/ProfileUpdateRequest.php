<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

# =====================================================================
# PROFILE UPDATE REQUEST - Profile Validation Form Request
# =====================================================================
# Custom FormRequest for profile update validation
# Validates name and email with unique constraint
# Prevents duplicate emails while allowing user to keep current email
#
# Methods:
# - rules() - Validation rules for profile form
#
# Validation Rules:
# - name: required, string, max 255
# - email: required, unique (ignoring current user's email)
#
# Features:
# - Unique email validation with ignore for current user
# - Rule::unique() with ignore() prevents duplicate email errors
# - Allows user to keep same email on update
# - Email must be unique across all other users
#
# Usage:
# - Type hint in controller method to auto-validate
# - Validated data available via $request->validated()
#
# Security:
# - Database-level email uniqueness enforced
# - Prevents duplicate email registration
# - Allows user to update other fields without changing email

class ProfileUpdateRequest extends FormRequest
{
    # =========== AUTHORIZATION CHECK ===========
    # Determine if user authorized to make profile update
    # 
    # Note: Laravel handles authorization implicitly
    # Only authenticated users can access profile update routes
    #
    # Returns: bool - implicitly checked by route middleware
    
    # =========== VALIDATION RULES ===========
    # Validation rules for profile update form
    #
    # Rules:
    # - name: required, string, max 255 characters
    # - email: required, unique email (ignoring current user)
    #          Rule::unique() prevents duplicate emails across system
    #          ignore($this->user()->id) allows keeping same email
    #
    # Workflow:
    # 1. Check name is provided and valid string
    # 2. Check email is provided and valid email format
    # 3. Check email is unique in users table
    # 4. Ignore current user's ID so they can keep same email
    # 5. If different email provided, check it's not taken by others
    #
    # Returns: array of validation rules
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            # Name must be provided and valid string
            'name' => ['required', 'string', 'max:255'],
            
            # Email validation with unique constraint
            'email' => [
                'required',
                'string',
                'lowercase',              # Convert to lowercase for storage
                'email',                  # Valid email format
                'max:255',                # Database column length
                Rule::unique(User::class) # Unique in users table
                    ->ignore($this->user()->id), # Except current user
            ],
        ];
    }
}
