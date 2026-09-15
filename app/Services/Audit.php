<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
class Audit
{
    public static function record(string $actorType, ?int $actorId, string $action, $target, array $details = []): void
    {
        DB::table('audit_events')->insert(['actor_type'=>$actorType,'actor_id'=>$actorId,'action'=>$action,
            'target_type'=>$target->getTable(),'target_id'=>$target->id,'details'=>json_encode($details),'created_at'=>now()]);
    }
}
