<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function edit($id)
    {
        // Validasi agar user tidak membuka profile user lain
        if($id != auth()->id()){
            return redirect()->route('profile.edit', auth()->id());
        }

        $profile = User::find($id);
        
        return view('profile.edit', [
            "title" => "Edit Profile",
            "user" => $profile
        ]);
    }

    public function update(Request $request, $id) {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,'. $id,
                'password' => 'nullable',
                'img_avatar' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $user = User::find($id);
            if (!$user) {
                throw new Exception('User tidak ditemukan.');
            }

            $filename = $user->img_avatar;
            if ($request->hasFile('img_avatar')) {
                $file = $request->file('img_avatar');
                $currentDateTime = date('His');
                $filename = $currentDateTime . '_' . $file->getClientOriginalName();
                $file->move(public_path('gambar/profile'), $filename);

                if ($user->img_avatar && file_exists(public_path('gambar/profile/' . $user->img_avatar))) {
                    unlink(public_path('gambar/profile/' . $user->img_avatar));
                }
            }

            // Update data user lainnya
            $data = $validator->validated();
            $data_user = [
                'name' => $data['name'],
                'email' => $data['email'],
                'img_avatar' => $filename,
                'created_at' => $user->created_at,
                'updated_at' => now(),
            ];

            if ($request->password) {
                $data_user['password'] = bcrypt($request->password);
            }

            $user->update($data_user);
            DB::commit();

            insert_audit_log('Update profile user');
            redis_reset_api('user/spesific/'.$id);
            return redirect('/dashboard')->with('success', 'Profile berhasil diedit');

        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('ProfileController update() error:' . $e->getMessage());
            return redirect()->back()->with('error', 'Profile gagal diedit: ' . $e->getMessage());
        }
    }
}
