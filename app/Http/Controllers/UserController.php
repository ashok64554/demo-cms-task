<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use DB;
use Str;
class UserController extends Controller
{
   
    function __construct()
    {
        $this->middleware('permission:users-list');
        $this->middleware('permission:user-create', ['only' => ['adduser','saveuser']]);
        $this->middleware('permission:user-edit', ['only' => ['edituser','saveuser', 'updateStatus']]);
        $this->middleware('permission:user-view', ['only' => ['viewuser']]);
        $this->middleware('permission:user-action', ['only' => ['actionUsers', 'updateStatus']]);
    }


    public function users()
    {
        $data = User::where('userType','!=','admin')->get();
        return View('admin.users')->with('data', $data);
    }

    public function viewuser($app_key)
    {
         if(User::where('app_key', $app_key)->count()<1)
        {
            notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
        }
        $user = User::where('app_key', $app_key)->first();
        $data = User::where('userType','!=','admin')->get();
        return View('admin.users', compact('user','data'));
    }

    public function actionUsers(Request $request)
    {
      	$data  = $request->all();
      	foreach($request->input('boxchecked') as $action)
      	{
          	if($request->input('cmbaction')=='Active')
          	{
              	User::where('id', $action)->update(array('status' => '1'));
          	}
          	else
          	{
              	User::where('id', $action)->update(array('status' => '0'));
          	}
      	}
      	return \Redirect()->back()->with('success', 'Action successfully done.');;
  	}

    public function updateStatus(Request $request)
    {
        if(count(User::where('app_key', $request->app_key)->first())<1)
        {
            $data = [
                'type'      => 'error',
                'message'   => 'something went wrong. please try again.',
            ];
            return response()->json($data, 200);
        }
        if($request->input('cmbaction')=='Active')
        {
            User::where('app_key', $request->app_key)->update(array('status' => '1'));
            $data = [
                'type'      => 'success',
                'message'   => 'Account successfully activated.',
            ];
            return response()->json($data, 200);
        }
        else
        {
            User::where('app_key', $request->app_key)->update(array('status' => '0'));
            $data = [
                'type'      => 'success',
                'message'   => 'Account successfully inactivated.',
            ];
            return response()->json($data, 200);
        }
    }

    public function adduser()
    {
        $roles = Role::pluck('name','name')->all();
        return View('admin.users',compact('roles'));
    }

    public function saveuser(Request $request)
    {
        $this->validate($request, [
            'name'        		=> 'required',
            'email'       		=> 'required|email',
            'mobile'     		=> 'required',
            'address'   		=> 'required',
            'companyName' 		=> 'required'
        ]);

        if(!empty($request->id))
        {
            $data = [
                'name'        		=> $request->name,
                'email'       		=> $request->email,
                'mobile'     		=> $request->mobile,
                'address'     		=> $request->address,
                'companyName' 		=> $request->companyName,
            ];

            $user = User::find($request->id);
            $user->update($data);
            DB::table('model_has_roles')->where('model_id',$request->id)->delete();
            if(!empty($request->input('roles')))
            {
                $user->assignRole($request->input('roles'));
            }
           return redirect()->route('users-list')->with('success','User successfully updated.');
        }
        else
        {
            $this->validate($request, [
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required|same:confirm-password'
            ]);

            $input 					= $request->all();
            $input['password'] 		= bcrypt($input['password']);
            $input['app_key'] 		= Str::random(25);
            $input['app_secret'] 	= Str::random(15);

            $user = User::create($input);
            if(!empty($request->input('roles')))
            {
              $user->assignRole($request->input('roles'));
            }
            return redirect()->route('users-list')->with('success','User successfully created.');
        }
    }

    public function edituser($app_key)
    {
         if(User::where('app_key', $app_key)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $roles = Role::pluck('name','name')->all();
        $user = User::where('app_key', $app_key)->first();
        $userRole = $user->roles->pluck('name','name')->all();
        return View('admin.users',compact('roles', 'user', 'userRole'));
    }

    public function deleteuser($app_key)
    {
         if(User::where('app_key', $app_key)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $user = User::where('app_key', $app_key)->delete();
        return redirect()->back()->with('delete','User successfully deleted.');
    }
}
