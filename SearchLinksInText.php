<?php


namespace App\Packages\SearchLinksInText;

/**
 * Class SearchLinksInText
 * @package App\Packages\SearchLinksInText
 */
class SearchLinksInText
{
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

        dd($this->links);


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
            $this->links[substr($text, $start, $length)] = [$start, $start + $length];
        }

        return $this->links;
    }

    /**
     * Знаходить номер першого входження https:// or https://
     * @param string $text
     * @param $start
     * @return mixed
     */
    private function start(string $text, $start)
    {
        $text = substr($text, $start);
        return $start + min($this->strpos($text, 'http://'), $this->strpos($text, 'https://'));
    }

    /**
     * @param string $text
     * @param $start
     * @return int
     */
    private function linkLength(string $text, $start) : int
    {
        $text = substr($text, $start);
        return min($this->strpos($text, ' '), $this->strpos($text, '\''), $this->strpos($text, '"'));
    }

    private function deleteInvalidLinks()
    {
        foreach ($this->links as $key => $value) {
            if (! strpos($key, '.')) {
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
