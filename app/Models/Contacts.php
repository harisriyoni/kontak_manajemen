<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contacts extends Model
{
    protected $primaryKey ="id";
    protected $keyType ="int";
    protected $table ="contacts";
    public $incrementing =true;
    public $timestamp = true;

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function addresses(): HasMany {
return $this->hasManny(Address::class, "contact_id", "id");
    }
}
