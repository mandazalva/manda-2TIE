<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan; // <-- JANGAN LUPA TAMBAHKAN INI

class PelangganController extends Controller
{
    public function index()
    {
        $data['dataPelanggan'] = Pelanggan::all();
        return view('admin.pelanggan.index', $data);
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    use App\Models\Pelanggan;

public function store(Request $request){

		//dd($request->all())

		$data['first_name'] = $request->first_name;
		$data['last_name'] = $request->last_name;
		$data['birthday'] = $request->birthday;
		$data['gender'] = $request->gender;
		$data['email'] = $request->email;
		$data['phone'] = $request->phone;

		Pelanggan::create($data);

		return redirect()->route('pelanggan.index')->with('success','Penambahan Data Berhasil!');
}
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());
        return redirect()->route('pelanggan.index')->with('success','Data Berhasil Diperbarui!');
    }

    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success','Data Berhasil Dihapus!');
    }
}
