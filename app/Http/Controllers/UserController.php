<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\User;
use App\Models\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Daftar User";
        return view('super-admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah User";
        $data['guard'] = Guard::doesntHave('user')->get();
        $data['role'] = Role::where('name', '!=', 'super-admin')
            ->where('name', '!=', 'user')
            ->get();
        return view('super-admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'guard_id' => 'required|numeric',
                'role' => 'required',
                'password' => 'required',
                'status' => 'required|in:ACTIVED,INACTIVED'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $validator->validated();

            // dd($request->role);

            $guard = Guard::find($request->guard_id);

            $data_user = [
                'guard_id' => $guard->id,
                'name' => $guard->name,
                'no_badge' => $guard->badge_number,
                'email' => $guard->email,
                'password' => bcrypt($request->password),
                'status' => $request->status
            ];
            $usr = User::create($data_user);
            $usr->assignRole($request->role);
            // foreach ($request->role as $item) {
            //     // $usr->assignRole($item);
            // }
            DB::commit();
            return redirect()->route('user.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('UserController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = "Edit User";
        // $data['guard'] = Guard::doesntHave('user')->get();
        // $data['role'] = Role::where('name', '!=', 'super-admin')
        //     ->where('name', '!=', 'user')
        //     ->get();
        $data['user'] = User::find($id);

        // Pastikan user ditemukan sebelum mencoba mengakses metode pada objeknya
        if (!$data['user']) {
            // Handle kasus di mana user tidak ditemukan, misalnya tampilkan pesan error atau redirect
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $roleNames = $data['user']->getRoleNames(); // Menggunakan variabel $data['user'] yang sudah didefinisikan
        return view('super-admin.user.edit', $data, compact('roleNames'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'role' => 'required', // Pastikan role diisi
                'password' => 'nullable',
                'status' => 'required|in:ACTIVED,INACTIVED'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $usr = User::find($id);
            if (!$usr) {
                throw new Exception('User tidak ditemukan.');
            }

            // dd($request->role);

            // Update role user
            $usr->syncRoles($request->role); // Menggunakan syncRoles untuk update peran

            // Update data user lainnya
            $data_user = ['status' => $request->status];
            if ($request->password) {
                $data_user['password'] = bcrypt($request->password);
            }
            $usr->update($data_user);

            DB::commit();
            return redirect()->route('user.index')->with('success', 'Data Berhasil Diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('UserController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            DB::beginTransaction();

            $action = $user->delete();
            DB::commit();

            if ($action) {
                return redirect()->route('user.index')->with('success', 'data user berhasil dihapus');
            }
            DB::rollback();
            return redirect()->back()->with('error', 'data user gagal dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('UserController destroy ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {

        // $data = User::where('id', '!=', 1)->get(); // Mengambil semua pengguna kecuali yang memiliki id = 1

        // foreach ($data as $user) {
        //     // Di sini Anda bisa menggunakan $user->getRoleNames() untuk mendapatkan peran pengguna
        //     $roleNames = $user->getRoleNames()->toArray();
        //     $roles = implode(', ', $roleNames);

        //     // Lakukan sesuatu dengan $roles, misalnya menampilkannya atau menyimpannya
        //     echo "User: " . $user->name . " - Roles: " . $roles . "\n";
        // }


        $data = User::where('id', '!=', 1)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$name}}')
            ->addColumn('no_badge', '{{$no_badge}}')
            ->addColumn('role', function (User $user) {
                return implode(', ', $user->getRoleNames()->toArray());
            })
            ->addColumn('created_at', function (User $user) {
                return date('d M y', strtotime($user->created_at));
            })
            ->addColumn('status', '{{$status}}')
            ->addColumn('action', function (User $user) {
                return [
                    'editurl' => route('user.edit', $user->id),
                    'deleteurl' => route('user.destroy', $user->id)
                ];
            })

            ->toJson();
    }
}
