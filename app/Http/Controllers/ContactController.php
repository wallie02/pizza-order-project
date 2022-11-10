<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

  //contact lists from admin
    public function contactList(){
        $contactlist = Contact::orderBy('id','desc')->paginate(5);
        return view('admin.contactform.contactlist',compact('contactlist'));
    }


    //contact box from user
    public function contactPage(){
        return view('user.contact.contactbox');
    }

    //create contact
    public function sendContact(Request $request){
        $this->contactValidationCheck($request);
        $data = $this->requestData($request);
        Contact::create($data);
        return back();
    }

    //delete
    public function deleteContact($id){
        Contact::where('id',$id)->delete();
        return back()->with(['deleSuccess'=> 'Success Contact List Deleted']);
    }

    //request data
    private function requestData($request){
        return [
            'name' => $request->contactName,
            'email' => $request->contactEmail,
            'message' => $request->message,
        ];
    }

    //contact validation
    private function contactValidationCheck($request){
        Validator::make($request->all(),[
            'contactName' => 'required',
            'contactEmail' => 'required',
            'contactMessage' => 'required',
        ])->validate();
    }


}
