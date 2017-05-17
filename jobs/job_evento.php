<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '/var/www/aenet/bootstrap.php';

/**
 * Processamento das Cartas de Correção de NFe do sistema AENET
 * Irá ler cada registro marcado como não processado
 */

use Aenet\NFe\Controllers\EventoController;
use Aenet\NFe\Controllers\CadastroController;
use Aenet\NFe\Processes\EventoProcess;

$cad = new CadastroController();
$evtctrl = new EventoController();

//verifica por cartas de correção de NFe, ainda não realizados
//para casos onde:
//nfes_aenet_evento.status = 0 e
//nfes_aenet_evento.justificativa <> '' e
//nfes_aenet.status_nfe = 1
$cces = $evtctrl->pendentsAll();
$oldid_empresa = 0;
$client = null;
foreach ($cces as $cce) {
    $std = json_decode(json_encode($cce));
    $id = $std->id;
    $id_empresa = $std->id_empresa;
    $xCorrecao = $std->justificativa;
    $nSeqEvento = $std->sequencial;
    $chave = $std->nfe_chave_acesso;
    if ($id_empresa != $oldid_empresa) {
        //pega os dados do cliente dessa NFe
        $client = json_decode(json_encode($cad->get($id_empresa)[0]));
        $oldid_empresa = $id_empresa;
        $evtp = new EventoProcess($client);
    }
    $evtp->send($id, $chave, $xCorrecao, $nSeqEvento);
}
exit;
