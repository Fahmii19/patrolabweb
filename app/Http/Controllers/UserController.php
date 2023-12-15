<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Area;
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
        $data['title'] = "Tambah User (Admin Area)";
        $data['area'] = Area::all(); // Data area untuk admin-area
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
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required',
                'area.*' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            if ($request->area == null) {
                return redirect()->back()->withErrors(['area' => 'Area wajib dipilih, minimal satu']);
            }

            $validator->validated();

            $data_user = [
                'access_area' => implode(',', $request->area),
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => 'ACTIVED',
            ];

            $user = User::create($data_user);

            if ($user) {
                $user->assignRole('admin-area');
                DB::commit();
                return redirect()->route('user.index')->with('success', 'Admin Area Berhasil Ditambahkan');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'Admin Area Gagal Ditambahkan');
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
        $data['user'] = User::find($id);
        $data['area'] = Area::all();

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
                'role' => 'required|string',
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'nullable',
                'area.*' => 'nullable|string',
                'status' => 'nullable|in:ACTIVED,INACTIVED'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }


            $user = User::find($id);
            if (!$user) {
                throw new Exception('User tidak ditemukan.');
            }

            // Update data user lainnya
            $data = $validator->validated();
            $data_user = [
                'name' => $data['name'],
                'email' => $data['email'],
                'status' => $data['status'] ?? 'INACTIVED'
            ];

            // Check jika hak akses user sebagai admin area
            if ($request->role == 'admin-area') {

                if ($request->area == null) {
                    return redirect()->back()->withErrors(['area' => 'Area wajib dipilih, minimal satu']);
                }

                $data_user['access_area'] = implode(',', $request->area);
            }

            // Check jika password tidak kosong
            if ($request->password) {
                $data_user['password'] = bcrypt($request->password);
            }

            if ($user->update($data_user)){
                DB::commit();
                return redirect()->route('user.index')->with('success', 'User Berhasil Diedit');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'User Gagal Diedit');
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

            if ($user->delete()) {
                DB::commit();
                return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
            }

            DB::rollback();
            return redirect()->back()->with('error', 'User gagal dihapus');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug('UserController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = User::with('data_guard')->where('id', '!=', 1)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$name}}')
            ->addColumn('no_badge', '{{$guard_id ? $data_guard["badge_number"] : "-"}}')
            ->addColumn('access_area', function(User $user) {
                if ($user->access_area) {
                    $list_area = "";
                    $areas = explode(',', $user->access_area);
                    foreach($areas as $item){
                        $area = Area::where('id', $item)->pluck('name');
                        $list_area .= $area[0] . ', ';
                    }

                    return rtrim($list_area, ', ');
                }
                return "-";
            })
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
