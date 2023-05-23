<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class InsertMemberController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'age' => 'required|numeric',
            'email' => 'required',
            'phone' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $member = new Member;
        $member->name = $validatedData['name'];
        $member->age = $validatedData['age'];
        $member->email = $validatedData['email'];
        $member->phone = $validatedData['phone'];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
        
            $image = getimagesize($photo);
            $width = $image[0];
            $height = $image[1];
        
            if ($width == $height) {
                $photo->move(public_path('assets/img/tables-photo/'), $photoName);
                $member->photo = $photoName;
            } else {
                return redirect('data-member')->with('error', 'The photo must have a 1:1 aspect ratio.');
            }
        }
        

        $member->save();

        return redirect('data-member')->with('success', 'Member added successfully');
    }
}
