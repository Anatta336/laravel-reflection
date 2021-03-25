<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    protected array $foundInvalid;
    protected bool $hasGap;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->foundInvalid = [];
        $this->hasGap = false;
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
        $this->foundInvalid = [];
        $this->hasGap = false;

        if (!is_string($value)) {
            return false;
        }

        // matches anything except: digits, +, -, (, ), and spaces
        // "(+44) 01235 67890" is valid
        // "555-4433-2232" is valid
        $invalid = '/[^0-9+() -]/';
        $hasInvalidChars = preg_match_all($invalid, $value, $this->foundInvalid);
        if ($hasInvalidChars) {
            return false;
        }

        // matches a series of 2 or more spaces
        $longGap = '/( {2})+/';
        $this->hasGap = preg_match($longGap, $value) > 0;
        if ($this->hasGap) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (!empty($this->foundInvalid) && !empty($this->foundInvalid[0])) {
            $invalidChars = $this->foundInvalid[0];
            return 'Invalid character'
                . (count($invalidChars) == 1 ? '' : 's')
                . ' in phone number: '
                . implode(', ', $invalidChars);
        }
        if ($this->hasGap) {
            return 'Phone number has too many spaces in it.';
        }
        return 'Unknown phone number validation error.';
    }
}
