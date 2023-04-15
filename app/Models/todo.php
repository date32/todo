<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    use HasFactory;

    // テーブルを定義する
    protected $table = 'todos';

    // このモデルはUserクラスの１つのレコードと必ず結びついている
    public function users() {
        return $this->belongsTo(User::class);
    }
}
