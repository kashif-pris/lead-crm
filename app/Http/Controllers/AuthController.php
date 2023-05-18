<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\UserProfile;
use App\Models\Complaints;
use App\Models\StaffComplaint;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        // return 'ok';
        $user= User::where('email', $request->email)->first();
        if($user)
        {
            $request->validate([
                'email' => 'required',
                'password' => 'required|string',
            ]);
            $credentials = ['email'=>$request->email, 'password'=>$request->password];
            if(!Auth::attempt($credentials))
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
        }
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;
            // return $token;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response()->json([
                'access_token' => $tokenResult->plainTextToken,
                'token_type' => 'Bearer',
                'user'=>$user,
            ]);
    
    }

    // Home Screen Of Application
    function homeScreen(Request $request){
        $user = Auth::user(); 
        $role = $user->role_id; //1 =>admin,2 =>cusotmer,3 =>staff
        $msg = null;
        if($role ==1){
            // Admin Home Screen
            $openedComplaints = Complaints::where(['status'=>'Inprogress'])->where('created_by','!=',$user->id)->count();
            $pendingComplaints = Complaints::where(['status'=>'Pending'])->where('created_by','!=',$user->id)->whereNull('assigned')->count();
            $completedComplaints = Complaints::whereIn('status',['Completed','Approved'])->where('created_by','!=',$user->id)->count();
            // $machines = Complaints::where(['status'=>'Pending'])->whereNotNull('approved_at')->count();
            $msg = "Show Admin Home Screen Features";
            $data = [
                'open'=>   $openedComplaints,
                'pending'=>$pendingComplaints,
                'completed'=>$completedComplaints,
                'note'=>$msg,
                'role'=>$role

            ];
        }elseif($role ==2){
            // Staff Home Screen
            $openedComplaints = Complaints::where(['status'=>'Inprogress'])->where('customer_id', $user->id)->where('created_by','!=',$user->id)->count();
            $pendingComplaints = Complaints::where(['status'=>'Pending'])->where('customer_id', $user->id)->where('created_by','!=',$user->id)->count();
            $completedComplaints = Complaints::whereIn('status',['Completed','Approved'])->where('customer_id', $user->id)->where('created_by','!=',$user->id)->count();
            // $machines = Complaints::where(['status'=>'Pending'])->whereNotNull('approved_at')->count();
            $msg = "Show Staff Home Screen Features";
            $data = [
                'open'=>   $openedComplaints,
                'pending'=>$pendingComplaints,
                'completed'=>$completedComplaints,
                'note'=>$msg,
                'role'=>$role
            ];
        }elseif($role ==3){
            // Customer Home Screen
            $openedComplaints = StaffComplaint::where(['status'=>'Inprogress','staff_id'=>$user->id])->count();
            $pendingComplaints = StaffComplaint::where(['status'=>'Pending','staff_id'=>$user->id])->count();
            $completedComplaints = StaffComplaint::whereIn('status',['Completed','Approved'])->where(['staff_id'=>$user->id])->count();
            // $machines = StaffComplaint::where(['status'=>'Pending','staff_id'=>$user->id])->count();
            $msg = "Show Customer Home Screen Features";
            $data = [
                'open'=>   $openedComplaints,
                'pending'=>$pendingComplaints,
                'completed'=>$completedComplaints,
                'note'=>$msg,
                'role'=>$role

            ];
        }

        return response()->json([
            'data' => $data,
            'user' => $user
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user()->with('profile')->first());
    }
}