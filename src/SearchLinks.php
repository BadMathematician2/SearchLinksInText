<?php


namespace SearchInText;

/**
 * Class SearchInText
 * @package App\Packages\SearchInText
 */
class SearchLinks
{
    /**
     * @var array
     */
    private $except = [];

    /**
     * @var array
     */
    private $links = [];

    /**
     * @param string $text
     * @return array
     */
    public function searchLinks(string $text) : array
    {
        $this->recordLinks($text);
        $this->deleteInvalidLinks();

        return $this->links;
    }

    /**
     * @param string $text
     * @return array
     */
    private function recordLinks(string $text) : array
    {
        $start = 0;
        $length = 0;

        while ($start < strlen($text)) {
            $start = $this->start($text, $start + $length);
            $length = $this->linkLength($text, $start);
            $this->links[substr($text, $start, $length)][] = [$start, $start + $length];
        }

        return $this->links;
    }

    /**
     * Знаходить номер першого входження https:// або https://
     * @param string $text
     * @param int $start
     * @return int
     */
    private function start(string $text, int $start) : int
    {
        $text = substr($text, $start);
        return $start + min($this->strpos($text, 'http://'), $this->strpos($text, 'https://'));
    }

    /**
     * @param string $text
     * @param int $start
     * @return int
     */
    private function linkLength(string $text, int $start) : int
    {
        $text = substr($text, $start);
        $symbols = [' ', '\'', '"', ';', PHP_EOL];
        $min = strlen($text);
        foreach ($symbols as $symbol) {
            $min = min($min, $this->strpos($text,$symbol));
        }

        return $min;
    }

    private function deleteInvalidLinks()
    {
        foreach ($this->links as $key => $value) {
            if (! strpos($key, '.')) {
                unset($this->links[$key]);
            }
            if (in_array(strrchr($key, '.'), $this->except)) {
                unset($this->links[$key]);
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

}
