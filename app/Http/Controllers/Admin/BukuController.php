<?php

namespace App\Http\Controllers\Admin;

use App\Codes\Logic\_GeneralController;
use Illuminate\Http\Request;

class BukuController extends _GeneralController
{
    public function __construct(Request $request)
    {
        $listAll = json_decode(json_encode([
            'id' => [
                'store' => 0,
                'update' => 0,
                'show' => 0,
            ],
            'judul' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            'isbn' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
    
            ],
            'pengarang' => [
                'validate' => [
                    'store' => '',
                    'update' => ''
                ],
        
            ],

            'penerbit' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            'tahun_terbit' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
    
            ],
            'jumlah_buku' => [
                'validate' => [
                    'store' => '',
                    'update' => ''
                ],
        
            ],

            'deskripsi' => [
                'validate' => [
                    'store' => 'required',
                    'update' => 'required'
                ],
            ],
            'lokasi' => [
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
            $request, 'Buku', 'buku', 'Buku', 'general',
            $listAll
        );

    }


}
