<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\AccessLogin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccessAdminController extends Controller
{
    protected $request;
    protected $accessLogin;
    protected $data = [];

    public function __construct(Request $request, AccessLogin $accessLogin)
    {
        $this->request = $request;
        $this->accessLogin = $accessLogin;
    }

    public function getLogin()
    {
        $data = $this->data;

        return view(env('ADMIN_TEMPLATE').'.login.login', $data);
    }

    public function postLogin()
    {
        $this->validate($this->request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = $this->accessLogin->cekLogin($this->request->get('username'), $this->request->get('password'), 'username');
        if ($user) {

            $this->request->session()->flush();
            $this->request->session()->put('admin_id', $user->id);
            $this->request->session()->put('admin_name', $user->name);
            $this->request->session()->put('admin_login', 1);

            return redirect()->route('admin');
        }
        else {
            return redirect()->back()->withInput()->withErrors(
                [
                    'error_login' => __('general.error_login')
                ]
            );
        }
    }

    public function doLogout()
    {
        $this->request->session()->flush();
        return redirect()->route('admin.login');
    }

}
