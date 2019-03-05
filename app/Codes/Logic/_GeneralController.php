<?php

namespace App\Codes\Logic;

use App\Codes\Models\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class _GeneralController extends Controller
{
    protected $request;
    protected $crud;
    protected $route;
    protected $label;
    protected $view;
    protected $model;
    protected $data = [];
    protected $setting = [];
    protected $listData = [];
    protected $storeData = [];
    protected $updateData = [];
    protected $viewData = [];
    protected $permission = [];

    public function __construct(Request $request, $model, $route, $label, $view = 'general', $listAll, $permission = [])
    {
        $this->setting = Settings::pluck('value', 'key');

        $this->request = $request;
        $this->model = 'App\Codes\Models\\' . $model;
        $this->crud = new CRUD($model);

        $listData = [];
        $storeData = [];
        $updateData = [];
        $viewData = [];
        foreach ($listAll as $field_name => $list) {
            if (!isset($list->list) || $list->list != 0) {
                $listData[$field_name] = [
                    'lang' => isset($list->lang) ? $list->lang : 'general.'.$field_name,
                    'type' => isset($list->type) ? $list->type : 'text',
                    'custom' => isset($list->custom) ? $list->custom : '',
                    'path' => isset($list->path) ? $list->path : '',
                    'raw' => isset($list->raw) ? $list->raw : '',
                ];
            }
            if (!isset($list->store) || $list->store != 0) {
                $storeData[$field_name] = [
                    'validate' => isset($list->validate->store) ? $list->validate->store : '',
                    'lang' => isset($list->lang) ? $list->lang : 'general.'.$field_name,
                    'type' => isset($list->type) ? $list->type : 'text',
                    'path' => isset($list->path) ? $list->path : '',
                    'field_message' => isset($list->field_message) ? $list->field_message : '',
                    'default_value' => isset($list->default_value) ? $list->default_value : ''
                ];
            }
            if (!isset($list->update) || $list->update != 0) {
                $updateData[$field_name] = [
                    'validate' => isset($list->validate->update) ? $list->validate->update : '',
                    'table' => isset($list->table) ? $list->table : '',
                    'lang' => isset($list->lang) ? $list->lang : 'general.'.$field_name,
                    'type' => isset($list->type) ? $list->type : 'text',
                    'path' => isset($list->path) ? $list->path : '',
                    'field_message' => isset($list->field_message) ? $list->field_message : ''
                ];
            }
            if (!isset($list->show) || $list->show != 0) {
                $viewData[$field_name] = [
                    'lang' => isset($list->lang) ? $list->lang : 'general.'.$field_name,
                    'type' => isset($list->type) ? $list->type : 'text',
                    'path' => isset($list->path) ? $list->path : '',
                    'field_message' => isset($list->field_message) ? $list->field_message : ''
                ];
            }
        }

        $this->route = $route;
        $this->label = $label;
        $this->view = $view;

        $this->listData = json_decode(json_encode($listData));
        $this->storeData = json_decode(json_encode($storeData));
        $this->updateData = json_decode(json_encode($updateData));
        $this->viewData = json_decode(json_encode($viewData));
        if (is_array($permission) && !empty($permission)) {
            $this->permission = [
                'create' => isset($permission['create']) ? $permission['create'] : true,
                'edit' => isset($permission['edit']) ? $permission['edit'] : true,
                'show' => isset($permission['show']) ? $permission['show'] : true,
                'delete' => isset($permission['delete']) ? $permission['delete'] : true,
            ];
        }
        else {
            $this->permission = [
                'create' => true,
                'edit' => true,
                'show' => true,
                'delete' => true,
            ];
        }

        $this->data['this_route'] = $this->route;
        $this->data['this_label'] = $this->label;
        $this->data['set_list'] = [];
        $this->data['setting'] = $this->setting;
    }

    public function index()
    {
        $data = $this->data;

        $data['passing'] = $this->listData;
        $data['permission'] = $this->permission;

        return view(env('ADMIN_TEMPLATE') . '.' . $this->view . '.list', $data);
    }

    public function dataTable()
    {
        $dataTables = new DataTables();

        $builder = $this->model::query()->select('*');

        $dataTables = $dataTables->eloquent($builder)
            ->addColumn('action', function ($query) {
                return view(env('ADMIN_TEMPLATE') . '.' . $this->view . '.table_button', ['query' => $query, 'this_route' => $this->route, 'permission' => $this->permission]);
            });

        $list_raw = [];
        $list_raw[] = 'action';
        foreach ($this->listData as $field_name => $list) {
            if (in_array($list->type, ['select', 'select2'])) {
                $dataTables = $dataTables->editColumn($field_name, function ($query) use ($field_name) {
                    $get_list = isset($this->data['set_list'][$field_name]) ? $this->data['set_list'][$field_name] : [];
                    return isset($get_list[$query->$field_name]) ? $get_list[$query->$field_name] : $query->$field_name;
                });
            }
            if (in_array($list->type, ['image'])) {
                $list_raw[] = $field_name;
                $dataTables = $dataTables->editColumn($field_name, function ($query) use ($field_name, $list, $list_raw) {
                    return '<img src="' . asset($list->path . '/' . $query->$field_name) . '" class="img-responsive max-image-preview"/>';
                });
            }
        }

        return $dataTables
            ->rawColumns($list_raw)
            ->make(true);
    }

    public function create()
    {
        $data = $this->data;

        $data['passing'] = $this->storeData;

        return view(env('ADMIN_TEMPLATE') . '.' . $this->view . '.create', $data);
    }

    public function store(Request $request)
    {
        $validate = [];
        foreach ($this->storeData as $key => $setData) {
            $validate[$key] = $setData->validate;
        }
        $data = $this->validate($request, $validate);

        foreach ($this->storeData as $key => $setData) {
            if ($setData->type == 'password') {
                $data[$key] = bcrypt($data[$key]);
            }
        }

        foreach ($this->storeData as $image_key => $setData) {
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

                        $image->move($destinationPath, $set_file_name);
                        $data[$image_key] = $set_file_name;
                    }
                }
            }
        }

        $getData = $this->crud->store($data);

        $id = $getData->id;

        if($request->ajax()){
            return response()->json(['result' => 1]);
        }
        else {
            return redirect()->route('admin.' . $this->route . '.show', $id);
        }

    }

    public function show($id)
    {
        $data = $this->data;

        $getData = $this->crud->show($id);
        if (!$getData) {
            return redirect()->route('admin.' . $this->route . '.index');
        }

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

    public function destroy(Request $request, $id)
    {
        $this->crud->destroy($id);

        if($request->ajax()){
            return response()->json(['result' => 1]);
        }
        else {
            return redirect()->route('admin.' . $this->route . '.index');
        }

    }

}
