<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\{Guardian,MobileApiToken,StudentAccount};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\{JsonResponse,Request};
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function studentLogin(Request $r): JsonResponse { return $this->login($r,StudentAccount::class,'student'); }
    public function guardianLogin(Request $r): JsonResponse { return $this->login($r,Guardian::class,'guardian'); }
    public function me(Request $r): JsonResponse { $a=$r->attributes->get('mobile_user'); return $this->ok(['role'=>$r->attributes->get('mobile_role'),'user'=>$this->identity($a)]); }
    public function logout(Request $r): JsonResponse { $r->attributes->get('mobile_token')->delete(); return $this->ok(null,'Logged out.'); }
    /** @param class-string<Model> $model */
    private function login(Request $r,string $model,string $role): JsonResponse
    {
        $v=$r->validate(['username'=>['required','string'],'password'=>['required','string']]);
        $a=$model::where('username',$v['username'])->first();
        if(!$a||!Hash::check($v['password'],$a->password)) return response()->json(['success'=>false,'message'=>'Invalid username or password.'],401);
        if($a->status!=='ACTIVE'||($role==='student'&&!$a->student()->whereHas('info')->exists())) return response()->json(['success'=>false,'message'=>'Your account is not active. School staff must review and activate it before portal access.'],403);
        $plain=bin2hex(random_bytes(32));
        MobileApiToken::create(['account_type'=>$role,'account_id'=>$a->id,'token_hash'=>hash('sha256',$plain),'expires_at'=>now()->addDays(30)]);
        return $this->ok(['token'=>$plain,'token_type'=>'Bearer','role'=>$role,'user'=>$this->identity($a)],'Login successful.');
    }
    private function identity(Model $a): array { return ['id'=>$a->id,'username'=>$a->username,'name'=>$a->name??null,'email'=>$a->email]; }
    private function ok(mixed $data,?string $message=null): JsonResponse { return response()->json(array_filter(['success'=>true,'message'=>$message,'data'=>$data],fn($v)=>$v!==null)); }
}
