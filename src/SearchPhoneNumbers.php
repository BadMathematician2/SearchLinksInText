<?php


namespace SearchInText;

/**
 * Class SearchPhoneNumbers
 * @package App\Packages\SearchInText\src
 */
class SearchPhoneNumbers
{
    /**
     * @var array
     */
    private $phone_numbers = [];

    /**
     * @var array
     */
    private $country_codes;

    /**
     * SearchPhoneNumbers constructor.
     * @param PhoneNumberCountryCode $countryCode
     */
    public function __construct(PhoneNumberCountryCode $countryCode)
    {
        $this->country_codes = $countryCode->getCountryCodes();
    }

    /**
     * @param string $text
     * @return array
     */
    public function searchPhoneNumbers(string $text) : array
    {
        $this->recordPhoneNumbers($text);
        $this->deleteGaps();

        return $this->phone_numbers;
    }

    /**
     * @param string $text
     */
    private function recordPhoneNumbers(string $text)
    {
        $start = 0;
        $length = 0;

        while($start + $length < strlen($text)) {
            $start = $this->start($text, $start + $length);
            $length = $this->lengthToFirstNotNumber($text, $start);
            $this->phone_numbers[] = substr($text, $start, $length);
        }

    }

    /**
     * @param string $text
     * @param int $start
     * @return int
     */
    private function lengthToFirstNotNumber(string $text, int $start) : int
    {
        for ($i = $start; $i < strlen($text); $i++) {
            if (!is_numeric($text[$i]) && $text[$i] !== ' '){
                return $i - $start;
            }
        }

        return strlen($text) - $start;
    }


    private function deleteGaps()
    {
        $this->phone_numbers = array_map(function ($number){
            return str_replace(' ', '', $number);
        },$this->phone_numbers);
    }

    /**
     * @param string $text
     * @param int $start
     * @return int
     */
    private function start(string $text, int $start) : int
    {
        $text = substr($text, $start);
        $min = strlen($text);

        foreach ($this->country_codes as $code => $country) {
            $min = min($min, $this->strpos($text, $code));
        }

        return $start + $min;
    }

    /**
     * @param string $str
     * @param string $needle
     * @return int
     */
    private function strpos(string $str, string $needle) : int
    {
        return (false != strpos($str, $needle)) ? strpos($str, $needle) : strlen($str);
    }



}
