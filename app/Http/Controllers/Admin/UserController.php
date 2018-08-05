<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\AdminUserDataTable;

class UserController extends Controller
{
    public function index(AdminUserDataTable $dataTable)
    {
        $header = "Todos los usuarios del sistema";
        return $dataTable->render('datatables.index', compact('header'));
    }
}
