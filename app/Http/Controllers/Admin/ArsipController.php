<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanIkmArsip;

class ArsipController extends Controller
{
    public function index()
    {
        $arsip = LaporanIkmArsip::latest()->paginate(10);
        return view('admin.arsip', compact('arsip'));
    }
}