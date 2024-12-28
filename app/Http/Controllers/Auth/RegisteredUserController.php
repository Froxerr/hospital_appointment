<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Models\InsuranceTypes;
use App\Models\LogRecords;
use App\Models\Patients;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $insurance_types = InsuranceTypes::all();
        return view('auth.register',compact('insurance_types'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'digits:11'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->logUserAction(Auth::user(),"Hasta kayıt işlemi başarıyla gerçekleştirildi.");


        $insurance_id = $request->insurance;
        $insurance_id = $this->InsuranceTypeRecord($insurance_id); //Sigorta verisini kaydediyoruz

        //Patients tablosunu doldurma işlemi
        $genderMapping = [
            'male' => 'E',
            'female' => 'K',
            'other' => 'D',
        ];
        $convertedGender = $genderMapping[$request->gender];

        $insuranceData = [
            'patients_insurances_id' => $insurance_id,
            'patients_name' => $request->name,
            'patients_surname' => $request->surname,
            'patients_phone' => $request->phone,
            'patients_gender' => $convertedGender,
            'patients_email' => $request->email
        ];

        Patients::create($insuranceData);

        return redirect('/');
    }

    private function InsuranceTypeRecord($insurance_type_id)
    {
        /*Insurance tablosunda sigortanın başlangıç ve bitiş tarihlerini şimdilik rastgele kendim oluşturacağım*/

        $startDate = Carbon::create(2023, 1, 1); // Örnek: 1 Ocak 2024
        $endDate = Carbon::create(2029, 12, 31); // Örnek: 31 Aralık 2025

        $randomDateStart = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
        do {
            $randomDateEnd = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
        } while ($randomDateEnd <= $randomDateStart);

        $InsuranceTypeData = [
            "insurance_type_id" => $insurance_type_id,
            "insurance_date_start" => $randomDateStart,
            "insurance_date_end" => $randomDateEnd,
        ];
        $insurance = Insurance::create($InsuranceTypeData);
        return $insurance->id;
    }
    private function logUserAction($user, $description, $badge = 'info')
    {
        LogRecords::create([
            'user_id' => $user->id,
            'log_description' => $description,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'badge' => $badge,
            'ip_address' => request()->ip(),  // Kullanıcının IP adresi
        ]);
    }
}
