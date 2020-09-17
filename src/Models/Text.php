<?php

namespace SearchInText\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Text
 * @package SearchInText\Models
 */
class Text extends Model
{
    /**
     * @var string
     */
    protected $table = 'texts';

    /**
     * @var string[]
     */
    protected $fillable = ['text_code'];
}
