<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;

class UserSatkerController extends Controller
{
    public function index(Request $request)
    {
        return view('master_data.usersatker', [
        ]);
    }

    public function getUserSatkerDT(Request $request) {
        $userSatker = \App\Models\User::orderBy('users.email', 'asc')
                    ->select('users.id', 'users.name', 'users.email')
                    ->get();

        return Datatables::of($userSatker)
                ->addIndexColumn()
                ->addColumn('reset', function($userSatker) {
                    return "<button class='btn btn-warning btn-sm btn-block' onclick='goResetPassword(" . $userSatker->id . ")'>Reset Password</button>";
                })
                ->rawColumns(['reset'])
                ->toJson();
    }

    public function getUserSatker($id) {
        $userSatker = \App\Models\User::where('users.id', $id)
                    ->select('users.*')
                    ->first();

        if($userSatker) {
            return response()->json($userSatker);
        } else {
            return response()->json(["success" => 0, "message" => "Tidak ada data user ditemukan"]);
        }
    }

    public function add(Request $request)
    {
        $user = new \App\Models\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->pass1);
        $user->user_type = "admin_satker";
        $user->id_satuan_kerja = 0;
        $user->save();

        return response()->json(["success" => 1, "message" => "Berhasil menambah user satker"]);
    }

    public function resetPassword(Request $request)
    {
        $user = \App\Models\User::find($request->id);
        $user->password = Hash::make($request->pass1);
        $user->save();

        return response()->json(["success" => 1, "message" => "Berhasil merubah password user satker"]);
    }
}
