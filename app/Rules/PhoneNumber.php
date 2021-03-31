<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Validation rule for validating a phone number.
 *
 * @package Validation
 */
class PhoneNumber implements Rule
{
    /**
     * Characters that have been found in the string which
     * are not permitted in a valid phone number.
     *
     * @var array
     */
    protected array $foundInvalid = [];

    /**
     * Whether an excessive whitespace gap was found in
     * the examined phone number.
     *
     * @var bool
     */
    protected bool $hasGap = false;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute Name of the attribute being validated.
     * @param mixed  $value     The value that is undergoing validation.
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->foundInvalid = [];
        $this->hasGap       = false;

        if (!is_string($value)) {
            return false;
        }

        // matches anything except: digits, +, -, ., (, ), x, and spaces
        // "(+44) 01235 67890" is valid
        // "555-4433-2232" is valid
        // "1800 DEALS" is not valid
        $hasInvalidChars = preg_match_all('/[^0-9+()\.x -]/', $value, $this->foundInvalid);
        if ($hasInvalidChars) {
            return false;
        }

        // matches a series of 2 or more spaces
        $this->hasGap = preg_match('/( {2})+/', $value) > 0;
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
