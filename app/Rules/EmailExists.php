<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;


class EmailExists implements Rule
{
    protected $role;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //Validate email for role- Student
        if($this->role == 'Student')
        {
             $savedStudentEmails = DB::table('EmailIdRole')->where('role','Student')->pluck('email');
             foreach ($savedStudentEmails as $email) {
             if($email == strtolower($value))
             {
                return 1;
             }
         }
         return 0;

        }
        
        //Validate email for role- Instructor
        if($this->role == 'Instructor')
        {
            $savedInstrumentEmails = DB::table('EmailIdRole')->where('role','Instructor')->pluck('email');
             foreach ($savedInstrumentEmails as $email) {
             if($email == strtolower($value))
             {
                return 1;
             }
         }
         return 0;
            
        }    
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You cannot register with this email address. Please contact the Administrator for further steps.';
    }
}
