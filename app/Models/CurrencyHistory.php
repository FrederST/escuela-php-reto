<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'quote',
    ];

    public function source(): string
    {
        return $this->source;
    }

    public function quote(): float
    {
        return $this->quote;
    }
}
