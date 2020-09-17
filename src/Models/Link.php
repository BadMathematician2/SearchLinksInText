<?php

namespace SearchInText\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Link
 * @package SearchInText\Models
 */
class Link extends Model
{
    /**
     * @var string
     */
    protected $table = 'code_links';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    public function text()
    {
        return $this->hasOne(Text::class);
    }
}
