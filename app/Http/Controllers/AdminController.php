<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //Change Password page
   public function changePasswordPage(){
    return view('admin.account.changePassword');
   }

   //Change Password
   public function changePassword(Request $request){
    // validation
    // must fill all 3 rows,
    // new&confirmed length must be greater than 6,
    // new$confirmed pass must be the same
    // old password must be same as databae password,
    // change:password

     $this->passwordValidationCheck($request);

    $currentuserid = Auth::user()->id;
    $userdata = User::select('password')->where('id',$currentuserid)->first();
    $hashPassword = $userdata->password;  //hashvalue

    if(Hash::check($request->oldpassword, $hashPassword)){
        $data = [
            'password' => Hash::make($request->newpassword)
        ];
        User::where('id',$currentuserid)->update($data);

        return back()->with(['changeSuccess' => 'Password changed..']);
      }

      return back()->with(['notMatching' => 'The old Password did not match. Try agin']);
   }

   //Admin profile account details
   public function profileDetails(){
    return view('admin.account.profile');
   }

   // Profile Edit
   public function profileEdit(){
        Auth::user()->id;
        return view('admin.account.profileEdit');
   }

   // Profile Update
   public function profileUpdate($id,Request $request){
    $this->accountValidationCheck($request);
    $data = $this->getUserData($request);

    // for image uploading
    if($request->hasFile('image')){
        //old image name -> check-> if it has in db, delete or not
        //storage new images
        $oldImage = User::where('id',$id)->first();
        $oldImage = $oldImage->image;

        //delete old image in db
        if($oldImage != null){
            Storage::delete('public/'.$oldImage);
        }

        // upload new image
        $fileName = uniqid() . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public',$fileName);
        $data['image'] = $fileName;

    }

    User::where('id',$id)->update($data);
    return redirect()->route('admin#profileDetails')->with(['updateSuccess' => 'Admin Account Updated']);
   }

   //admins list
   public function adminList(){
    $adminlist = User::when(request('search'),function($query){
            $query->orwhere('name','like','%'.request('search').'%')
                  ->orwhere('email','like','%'.request('search').'%')
                  ->orwhere('gender','like','%'.request('search').'%')
                  ->orwhere('phone','like','%'.request('search').'%')
                  ->orwhere('address','like','%'.request('search').'%');
            })
            ->where('role','admin')->paginate(3);
    $adminlist->appends(request()->all());
    return view('admin.account.adminlist',compact('adminlist'));
   }

   //adminlist delete
   public function adminListDelete($id){
    User::where('id',$id)->delete();
    return back()->with(['delSuccess'=> 'Success Admin List Deleted']);
   }

   //Change Role
   public function changeRole($id){
    $account = User::where('id',$id)->first();
    return view('admin.account.changerole',compact('account'));
   }

   // Change role update
   public function changeRoleUp($id, Request $request){
    $data = $this->requestUserData($request);
    User::where('id',$id)->update($data);
    return redirect()->route('admin#adminList');
   }

   //change role with ajax
   public function ajaxChangeRole(Request $request){
    User::where('id',$request->roleId)->update([
        'role'=>$request->currentrole
    ]);
   }

   //request role change data
   private function requestUserData($request){
    return [
        'role' =>$request->role
    ];
   }

   // request update user data
   private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender'=> $request->gender,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'updated_at'=> Carbon::now(),
        ];
   }

   //Account Validation
   private function accountValidationCheck($request){
    Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required',
        'gender' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'image' =>'mimes:png,jpg,jpeg,svg,webp,gif',

    ])->validate();
   }


   //Password Validation
   private function passwordValidationCheck($request){
    Validator::make($request->all(),[
        'oldpassword' => 'required|min:6',
        'newpassword' => 'required|min:6',
        'confirmedpassword' => 'required|min:6|same:newpassword',
    ])->validate();
   }
}
