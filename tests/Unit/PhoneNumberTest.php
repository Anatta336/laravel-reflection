<?php

namespace Tests\Unit;

use App\Rules\PhoneNumber;
use Illuminate\Contracts\Validation\Rule;
use Tests\TestCase;

// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
// phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

/**
 * Unit tests for the PhoneNumber validation rule.
 *
 * @package Validation
 *
 * @SuppressWarnings(CamelCaseMethodName)
 * @SuppressWarnings(TooManyPublicMethods)
 */
class PhoneNumberTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function can_instantiate()
    {
        $validator = new PhoneNumber();

        $this->assertInstanceOf(PhoneNumber::class, $validator);
    }

    /**
     * @test
     *
     * @return void
     */
    public function implements_validation_rule()
    {
        $validator = new PhoneNumber();

        $this->assertInstanceOf(Rule::class, $validator);
    }

    /**
     * @test
     *
     * @return void
     */
    public function accepts_simple_number()
    {
        $validator = new PhoneNumber();

        $this->assertTrue($validator->passes('phone', '0123456789'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function accepts_country_code_in_parentheses()
    {
        $validator = new PhoneNumber();

        $this->assertTrue($validator->passes('phone', '(+44) 0123456789'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function accepts_extention_after_x()
    {
        $validator = new PhoneNumber();

        $this->assertTrue($validator->passes('phone', '0123456789 x123'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function accepts_hyphen_separators()
    {
        $validator = new PhoneNumber();

        $this->assertTrue($validator->passes('phone', '0123-456-789'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function accepts_dot_separators()
    {
        $validator = new PhoneNumber();

        $this->assertTrue($validator->passes('phone', '0123.456.789'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function accepts_single_space_separators()
    {
        $validator = new PhoneNumber();

        $this->assertTrue($validator->passes('phone', '0123 456 789'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function rejects_single_letter()
    {
        $validator = new PhoneNumber();

        $this->assertFalse($validator->passes('phone', 'A012345'));
        $this->assertSame('Invalid character in phone number: A', $validator->message());
    }

    /**
     * @test
     *
     * @return void
     */
    public function rejects_multiple_letters()
    {
        $validator = new PhoneNumber();

        $this->assertFalse($validator->passes('phone', 'ABC012345'));
        $this->assertSame('Invalid characters in phone number: A, B, C', $validator->message());
    }

    /**
     * @test
     *
     * @return void
     */
    public function rejects_long_space_separators()
    {
        $validator = new PhoneNumber();

        $this->assertFalse($validator->passes('phone', '0123    456'));
        $this->assertSame('Phone number shouldn\'t have a chain of separators in it.', $validator->message());
    }

    /**
     * @test
     *
     * @return void
     */
    public function rejects_multi_dot_separators()
    {
        $validator = new PhoneNumber();

        $this->assertFalse($validator->passes('phone', '0123...456'));
        $this->assertSame('Phone number shouldn\'t have a chain of separators in it.', $validator->message());
    }

    /**
     * @test
     *
     * @return void
     */
    public function rejects_multi_hyphen_separators()
    {
        $validator = new PhoneNumber();

        $this->assertFalse($validator->passes('phone', '0123--456'));
        $this->assertSame('Phone number shouldn\'t have a chain of separators in it.', $validator->message());
    }

    /**
     * @test
     *
     * @return void
     */
    public function rejects_not_number_unicode_characters()
    {
        $validator = new PhoneNumber();

        $this->assertFalse($validator->passes('phone', '𝓺𝓾𝓲𝓬𝓴 012345'));
        $this->assertSame('Invalid characters in phone number: 𝓺, 𝓾, 𝓲, 𝓬, 𝓴', $validator->message());
    }
}
