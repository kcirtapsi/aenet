<?php

namespace Aenet\NFe\Controllers;

use Aenet\NFe\Models\Aenet;
use Aenet\NFe\Controllers\InputsController;
use Aenet\NFe\Controllers\BaseController;

class AenetController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function nfeAll()
    {
        return Aenet::where(['status_nfe', '=', 0])
            ->orderBy('id_empresa')
            ->get()
            ->toArray();
    }
    
    public function cancelAll()
    {
        return Aenet::where([
                ['justificativa', '<>', ''],
                ['status', '=', '100'],
                ['cancelamento_protocolo', '=', ''],
                ['protoclo', '<>', ''],
                ['nfe_chave_acesso', '<>', '']
            ])
            ->orderBy('id_empresa')
            ->get()
            ->toArray();
    }
    
    public function update($id, $astd)
    {
        Aenet::where('id_nfes_aenet', $id)
            ->update($astd);
    }
}