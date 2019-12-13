<?php
namespace App\Http\Controllers\jew\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexContorller extends Controller
{
    public function index(Request $request)
    {
        return view('jew.admin.index.index');
    }
    
    public function index_do()
    {
        echo 111;
    }
}
