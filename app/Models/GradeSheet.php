<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GradeSheet extends Model
{
    protected $guarded = ['id'];
    protected function casts(): array { return ['roster'=>'array', 'quarter'=>'integer', 'correction_until'=>'datetime', 'submitted_at'=>'datetime', 'approved_at'=>'datetime', 'returned_at'=>'datetime']; }
    public function grades() { return $this->hasMany(Grade::class); }
}
