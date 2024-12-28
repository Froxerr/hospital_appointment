<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\LogRecords;
use App\Models\Pages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $pagesData = Pages::all();

        if(Auth::check())
        {
            Auth::id();

            $user = User::where('id', Auth::id())->first();

            $role_id = $user->role_id;
        }
        else
        {
            $role_id = 0;
        }
        return view('front.contact',compact('pagesData','role_id'),['showFooter' => false]);
    }

    public function store(Request $request)
    {
        $requestData = $request->validate([
            'contact_name' => 'required|max:255',
            'contact_email' => 'required|email:rfc,dns',
            'contact_subject' => 'required|max:255',
            'contact_message' => 'required',
        ]);

        Contact::create($requestData);
        $this->logUserAction("İletişim bilgisi başarıyla kaydedildi.",Auth::user());

        session()->flash("swal_message","Mesajınız başarılı şekilde gönderilmiştir.");
        session()->flash("swal_type","success");


        return redirect('/contact');
    }
    private function logUserAction($description, $user = null, $badge = 'info')
    {
        // Eğer kullanıcı giriş yapmamışsa anonim kullanıcıyı kullan
        if (!$user) {
            $user = (object) [
                'id' => 1,  // Anonim kullanıcı için bir id belirleyin
                'name' => 'Anonim Kullanıcı',
                'email' => 'anonim@noemail.com'
            ];
        }

        LogRecords::create([
            'user_id' => $user->id,
            'log_description' => $description,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'badge' => $badge,
            'ip_address' => request()->ip(),
        ]);
    }
}
