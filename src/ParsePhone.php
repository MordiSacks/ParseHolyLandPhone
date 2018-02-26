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
 * @method bool isNotErotic()
 *
 * @package ParseHolyLandPhone
 */
class ParsePhone
{
    /** @var int|string */
    protected $phoneNumber;

    /**
     * ParsePhone constructor.
     *
     * @param string|int $phoneNumber phone number to be parsed
     */
    public function __construct($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        $this->fromInternational();
    }

    /**
     * @param string|int $phoneNumber phone number to be parsed
     *
     * @return static
     */
    public static function create($phoneNumber)
    {
        return new static($phoneNumber);
    }

    /**
     * Checks if phone number is a valid Israeli/Palestinian phone number
     *
     * @return bool
     */
    public function isValid()
    {
        return (bool)preg_match('/^((0[23489][2356789]|0[57][102345689]\d|1(2(00|12)|599|70[05]|80[019]|90[012]|919))\d{6}|\*\d{4})$/', $this->phoneNumber);
    }

    /**
     * Checks if phone number is Israeli
     *
     * @return bool
     */
    public function isIsraeli()
    {
        return (bool)preg_match('/^((0[23489][356789]|0[57][1023458]\d|1(2(00|12)|599|70[05]|80[019]|90[012]|919))\d{6}|\*\d{4})$/', $this->phoneNumber);
    }

    /**
     * Checks if phone number is Palestinian
     *
     * @return bool
     */
    public function isPalestinian()
    {
        return (bool)preg_match('/^(0[23489]2|05[69]\d|)\d{6}$/', $this->phoneNumber);
    }

    /**
     * Checks if phone number is land line
     *
     * @return bool
     */
    public function isLandLine()
    {
        return (bool)preg_match('/^0([23489][2356789]|7\d{2})\d{6}$/', $this->phoneNumber);
    }

    /**
     * Checks if phone number is mobile
     *
     * @return bool
     */
    public function isMobile()
    {
        return (bool)preg_match('/^0[5][102345689]\d{7}$/', $this->phoneNumber);
    }

    /**
     * Checks if phone number is special (*1234)
     *
     * @return bool
     */
    public function isSpecial()
    {
        return (bool)preg_match('/^\*\d{4}$/', $this->phoneNumber);
    }

    /**
     * Checks if phone number is business (1800, etc)
     *
     * @return bool
     */
    public function isBusiness()
    {
        return (bool)preg_match('/^1(2(00|12)|599|70[05]|80[019]|90[012]|919)\d{6}$/', $this->phoneNumber);
    }

    /**
     * Checks if phone number is toll free (1800)
     *
     * @return bool
     */
    public function isTollFree()
    {
        return (bool)preg_match('/^180[019]\d{6}$/', $this->phoneNumber);
    }

    /**
     * Checks if phone number is premium (1900)
     *
     * @return bool
     */
    public function isPremium()
    {
        return (bool)preg_match('/^19(0[012]|19)\d{6}$/', $this->phoneNumber);
    }

    /**
     * Checks if phone number is Kosher (phone supports only calls)
     *
     * @return bool
     */
    public function isKosher()
    {
        return (bool)preg_match('/^0([23489]80|5041|5271|5276|5484|5485|5331|5341|5832|5567)\d{5}$/', $this->phoneNumber);
    }

    
    /**
     * Checks if phone number can receive sms
     *
     * @return bool
     */
    public function isSmsable()
    {
        return $this->isNotKosher() && $this->isMobile();
    }

    
    /**
     * Checks if phone number is erotic (1919)
     *
     * @return bool
     */
    public function isErotic()
    {
        return (bool)preg_match('/^1919\d{6}$/', $this->phoneNumber);
    }

    /**
     * Transforms phone number to local format
     * 97221231234  > 021231234
     * 972501231234 > 0501231234
     */
    protected function fromInternational()
    {
        $this->phoneNumber = preg_replace('/^(972)(\d{8,9})$/', '0$2', $this->phoneNumber);
    }

    /**
     * @return int|string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Returns phone number transformed to international format
     * 021231234  > 97221231234
     * 0501231234 > 972501231234
     */
    public function getInternational()
    {
        return preg_replace('/^(0)(\d{8,9})$/', '972$2', $this->phoneNumber);
    }

    /**
     * isNot implementation
     *
     * @param $method
     * @param $arguments
     *
     * @return bool
     */
    public function __call($method, $arguments)
    {
        /**
         * Check if starts with isNot
         */
        if (substr($method, 0, 5) !== 'isNot') {
            trigger_error('Call to undefined method ' . __CLASS__ . '::' . $method . '()', E_USER_ERROR);
        }

        /**
         * Check if method exists
         */
        $flippedMethod = 'is' . substr($method, 5);

        if (!method_exists($this, $flippedMethod)) {
            trigger_error('Call to undefined method ' . __CLASS__ . '::' . $method . '()', E_USER_ERROR);
        }

        return !$this->{$flippedMethod}();
    }
}
