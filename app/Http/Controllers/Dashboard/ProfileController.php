<?php

namespace App\Http\Controllers\Dashboard;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit(){

        $user = Auth::user() ;
        return view('dashboard.profile.edit',[
            'user' => $user,
            'countries' => Countries::getNames('en'), //راح ترجع اري بكي وفاليو
            'locales' => Languages::getNames('en') //config('locale')
        ]);
    }
    public function update(Request $request ){
        $request->validate([
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'birthday' => ['nullable' , 'date' , 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required','string','size:2'],
        ]);

        $user = Auth::user(); // OR $user = $request->user();

        $user->profile->fill( $request->all() )->save(); //انه ازا لقت البروفايل فاضي بتعمل انسيرت وبتعبيه ازا لقت فيه داتا بتعمل ابديت على هذه الداتا  fill  وظيفة ال

        return redirect()->route('dashboard.profile.edit')->with('success','Updated successfally');
    }
}
