<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_GeneralController;
use App\Codes\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends _GeneralController
{
    protected $profileData;
    protected $passwordData;

    public function __construct(Request $request)
    {
        $listAll = json_decode(json_encode([
            'name' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            'username' => [
                'validate' => [
                    'store' => 'required|unique:admin',
                    'update' => 'required|unique'
                ],
                'table' => 'admin',
            ],
            'password' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
                'type' => 'password',
                'list' => 0,
                'update' => 0,
                'show' => 0,
            ],
            'action' => [
                'custom' => ', orderable: false, searchable: false',
                'store' => 0,
                'update' => 0,
                'show' => 0,
            ],
        ]));

        parent::__construct(
            $request, 'Admin', 'admin', 'Admin', 'general',
            $listAll
        );

        $this->profileData = json_decode(json_encode([
            'username' => [
                'validate' => 'required',
                'lang' => 'general.username',
                'type' => 'text',
                'field_message' => ''
            ],
            'name' => [
                'validate' => 'required',
                'lang' => 'general.name',
                'type' => 'text',
                'field_message' => ''
            ]
        ]));

        $this->passwordData = json_decode(json_encode([
            'old_password' => [
                'validate' => 'required',
                'lang' => 'general.old_password',
                'type' => 'password',
                'field_message' => ''
            ],
            'password' => [
                'validate' => 'required|confirmed',
                'lang' => 'general.password',
                'type' => 'password',
                'field_message' => ''
            ],
            'password_confirmation' => [
                'validate' => 'required',
                'lang' => 'general.password_confirmation',
                'type' => 'password',
                'field_message' => ''
            ]
        ]));
    }

    public function dashboard()
    {
        $data = $this->data;

        return view(env('ADMIN_TEMPLATE').'.dashboard.dashboard', $data);
    }

    public function profile()
    {
        $admin_id = $this->request->session()->get('admin_id');
        if(!$admin_id) {
            return redirect()->route('admin.login');
        }
        $data = [];

        $get_data = Admin::where('id', $admin_id)->first();

        $data['data'] = $get_data;
        $data['this_label'] = __('general.profile');
        $data['this_route'] = 'profile';
        $data['passing'] = $this->profileData;

        return view(env('ADMIN_TEMPLATE').'.profile.show', $data);
    }

    public function getProfile()
    {
        $admin_id = $this->request->session()->get('admin_id');
        if(!$admin_id) {
            return redirect()->route('admin.login');
        }
        $data = $this->data;

        $get_data = Admin::where('id', $admin_id)->first();

        $data['data'] = $get_data;
        $data['this_label'] = __('general.profile');
        $data['this_route'] = 'profile';
        $data['passing'] = $this->profileData;

        return view(env('ADMIN_TEMPLATE').'.profile.edit', $data);
    }

    public function postProfile()
    {
        $admin_id = $this->request->session()->get('admin_id');
        if(!$admin_id) {
            return redirect()->route('admin.login');
        }

        $validator = [
            'username' => 'required|unique:admin,username,'.$admin_id,
            'name' => 'required'
        ];

        $data = $this->validate($this->request, $validator);

        $this->request->session()->put('admin_name', $data['name']);

        $getDate = Admin::where('id', $admin_id)->first();
        foreach ($validator as $key => $value) {
            $getDate->$key = $this->request->get($key);
        }
        $getDate->save();

        $this->request->session()->flash('message', __('general.success_update'));
        $this->request->session()->flash('message_alert', 2);

        return redirect()->route('admin.profile');

    }

    public function getPassword()
    {
        $admin_id = $this->request->session()->get('admin_id');
        if(!$admin_id) {
            return redirect()->route('admin.login');
        }
        $data = $this->data;

        $get_data = Admin::where('id', $admin_id)->first();

        $data['data'] = $get_data;
        $data['this_label'] = __('general.password');
        $data['this_route'] = 'profile';
        $data['passing'] = $this->passwordData;

        return view(env('ADMIN_TEMPLATE').'.profile.password', $data);
    }

    public function postPassword()
    {
        $admin_id = $this->request->session()->get('admin_id');
        if(!$admin_id) {
            return redirect()->route('admin.login');
        }

        $data = $this->validate($this->request, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $account = Admin::where('id', $admin_id)->first();
        if(!$account) {
            return redirect()->route('admin.profile');
        }

        if(!app('hash')->check($data['old_password'], $account->password)) {
            return redirect()->back()->withInput()->withErrors(
                [
                    'password' => __('general.error_old_password')
                ]
            );
        }

        $getDate = Admin::where('id', $admin_id)->first();
        $getDate->password = app('hash')->make($data['password']);
        $getDate->save();

        $this->request->session()->flash('message', __('general.success_update'));
        $this->request->session()->flash('message_alert', 2);

        return redirect()->route('admin.profile');
    }

}
