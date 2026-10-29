<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    // INI YANG BENAR UNTUK QUESTION CONTROLLER
    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|max:10',
            'email' => ['required','email'],
            'pertanyaan' => 'required|max:300|min:8',
        ]);

        return redirect()->route('home')->with('info', 'Pertanyaan berhasil dikirim!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
