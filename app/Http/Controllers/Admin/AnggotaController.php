<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_GeneralController;
use Illuminate\Http\Request;

class AnggotaController extends _GeneralController
{
    public function __construct(Request $request)
    {
        $listAll = json_decode(json_encode([
            'id' => [
                'store' => 0,
                'update' => 0,
                'show' => 0,
            ],
            'user_id' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            'npm' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
    
            ],
            'nama' => [
                'validate' => [
                    'store' => '',
                    'update' => ''
                ],
        
            ],

            'tempat_lahir' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            'tgl_lahir' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
    
            ],
            'prodi' => [
                'validate' => [
                    'store' => '',
                    'update' => ''
                ],
        
            ],

            'jk' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            
            'action' => [
                'lang' => 'general.action',
                'custom' => ', orderable: false, searchable: false',
                'store' => 0,
                'update' => 0,
                'show' => 0,
            ],
        ]));

        parent::__construct(
            $request, 'Transaksi', 'transaksi', 'Transaksi', 'general',
            $listAll
        );

    }


}
