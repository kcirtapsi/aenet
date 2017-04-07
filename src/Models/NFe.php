<?php

namespace Aenet\NFe\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class NFe extends Eloquent
{
    public $timestamps = false;
    protected $table = 'dfe_nfes';
    protected $fillable = [
        'id',
        'id_cadastro',
        'nsu',
        'chNFe',
        'cnpj',
        'xNome',
        'dhEmi',
        'nProt',
        'content'
    ];
}
