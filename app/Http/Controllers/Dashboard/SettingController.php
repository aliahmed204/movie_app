<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function general()
    {
        return view('dashboard.settings.general');
    }

     public function store(Request $request)
     {
         $request->validate([
            'email' => 'sometimes|required|email',
         ]);
         $requestData = $request->except(['_token','_method']);

         if($request->logo){
             Storage::disk('local')->delete('public/uploads'.setting('logo'));
             $request->logo->store('public/uploads');
             $requestData['logo'] = $request->logo->hashName();
         }

         if($request->fav_icon){
             Storage::disk('local')->delete('public/uploads'.setting('fav_icon'));
             $request->fav_icon->store('public/uploads');
             $requestData['fav_icon'] = $request->fav_icon->hashName();
         }

         setting($requestData)->save();
         return back()->with('success','data saved successfully');

     }
}
