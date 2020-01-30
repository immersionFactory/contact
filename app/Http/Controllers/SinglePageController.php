<?php

namespace App\Http\Controllers;

use App\Mail\NewContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SinglePageController extends Controller {
    public function index() {
        return view('app');
    }

    public function ajax_post_contact() {
        $request = Request::capture();

        $request->validate([
            'name'    => 'required',
            'email'   => 'email',
            'phone'   => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $contactInfo = [
            'name'    => $request->get('name'),
            'email'   => $request->get('email'),
            'phone'   => $request->get('phone'),
            'company' => $request->get('company'),
            'subject' => $request->get('subject'),
            'message' => $request->get('message'),
        ];

        //uncomment to get output of email in response
//        return (new NewContact($contactInfo))->render();

        //uncomment to force fail
//        return response()->json(['status' => 'error'], 500);


        try {
            Mail::to("ryan@immersionfactory.com")->send(new NewContact($contactInfo));
            if( count(Mail::failures()) > 0 ) {
                return response()->json(['status' => 'error'], 500);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            //uncomment to fail on error and show error message
            return response()->json(['status' => 'error'], 500);
        }

        return response()->json(['status' => 'success'], 201);
    }
}
