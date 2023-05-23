<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberListController extends Controller
{
    public function list()
    {
        $members = Member::all();
        return view('laravel-examples/data-member', compact('members'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 5);

        $membersQuery = Member::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('age', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%');
            });

        $results = $membersQuery->get();


        $members = $membersQuery->paginate($perPage);

        return view('laravel-examples/data-member', compact('members'));
    }
}
