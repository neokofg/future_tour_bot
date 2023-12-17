<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Form extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'forms';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function generateNumber()
    {
        // Находим последнее число в столбце 'number' из всех моделей
        $lastNumber = self::max('number');

        // Если столбец 'number' пуст или не содержит чисел, начинаем с 1
        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

        $this->number = $nextNumber;
        $this->save();
    }

}
