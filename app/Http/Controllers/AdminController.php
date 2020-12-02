<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use App\Models\User;
use Str;
class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:users-list');
        $this->middleware('permission:users-create', ['only' => ['adduser','saveuser']]);
        $this->middleware('permission:users-edit', ['only' => ['edituser','saveuser']]);
        $this->middleware('permission:users-action', ['only' => ['actionUsers']]);
    }
    
    public function editprofile()
    {
    	$user = User::find(Auth::id());
        return view('edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name'          => ['required', 'string', 'max:191'],
            'mobile'        => ['required', 'numeric', 'digits_between:10,12'],
            'address'       => ['required', 'string', 'max:191'],
            'city'          => ['required', 'string', 'max:191'],
            'zipCode'       => ['required', 'numeric', 'regex:/\b\d{6}\b/'],
            'companyLogo'   => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'locktimeout'   => ['required', 'numeric','min:10','max:120']
        ]);

        $destinationPath    = 'assets/uploads/';
        $image_name = Str::slug(substr($request->companyName, 0, 30));
        $saveFile = $request->oldCompanyLogo;
        if($request->hasFile('companyLogo'))
        {
            if($request->oldCompanyLogo!='')
            {
                if(file_exists($destinationPath.'logothumb/'.$request->oldCompanyLogo)){ 
                    unlink($destinationPath.'logothumb/'.$request->oldCompanyLogo);
                }
            }
            $file       = $request->companyLogo;
            $fileName   = value(function() use ($file, $image_name)
            {
              $newName = $image_name.'-'.time() . '.' . $file->getClientOriginalExtension();
              return strtolower($newName);
            });
            $request->companyLogo->move($destinationPath, $fileName);
            $img = \Image::make($destinationPath.$fileName);
            $img->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath.'logothumb/'.$fileName);
            $saveFile = $destinationPath.'logothumb/'.$fileName;
            if(file_exists($destinationPath.$fileName)){ 
                unlink($destinationPath.$fileName);
            }
        }

        $user = User::find(Auth::user()->id);
        $user->name         = $request->name;
        $user->mobile       = $request->mobile;
        $user->address      = $request->address;
        $user->city         = $request->city;
        $user->zipCode      = $request->zipCode;
        $user->companyLogo  = $saveFile;
        $user->locktimeout  = $request->locktimeout;
        $user->save();
        if($user)
        {
            notify()->success('Success, Profile setting successfully changed.');
        }
        else
        {
            notify()->error('Oops!!!, something went wrong, please try again.');
        }
        return \Redirect()->back();

    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'              => ['required'],
            'new_password'              => ['required', 'confirmed', 'min:6', 'max:25'],
            'new_password_confirmation' => ['required']
        ]);

        $matchpassword  = User::find(Auth::user()->id)->password;
        if(\Hash::check($request->old_password, $matchpassword))
        {
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->new_password);
            $user->save();
            notify()->success('Success, Password successfully changed.');
        }
        else
        {
            notify()->error('Incorrect password, Please try again with correct password.');
        }
        return \Redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return \Redirect::away('.');
    }
}
