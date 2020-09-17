<?php


namespace SearchInText;


class SearchEmails
{

    private $email = [];

    public function searchEmails($text)
    {
        $this->recordEmail($text);
        dd($this->email);
        $this->deleteInvalidLinks();

        return $this->email;
    }

    /**
     * @param string $text
     * @return array
     */
    private function recordEmail(string $text) : array
    {
        $start = 0;
        $length = 0;

        while ($start < strlen($text)) {
            $start = $this->center($text, $start + $length);
            $length = $this->rightLength($text, $start);
            $left_length = $this->leftLength($text, $start);
            $this->email[substr($text, $left_length, $start - $left_length) . substr($text, $start, $length)][] = [$start, $start + $length];
        }

        return $this->email;
    }

    /**
     * @param string $text
     * @param int $start
     * @return mixed
     */
    private function center(string $text, int $start)
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
        $symbols = [' ', '\'', '"', ';', PHP_EOL];
        $min = strlen($text);
        foreach ($symbols as $symbol) {
            $min = min($min, $this->strpos($text,$symbol));
        }

        return $min;
    }

    /**
     * @param string $text
     * @param int $end
     * @return int
     */
    private function leftLength(string $text, int $end) : int
    {
        $text = substr($text, 0, $end);
        $symbols = [' ', '\'', '"', ';', PHP_EOL];
        $max = 0;
        foreach ($symbols as $symbol) {
            $max = max($max, $this->strrpos($text, $symbol));
        }

        return $max + 1;
    }

    private function deleteInvalidLinks()
    {
        foreach ($this->email as $key => $value) {
            if (! strpos($key, '.')) {
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
