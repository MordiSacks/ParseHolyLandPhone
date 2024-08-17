<?php

namespace ParseHolyLandPhone;

/**
 * Class ParsePhone
 *
 * @method bool isNotValid()
 * @method bool isNotIsraeli()
 * @method bool isNotPalestinian()
 * @method bool isNotLandLine()
 * @method bool isNotSpecial()
 * @method bool isNotMobile()
 * @method bool isNotBusiness()
 * @method bool isNotTollFree()
 * @method bool isNotPremium()
 * @method bool isNotKosher()
 * @method bool isNotSmsable()
 * @method bool isNotErotic()
 */
class ParsePhone
{
    /** @var string */
    protected $phoneNumber;

    /** ParsePhone constructor. */
    public function __construct(string $phoneNumber) {
        $this->phoneNumber = $phoneNumber;
        $this->normalize();
    }

    /** @param string $phoneNumber phone number to be parsed */
    public static function create(string $phoneNumber): self {
        return new self($phoneNumber);
    }

    protected function normalize() {
        // Remove any non digits
        $this->phoneNumber = preg_replace('/\D/', '', $this->phoneNumber);

        // Assure is local format
        $this->phoneNumber = preg_replace('/^(972)(\d{8,9})$/', '0$2', $this->phoneNumber);
    }

    /** Checks if phone number is a valid Israeli/Palestinian phone number */
    public function isValid(): bool {
        return (bool)preg_match('/^((0[23489][2356789]|0[57][102345689]\d|1(2(00|12)|599|70[05]|80[019]|90[012]|919))\d{6}|\*\d{4})$/', $this->phoneNumber);
    }

    /** Checks if phone number is Israeli */
    public function isIsraeli(): bool {
        return (bool)preg_match('/^((0[23489][356789]|0[57][1023458]\d|1(2(00|12)|599|70[05]|80[019]|90[012]|919))\d{6}|\*\d{4})$/', $this->phoneNumber);
    }

    /** Checks if phone number is Palestinian */
    public function isPalestinian(): bool {
        return (bool)preg_match('/^(0[23489]2|05[69]\d|)\d{6}$/', $this->phoneNumber);
    }

    /** Checks if phone number is landline */
    public function isLandLine(): bool {
        return (bool)preg_match('/^0([23489][2356789]|7\d{2})\d{6}$/', $this->phoneNumber);
    }

    /** Checks if phone number is mobile */
    public function isMobile(): bool {
        return (bool)preg_match('/^05[102345689]\d{7}$/', $this->phoneNumber);
    }

    /** Checks if phone number is special (*1234) */
    public function isSpecial(): bool {
        return (bool)preg_match('/^\*\d{4}$/', $this->phoneNumber);
    }

    /** Checks if phone number is business (1800, etc.) */
    public function isBusiness(): bool {
        return (bool)preg_match('/^1(2(00|12)|599|70[05]|80[019]|90[012]|919)\d{6}$/', $this->phoneNumber);
    }

    /** Checks if phone number is toll-free (1800) */
    public function isTollFree(): bool {
        return (bool)preg_match('/^180[019]\d{6}$/', $this->phoneNumber);
    }

    /** Checks if phone number is premium (1900) */
    public function isPremium(): bool {
        return (bool)preg_match('/^19(0[012]|19)\d{6}$/', $this->phoneNumber);
    }

    /** Checks if phone number is Kosher (phone supports only calls) */
    public function isKosher(): bool {
        return (bool)preg_match('/^0([23489]80|5041|5271|5276|5484|5485|5331|5341|5832|5567)\d{5}$/', $this->phoneNumber);
    }

    /** Checks if phone number can receive sms */
    public function isSmsable(): bool {
        return $this->isNotKosher() && $this->isMobile();
    }

    /** Checks if phone number is erotic (1919) */
    public function isErotic(): bool {
        return (bool)preg_match('/^1919\d{6}$/', $this->phoneNumber);
    }

    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }

    /**
     * Returns phone number transformed to international format
     * 021231234  > 97221231234
     * 0501231234 > 972501231234
     */
    public function getInternational(): string {
        return preg_replace('/^(0)(\d{8,9})$/', '972$2', $this->phoneNumber);
    }

    /** Returns the number in local format */
    public function getLocal(): string {
        return $this->phoneNumber;
    }

    /** isNot implementation */
    public function __call($method, $arguments): bool {
        /** Check if starts with isNot */
        if (substr($method, 0, 5) !== 'isNot') {
            trigger_error('Call to undefined method ' . __CLASS__ . '::' . $method . '()', E_USER_ERROR);
        }

        /** Check if method exists */
        $flippedMethod = 'is' . substr($method, 5);

        if (!method_exists($this, $flippedMethod)) {
            trigger_error('Call to undefined method ' . __CLASS__ . '::' . $method . '()', E_USER_ERROR);
        }

        return !$this->{$flippedMethod}();
    }
}
