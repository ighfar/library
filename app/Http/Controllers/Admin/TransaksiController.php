<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_GeneralController;
use Illuminate\Http\Request;

class TransaksiController extends _GeneralController
{
    public function __construct(Request $request)
    {
        $listAll = json_decode(json_encode([
            'id' => [
                'store' => 0,
                'update' => 0,
                'show' => 0,
            ],
            'kode_transaksi' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            'anggota_id' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
    
            ],
            'buku_id' => [
                'validate' => [
                    'store' => '',
                    'update' => ''
                ],
        
            ],

            'tgl_pinjam' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            'tgl_kembali' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
    
            ],
            'status' => [
                'validate' => [
                    'store' => '',
                    'update' => ''
                ],
        
            ],

            'ket' => [
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
