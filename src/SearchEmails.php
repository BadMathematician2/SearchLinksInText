<?php


namespace SearchInText;

/**
 * Class SearchEmails
 * @package SearchInText
 */
class SearchEmails
{
    /**
     * @var array
     */
    private $email = [];

    /**
     * @var array
     */
    private $invalid_symbols;

    /**
     * SearchEmails constructor.
     */
    public function __construct()
    {
        $this->invalid_symbols = array_merge(range(32, 44),
            range(58, 63),
            range(91, 94),
            range(123, 126),
            [10, 47, 96, ]);
    }

    /**
     * @param string $text
     * @return array
     */
    public function searchEmails(string $text) : array
    {
        $this->recordEmail($text);
        $this->deleteInvalidLinks();

        return $this->email;
    }

    /**
     * @param string $text
     * @return array
     */
    private function recordEmail(string $text) : array
    {
        $center = 0;
        $right_length = 0;

        while ($center + $right_length < strlen($text)) {
            $center = $this->center($text, $center + $right_length);
            $right_length = $this->rightLength($text, $center);
            $left_end = $this->leftEnd($text, $center);
            $this->email[substr($text, $left_end, $center - $left_end) . substr($text, $center, $right_length)][] = [$left_end, $center + $right_length];
        }

        return $this->email;
    }

    /**
     * @param string $text
     * @param int $start
     * @return int
     */
    private function center(string $text, int $start) : int
    {
        $text = substr($text, $start);

        return $start + $this->strpos($text, '@');
    }

    /**
     * @param string $text
     * @param int $start
     * @return int
     */
    private function rightLength(string $text, int $start) : int
    {
        $text = substr($text, $start);
        $min = strlen($text);
        foreach ($this->invalid_symbols as $symbol) {
            $min = min($min, $this->strpos($text,chr($symbol)));
        }

        return $min;
    }

    /**
     * @param string $text
     * @param int $end
     * @return int
     */
    private function leftEnd(string $text, int $end) : int
    {
        $text = substr($text, 0, $end);
        $max = 0;
        foreach ($this->invalid_symbols as $symbol) {
            $max = max($max, $this->strrpos($text, chr($symbol)));
        }

        return $max + 1;
    }

    private function deleteInvalidLinks()
    {
        foreach ($this->email as $key => $value) {
            if (! strpos(strstr($key, '@'), '.')) {
                unset($this->email[$key]);
            }
            if (strpos($key, '..')) {
                unset($this->email[$key]);
            }

        }
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

    /**
     * @param string $str
     * @param string $needle
     * @return int
     */
    private function strrpos(string $str, string $needle) : int
    {
        return (false != strrpos($str, $needle)) ? strrpos($str, $needle) : 0;
    }


}
