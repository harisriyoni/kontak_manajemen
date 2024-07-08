<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $table = "addresses";
    protected $promaryKey = "id";
    protected $keyType = "int";
    public $incrementing = "true";
    public $timestamp = "true";

    public function contact(): BelongsTo {
        return $this->BelongsTo(Contacts::class, "contact_id", "id");
    }
}
