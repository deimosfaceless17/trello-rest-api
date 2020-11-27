<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'board_id', 'user_id'];

    public const STATUS_BACKLOG = 'backlog';
    public const STATUS_DEVELOPMENT = 'development';
    public const STATUS_DONE = 'done';
    public const STATUS_REVIEW = 'review';

    public const STATUSES = [
        self::STATUS_BACKLOG,
        self::STATUS_DEVELOPMENT,
        self::STATUS_DONE,
        self::STATUS_REVIEW,
    ];
}
