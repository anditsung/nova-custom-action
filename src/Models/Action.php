<?php


namespace Tsung\NovaCustomAction\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Action extends Model
{
    //use HasFlexible;

    protected $fillable = [
        'name',
        'changes',
        'rules',
        'nova_resources',
        'modal_title',
        'modal_message',
    ];

    public static function nova_resource($resource)
    {
        return self::whereJsonContains('nova_resources', $resource)->with('icon')->get();
    }

    public function icon() : BelongsTo
    {
        return $this->belongsTo(Icon::class);
    }
}
