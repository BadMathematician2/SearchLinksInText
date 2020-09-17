<?php


namespace SearchInText;


use SearchInText\Models\Link;
use SearchInText\Models\Text;

/**
 * Class LinksInText
 * @package SearchInText
 */
class LinksInText
{
    /**
     * @var SearchLinks
     */
    private $searchLinks;

    /**
     * LinksInText constructor.
     * @param SearchLinks $searchLinks
     */
    public function __construct(SearchLinks $searchLinks)
    {
        $this->searchLinks = $searchLinks;
    }

    public function recordLinksCodes(string $text)
    {
        $text_id = Text::query()->create(['text_code' => $this->generateTextCode()])->getAttribute('id');

        $links = $this->searchLinks->searchLinks($text);

        foreach ($links as $link => $positions) {
                Link::query()->create([
                    'text_id' => $text_id,
                    'url_code' => $this->generateLinkCode($link),
                    'url' => $link
                ]);
        }

    }

    /**
     * @return string
     */
    private function generateTextCode() : string
    {
        $text_code = '';
        foreach (range(1, 10) as $item) {
            $text_code = $text_code . chr(rand(33, 127));
        }

        return substr(hash('sha512', $text_code . microtime(true)), -6);
    }

    /**
     * @param string $link
     * @return string
     */
    private function generateLinkCode(string $link) : string
    {
        return substr(hash('sha512', $link), -3);
    }

}
