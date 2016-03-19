<?php

class CreditCard
{
    const ERROR_INVALID_CHAR = 'ERROR_INVALID_CHAR';
    const ERROR_INVALID_LENGTH = 'ERROR_INVALID_LENGTH';

    private $_number;

    /**
     *
     *  Visa = 4XXX - XXXX - XXXX - XXXX
     * MasterCard = 5[1-5]XX - XXXX - XXXX - XXXX
     * Discover = 6011 - XXXX - XXXX - XXXX
     * Amex = 3[4,7]X - XXXX - XXXX - XXXX
     * Diners = 3[0,6,8] - XXXX - XXXX - XXXX
     * Any Bankcard = 5610 - XXXX - XXXX - XXXX
     * JCB =  [3088|3096|3112|3158|3337|3528] - XXXX - XXXX - XXXX
     * Enroute = [2014|2149] - XXXX - XXXX - XXX
     * Switch = [4903|4911|4936|5641|6333|6759|6334|6767] - XXXX - XXXX - XXXX
     *
     * @var array
     */
    protected $cards = [

        'mastercard' => [
            'length' => [16],
            'pattern' => '/^5[0-5]/',
        ],
        'discover' => [
            'length' => [], //not defined init 6
            'pattern' => '/^6011/',
        ],
        'amex' => [
            'length' => [14],
            'pattern' => '/^3(47)/',
        ],
        'diners' => [
            'length' => [14],
            'pattern' => '/^3(068)/',
        ],
        'any_bankcard' => [
            'length' => [16],
            'pattern' => '/^5610/',
        ],
        'jcb' => [
            'length' => [14],
            'pattern' => '/^(3088|3096|3112|3158|3337|3528)/',
        ],
        'enroute' => [
            'length' => [15],
            'pattern' => '/^(2014|2149)/',
        ],
        'switch' => [
            'length' => [16],
            'pattern' => '/^(4903|4911|4936|5641|6333|6759|6334|6767)/',
        ],
        'visa' => [
            'length' => [16],
            'pattern' => '/^4/',
        ],

    ];


    protected function creditCardType($number)
    {
        foreach ($this->cards as $type => $card) {
            if (preg_match($card['pattern'], $number)) {
                return $type;
            }
        }
        return null;
    }

    /**
     * checks if the number is valid
     * @return bool|string
     */
    function validCreditCard()
    {
        $number = $this->_number;
        if (is_null($number))
            return self::ERROR_INVALID_CHAR;

        $number_only = preg_replace('/\D/', '', $number);
        $number_length = strlen($number_only);
        $type = $this->creditCardType($number_only);

        if ($type == null) //no card is compatible with number
            return self::ERROR_INVALID_LENGTH;

        if (!in_array($number_length, $this->cards[$type]['length']))
            return self::ERROR_INVALID_LENGTH;

        return true;
    }

    /**
     * @param null $number
     * @return bool|string
     */
    function set($number = null)
    {
        $this->_number = $number;
    }

    /**
     * retrieve the current card number. the number is returned
     * unformatted suitable for use with submission to payment and
     * authorization gateways.
     *
     * @return string card number
     */
    function get()
    {
        return @$this->_number;
    }

}