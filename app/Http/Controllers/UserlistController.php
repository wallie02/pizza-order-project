<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserlistController extends Controller
{
    // user list
    public function userList(){
        $userlist = User::where('role','user')->paginate(5);
        return view('admin.userlist.listuser', compact('userlist'));
    }

    // ajax role change
    public function ajaxuserChangeRole(Request $request){
        User::where('id',$request->roleId)->update([
            'role'=>$request->currentrole
        ]);
    }

    //delete
    public function deleteUser($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSS'=>' User Deleted Success']);
    }


    //update user page
    public function updatePage($id){
        $userup = User::where('id',$id)->first();
        return view('admin.userlist.accoutedit',compact('userup'));
    }

    // change account
    public function updateAcc(Request $request){
            $this->accountValidationCheck($request);
            $data = $this->getUserData($request);

            // for image uploading
            if($request->hasFile('image')){

                $oldImage = User::where('id',$request->userid)->first();
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

            User::where('id',$request->userid)->update($data);
            return redirect()->route('admin#userList');
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
    }


