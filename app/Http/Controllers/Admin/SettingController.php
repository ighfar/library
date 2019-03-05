<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_GeneralController;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SettingController extends _GeneralController
{
    public function __construct(Request $request)
    {
        $listAll = json_decode(json_encode([
            'id' => [
                'store' => 0,
                'update' => 0,
                'show' => 0,
            ],
            'name' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            'key' => [
                'validate' => [
                    'store' => 'required',
                ],
                'update' => 0,
                'list' => 0,
            ],
            'type' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
                'type' => 'select',
                'update' => 0,
                'list' => 0,
            ],
            'value' => [
                'type' => 'text',
            ],
            'action' => [
                'custom' => ', orderable: false, searchable: false',
                'store' => 0,
                'update' => 0,
                'show' => 0,
            ],
        ]));

        parent::__construct(
            $request, 'Settings', 'setting', 'Setting', 'general',
            $listAll,
            [
                'create' => false,
                'delete' => false
            ]
        );

        $this->data['set_list'] = [
            'type' => get_list_type_setting(),
            'value' => get_list_active_inactive()
        ];

    }

    public function dataTable()
    {
        $dataTables = new DataTables();

        $builder = $this->model::query()->select('*');

        return $dataTables->eloquent($builder)
            ->editColumn('value', function ($query) {
                if ($query->type == 'select') {
                    $get_list = isset($this->data['set_list']['value']) ? $this->data['set_list']['value'] : [];
                    return isset($get_list[$query->value]) ? $get_list[$query->value] : $query->value;
                }
                else {
                    return $query->value;
                }
            })
            ->addColumn('action', function ($query) {
                return view(env('ADMIN_TEMPLATE') . '.general.table_button', ['query' => $query, 'this_route' => $this->route, 'permission' => $this->permission]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($id)
    {
        $data = $this->data;

        $getData = $this->crud->show($id);
        if (!$getData) {
            return redirect()->route('admin.' . $this->route . '.index');
        }

        $this->viewData->value->type = $getData->type;

        $data['id'] = $id;
        $data['data'] = $getData;
        $data['passing'] = $this->viewData;
        $data['permission'] = $this->permission;

        return view(env('ADMIN_TEMPLATE') . '.' . $this->view . '.show', $data);
    }

    public function edit($id)
    {
        $data = $this->data;

        $getData = $this->crud->show($id);
        if (!$getData) {
            return redirect()->route('admin.' . $this->route . '.index');
        }

        $this->updateData->value->type = $getData->type;

        $data['id'] = $id;
        $data['data'] = $getData;
        $data['passing'] = $this->updateData;

        return view(env('ADMIN_TEMPLATE') . '.' . $this->view . '.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validate = [];
        foreach ($this->updateData as $key => $setData) {
            $getValidate = $setData->validate;
            if (strpos($getValidate, 'unique')) {
                $getValidate = str_replace('unique', 'unique:'.$setData->table.','.$key.','.$id, $getValidate);
            }
            $validate[$key] = $getValidate;
        }

        $data = $this->validate($request, $validate);
        $getData = $this->crud->show($id);

        $this->updateData->value->type = $getData->type;

        foreach ($this->updateData as $key => $setData) {
            if ($setData->type == 'password') {
                if (strlen($data[$key]) > 0) {
                    $data[$key] = bcrypt($data[$key]);
                }
                else {
                    unset($data[$key]);
                }
            }
        }

        foreach ($this->updateData as $image_key => $setData) {
            if (in_array($setData->type, ['image', 'video'])) {
                unset($data[$image_key]);
                $image = $request->file($image_key);
                if ($image) {
                    if ($image->getError() != 1) {
                        $get_file_name = $image->getClientOriginalName();
                        $ext = explode('.', $get_file_name);
                        $ext = end($ext);
                        $set_file_name = md5(strtotime('now').rand(0, 100)).'.'.$ext;
                        $destinationPath = $setData->path;

                        if (strlen($getData->$image_key) > 0 && is_file($destinationPath.$getData->$image_key)) {
                            unlink($destinationPath.$getData->$image_key);
                        }

                        $image->move($destinationPath, $set_file_name);
                        $data[$image_key] = $set_file_name;
                    }
                }
            }
        }

        $getData = $this->crud->update($data, $id);
        $id = $getData->id;

        if($request->ajax()){
            return response()->json(['result' => 1]);
        }
        else {
            return redirect()->route('admin.' . $this->route . '.show', $id);
        }

    }

}
