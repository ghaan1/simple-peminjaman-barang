<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user.index')->only('index');
        $this->middleware('permission:user.create')->only('create', 'store');
        $this->middleware('permission:user.edit')->only('edit', 'update');
        $this->middleware('permission:user.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = DB::table('profile_users')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('users.name', 'like', '%' . $name . '%');
            })
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'profile_users.id as profile_id',
                'profile_users.nik',
                'profile_users.tanggal_lahir',
                'profile_users.alamat',
                'profile_users.jenis_kelamin',
                'profile_users.no_hp',
                'profile_users.foto',
                'profile_users.ktp',
                DB::raw("DATE_FORMAT(users.created_at, '%d %M %Y') as created_at"),
                DB::raw("DATE_FORMAT(users.email_verified_at, '%d %M %Y') as email_verified_at")
            )
            ->leftJoin('users', 'profile_users.user_id', '=', 'users.id')
            ->orderBy('profile_users.created_at', 'desc')
            ->paginate(10);

        return view('users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // halaman tambah user
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //simpan data
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect(route('user.index'))->with('success', 'Data Berhasil Ditambahkan');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //nampilkan detail satu user
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //mengupdate data user ke database
        $validate = $request->validated();

        $user->update($validate);
        return redirect()->route('user.index')->with('success', 'User Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('user.index')
                ->with('success', 'Hapus Data User Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('user.index')
                    ->with('error', 'Tidak Dapat Menghapus Data User Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('user.index')
                    ->with('success', 'Hapus Data User Sukses');
            }
        }
    }

    public function export()
    {
        // export data ke excel
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(Request $request)
    {
        // import excel ke data tables
        $users = Excel::toCollection(new UsersImport, $request->import_file);
        foreach ($users[0] as $user) {
            User::where('id', $user[0])->update([
                'name' => $user[1],
                'email' => $user[2],
                'password' => $user[3],
            ]);
        }
        return redirect()->route('user.index');
    }

    public function verifyEmail($id, $hash)
    {
        $user = User::findOrFail($id);

        if (sha1($user->email) !== $hash) {
            abort(404);
        }

        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();

            return redirect()->route('user.index')->with('success', 'Email verified successfully');
        } else {
            $user->email_verified_at = null;
            $user->save();

            return redirect()->route('user.index')->with('success', 'Email verification deleted successfully');
        }
    }
}
