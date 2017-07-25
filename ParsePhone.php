<?php
class ParsePhone {
    /** @var int|string */
    protected $phoneNumber;

    /**
     * ParsePhone constructor.
     *
     * @param string|int $phoneNumber phone number to be parsed
     */
    public function __construct($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
        $this->fromInternational();
    }

    /**
     * @param string|int $phoneNumber phone number to be parsed
     *
     * @return static
     */
    public static function create($phoneNumber) {
        return new static($phoneNumber);
    }

    /**
     * Checks if phone number is a valid Israeli/Palestinian phone number
     *
     * @return bool
     */
    public function isValid() {
        return (bool)preg_match('/^((0[23489][2356789]|0[57][10234569]\d|1(2(00|12)|599|70[05]|80[019]|90[012]|919))\d{6}|\*\d{4})$/', $this->phoneNumber);
    }

    public function isNotValid() {
        return !$this->isValid();
    }

    /**
     * Checks if phone number is Israeli
     *
     * @return bool
     */
    public function isIsraeli() {
        return (bool)preg_match('/^((0[23489][356789]|0[57][102345]\d|1(2(00|12)|599|70[05]|80[019]|90[012]|919))\d{6}|\*\d{4})$/', $this->phoneNumber);
    }

    public function isNotIsraeli() {
        return !$this->isIsraeli();
    }

    /**
     * Checks if phone number is Palestinian
     *
     * @return bool
     */
    public function isPalestinian() {
        return (bool)preg_match('/^(0[23489]2|05[69]\d|)\d{6}$/', $this->phoneNumber);
    }

    public function isNotPalestinian() {
        return !$this->isPalestinian();
    }


    /**
     * Checks if phone number is lan line
     *
     * @return bool
     */
    public function isLanLine() {
        return (bool)preg_match('/^0([23489][2356789]|7\d{2})\d{6}$/', $this->phoneNumber);
    }

    public function isNotLanLine() {
        return !$this->isLanLine();
    }

    /**
     * Checks if phone number is mobile
     *
     * @return bool
     */
    public function isMobile() {
        return (bool)preg_match('/^0[5][10234569]\d{7}$/', $this->phoneNumber);
    }

    public function isNotMobile() {
        return !$this->isMobile();
    }

    /**
     * Checks if phone number is special (*1234)
     *
     * @return bool
     */
    public function isSpecial() {
        return (bool)preg_match('/^\*\d{4}$/', $this->phoneNumber);
    }

    public function isNotSpecial() {
        return !$this->isSpecial();
    }


    /**
     * Checks if phone number is business (1800, etc)
     *
     * @return bool
     */
    public function isBusiness() {
        return (bool)preg_match('/^1(2(00|12)|599|70[05]|80[019]|90[012]|919)\d{6}$/', $this->phoneNumber);
    }

    public function isNotBusiness() {
        return !$this->isBusiness();
    }

    /**
     * Checks if phone number is toll free (1800)
     *
     * @return bool
     */
    public function isTollFree() {
        return (bool)preg_match('/^180[019]\d{6}$/', $this->phoneNumber);
    }

    public function isNotTollFree() {
        return !$this->isTollFree();
    }


    /**
     * Checks if phone number is premium (1900)
     *
     * @return bool
     */
    public function isPremium() {
        return (bool)preg_match('/^19(0[012]|19)\d{6}$/', $this->phoneNumber);
    }

    public function isNotPremium() {
        return !$this->isPremium();
    }

    /**
     * Checks if phone number is erotic (1919)
     *
     * @return bool
     */
    public function isErotic() {
        return (bool)preg_match('/^1919\d{6}$/', $this->phoneNumber);
    }

    public function isNotErotic() {
        return !$this->isErotic();
    }

    /**
     * Transforms phone number to local format
     * 97221231234  > 021231234
     * 972501231234 > 0501231234
     */
    protected function fromInternational() {
        $this->phoneNumber = preg_replace('/^(972)(\d{8,9})$/', '0$2', $this->phoneNumber);
    }

    /**
     * @return int|string
     */
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    /**
     * Returns phone number transformed to international format
     * 021231234  > 97221231234
     * 0501231234 > 972501231234
     */
    public function getInternational() {
        return preg_replace('/^(0)(\d{8,9})$/', '972$2', $this->phoneNumber);
    }
}
