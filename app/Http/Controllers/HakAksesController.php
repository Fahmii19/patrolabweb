<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Wilayah;
use App\Models\HakAkses;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class HakAksesController extends Controller
{

    // private function get_permission($permissionNames, $feature)
    // {
    //     // dd($permissionNames, $feature);
    //     $found = false;
    //     dd($found);
    //     foreach ($permissionNames as $name) {
    //         if (strpos($name, $feature) !== false) {
    //             $found = true;
    //             dd($name);
    //             break;
    //         }
    //     }
    //     return $found ? 'checked' : '';
    // }


    public function index()
    {
        $data['title'] = 'Daftar Hak Akses';

        $role = Role::find(9);
        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role tidak ditemukan',
            ], 404);
        }



        $permission_menu = $role->permissions->pluck('fitur')->all();


        $permissions = []; // Inisialisasi array untuk menyimpan status 'checked'

        foreach ($permission_menu as $menu) {
            if (in_array($menu, ['menu', 'index', 'create', 'edit', 'show', 'destroy'])) {
                $permissions[$menu] = 'checked';
            }
        }

        $html = '<tr><th>' . htmlspecialchars($role->name) . '</th>';

        foreach (['menu', 'index', 'create', 'edit', 'show', 'destroy'] as $feature) {
            $checked = isset($permissions[$feature]) ? $permissions[$feature] : '';
            $html .= '<td><input class="form-check-input me-1" type="checkbox" ' . $checked . ' name="permissions[' . $feature . ']"></td>';
        }

        $html .= '</tr>';

        // dd($html);


        // $permissions = [
        //     'menu' => $this->get_permission($permission_title, 'menu'),
        //     'index' => $this->get_permission($permission_title, 'index'),
        //     'create' => $this->get_permission($permission_title, 'create'),
        //     'edit' => $this->get_permission($permission_title, 'edit'),
        //     'show' => $this->get_permission($permission_title, 'show'),
        //     'destroy' => $this->get_permission($permission_title, 'destroy'),
        // ];

        // dd($permissions);


        return view('super-admin.hak-akses.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Hak Akses';
        $data['permission'] = Permission::all();
        $data['wilayah'] = Wilayah::all();
        return view('super-admin.hak-akses.create', $data);
    }

    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles',
                'permission_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $validator->validated();
            $role = Role::create(['name' => $request->name]);
            foreach ($request->permission_id as $item) {
                $permission = Permission::find($item);
                $permission->assignRole($role);
            }
            return redirect()->route('hak-akses.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            Log::debug('HakAksesController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data['title'] = 'Detail Hak Akses';
        $data['hak_akses'] = HakAkses::find($id);
        return view('super-admin.hak-akses.show', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Hak Akses';
        $data['hak_akses'] = HakAkses::find($id);
        return view('super-admin.hak-akses.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'role_name' => 'required',
                'permission_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            HakAkses::find($id)->update($data);
            DB::commit();
            return redirect()->route('hak-akses.index')->with('success', 'Data Berhasil Diedit');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('HakAksesController update() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            HakAkses::find($id)->delete();
            DB::commit();
            return redirect()->route('hak-akses.index')->with('success', 'Data Berhasil Dihapus');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('HakAksesController destroy() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function datatable()
    {
        $data = Role::where('name', '!=', 'super-admin')->where('name', '!=', 'user')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('active')
            ->addColumn('name', '{{$name}}')
            ->addColumn('permission', function (Role $role) {
                $permission = '';
                foreach ($role->permissions as $item) {
                    $permission .= $item->name . '<br>';
                }
                return $permission;
            })
            ->addColumn('action', function (Role $role) {
                $data = [
                    'editurl' => route('hak-akses.edit', $role->id),
                    'deleteurl' => route('hak-akses.destroy', $role->id)
                ];
                return $data;
            })
            ->toJson();
    }

    public function get_hak_akses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'input tidak valid',
                'data' => $validator->errors()
            ], 401);
        }
        $data = Role::find($request->id);
        // $permission_title = $data->permissions->pluck('name')->all();
        // $permission_menu = $data->permissions->pluck('fitur')->all();

        // $permissions = [
        //     'menu' => $this->get_permission($permission_title, $permission_menu),
        //     'index' => $this->get_permission($permission_title, $permission_menu),
        //     'create' => $this->get_permission($permission_title, $permission_menu),
        //     'edit' => $this->get_permission($permission_title, $permission_menu),
        //     'show' => $this->get_permission($permission_title, $permission_menu),
        //     'destroy' => $this->get_permission($permission_title, $permission_menu),
        // ];

        // $html = '<tr><th>' . htmlspecialchars($data->name) . '</th>'; // Asumsi Anda ingin menampilkan nama role

        // foreach ($permissions as $feature => $checked) {
        //     $html .= '<td><input class="form-check-input me-1" type="checkbox" ' . $checked . ' name="permissions[' . $feature . ']"></td>';
        // }

        // $html .= '</tr>';


        $permission_menu = $data->permissions->pluck('fitur')->all();


        $permissions = []; // Inisialisasi array untuk menyimpan status 'checked'

        foreach ($permission_menu as $menu) {
            if (in_array($menu, ['menu', 'index', 'create', 'edit', 'show', 'destroy'])) {
                $permissions[$menu] = 'checked';
            }
        }

        $html = '<tr><th>' . htmlspecialchars($data->name) . '</th>';

        foreach (['menu', 'index', 'create', 'edit', 'show', 'destroy'] as $feature) {
            $checked = isset($permissions[$feature]) ? $permissions[$feature] : '';
            $html .= '<td><input class="form-check-input me-1" type="checkbox" ' . $checked . ' name="permissions[' . $feature . ']"></td>';
        }

        $html .= '</tr>';


        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data',
            'data' => $html
        ], 200);
    }
}
