<?php

namespace App\Http\Controllers;

use App\KantorCabang;
use App\User;
use Faker\Provider\password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

	public function index(Request $request)
	{

		if ($request->ajax()) {
			$data = User::query();
			return Datatables::of($data)
			->addIndexColumn()
			->addColumn('name', function ($row) {
				$name = $row->name;
				return $name;
			})     
			->addColumn('email', function ($row) {
				$email = $row->email;
				return $email;
			})     
			->addColumn('cabang', function ($row) {
				$cabang = optional($row->getCabang)->cabang;
				return $cabang;
			})     
			->addColumn('role', function ($row) {
				$role = $row->getRoleNames()->first();
				return $role;
			})     
			->addColumn('action', function ($row) {
				$action =  '<a class="btn btn-sm btn-warning" href="'.action('UserController@edit', $row->id).'" >Edit</a>';
				$action = $action .  '<a class="btn btn-sm btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="'.action('UserController@delete', $row->id).'"  data-toggle="tooltip" data-placement="top" title="Edit" >Hapus</a>';

				return $action;
			})
			->rawColumns(['action'])
			->make(true);
		}

		return view('backend.user.index');	
	}

	public function create()
	{
		$cabang  = KantorCabang::pluck('cabang','id');

		return view('backend.user.create', compact('cabang'));	
	}

	public function store(Request $request)
	{
		$request->validate([
			'username' => 'required',
			'email' => 'required',
			'password' => 'required|confirmed|min:6',
			'role' => 'required',
			'cabang' => 'required',
		]);

		DB::beginTransaction();
		try {
			$user = User::create([
				'name' => $request->username,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'cabang_id' => $request->cabang,
				'created_by' => auth()->user()->id,
			]);
			if($request->role == 'admin'){
				$user->assignRole('admin');
			}

			if($request->role == 'user'){
				$user->assignRole('user');
			}


		} catch (\Exception $e) {
			DB::rollback();
			toastr()->error($e->getMessage(), 'Error');
			return back();
		}catch (\Throwable $e) {
			DB::rollback();
			toastr()->error($e->getMessage(), 'Error');
			throw $e;
		}

		DB::commit();
		toastr()->success('Data telah ditambahkan', 'Berhasil');
		return redirect(action('UserController@index'));
	}

	public function edit($id)
	{
		$data = User::find($id);
		$cabang = KantorCabang::pluck('cabang','id');
		return view('backend.user.edit', compact('data','cabang'));
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'username' => 'required',
			'email' => 'required',
			'role' => 'required',
			'cabang' => 'required',
		]);

		DB::beginTransaction();
		try {
			// dd($request->password);
			$user = User::find($id);
			$pass = empty($request->password) ? $user->password : Hash::make($request->password);
			User::where('id', $id)->update([
				'name' => $request->username,
				'email' => $request->email,
				'password' =>  $pass,
				'cabang_id' => $request->cabang,
				'created_by' => auth()->user()->id,
			]);

			if($user->getRoleNames()->first() != $request->role)
			{
				$user->removeRole($user->getRoleNames()->first());
				$user->assignRole($request->role);
			}


		} catch (\Exception $e) {
			DB::rollback();
			toastr()->error($e->getMessage(), 'Error');
			return back();
		}catch (\Throwable $e) {
			DB::rollback();
			toastr()->error($e->getMessage(), 'Error');
			throw $e;
		}

		DB::commit();
		toastr()->success('Data telah diubah', 'Berhasil');
		return redirect(action('UserController@index'));
	}

    public function destroy($id)
    {
    	$data = User::find($id);
    	$data->delete();
    	toastr()->success('Data telah hapus', 'Berhasil');
    	return back();
    }


    public function delete($id)
    {
    	$data = User::find($id);
    	return view('backend.user.delete', compact('data'));
    }
}
