<?php

namespace App\Codes\Logic;

class CheckID
{
    public function __construct()
    {

    }

    public function checkId($model, $mix_var, $attribute = 'name', $another_attribute = [])
    {
        $getString = strtoupper($mix_var);
        if (strlen($getString) > 1) {
            $save_data = [
                $attribute => $getString
            ];
            if (!empty($another_attribute) && is_array($another_attribute)) {
                foreach ($another_attribute as $key => $value) {
                    $save_data[$key] = $value;
                }
            }
            $getModel = 'App\Codes\Models\\' . $model;
            $getResult = $getModel::firstOrCreate($save_data);
            $return_id = $getResult;
        }
        else {
            $return_id = false;
        }

        return $return_id;
    }

}