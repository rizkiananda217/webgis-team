<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\list_pariwisata;

class list_pariwisata_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pariwisata = list_pariwisata::get();
        return \view('index', ['pariwisata' => $pariwisata]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pariwisata = list_pariwisata::find($id);
        return \view('detail', ['pariwisata' => $pariwisata]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cari data wisata berdasarkan ID
        $pariwisata = list_pariwisata::find($id);

        // Jika data tidak ditemukan
        if (!$pariwisata) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Hapus file gambar jika ada
        if ($pariwisata->image && file_exists(storage_path('app/public/img/' . $pariwisata->image))) {
            unlink(storage_path('app/public/img/' . $pariwisata->image));
        }

        // Hapus data dari database
        $pariwisata->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Destinasi berhasil dihapus.');
    }
}
