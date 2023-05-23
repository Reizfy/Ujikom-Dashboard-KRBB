<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class EditMemberController extends Controller
{
    public function update(Request $request, $id)
    {
        // Retrieve the member from the database
        $member = Member::findOrFail($id);

        // Update the member's details based on the form input
        $member->name = $request->input('name');
        $member->age = $request->input('age');
        $member->email = $request->input('email');
        $member->phone = $request->input('phone');

        // Handle the uploaded photo
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($member->photo) {
                // Remove the old photo file from storage
                Storage::delete('public/assets/img/tables-photo/' . $member->photo);
            }

            // Upload and save the new photo
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/assets/img/tables-photo/', $photoName);
            $member->photo = $photoName;
        }

        // Save the updated member
        $member->save();

        // Redirect back to the original page or any other desired location
        return redirect()->back()->with('success', 'Member updated successfully.');
    }

    public function delete(Request $request, $id)
    {
        // Retrieve the member from the database
        $member = Member::findOrFail($id);

        // Delete the member's photo if it exists
        if ($member->photo) {
            // Remove the photo file from storage
            Storage::delete('public/assets/img/tables-photo/' . $member->photo);
        }

        // Delete the member
        $member->delete();

        // Redirect back to the original page or any other desired location
        return redirect('data-member')->with('success', 'Member deleted successfully.');
    }



}
