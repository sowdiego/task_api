<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Task",
 *     title="Tâche",
 *     required={"title"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Faire les courses"),
 *     @OA\Property(property="description", type="string", example="Acheter du lait"),
 *     @OA\Property(property="is_done", type="boolean", example=false),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class Task extends Model
{
    protected $fillable = ['title', 'description', 'is_done'];
}
