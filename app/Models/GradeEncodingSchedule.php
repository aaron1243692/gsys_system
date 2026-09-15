<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GradeEncodingSchedule extends Model
{
    protected $guarded = ['id'];
    protected function casts(): array { return ['opens_at'=>'datetime','closes_at'=>'datetime','quarter'=>'integer']; }
    public function academicYear() { return $this->belongsTo(AcademicYear::class); }
    public function getStatusAttribute(): string { return now()->lt($this->opens_at) ? 'UPCOMING' : (now()->gt($this->closes_at) ? 'CLOSED' : 'OPEN'); }
}
