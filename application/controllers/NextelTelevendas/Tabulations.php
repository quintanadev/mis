<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabulations extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('NextelTelevendas/Tabulations_Model', 'Nextel');
    }

    public function index() {
        $data['page_title'] = 'Analítico de Tabulações';
        $data['page_subtitle'] = 'Nextel Televendas';
        $data['views'] = ['pages/operations/nextel-televendas/tabulations'];

        $this->load->view('site/layout', $data);
    }

    public function get_result_table() {
        $post = $this->input->post();
        $retorno = $this->Nextel->get_result_table($post);

        $regTotal = ($retorno ? count($retorno) : 0);
        $regMostrar = (intval($post['length']) < 0 ? $regTotal : intval($post['length']));
        $regInicio = intval($post['start']);
        $regFimAux = $regInicio + $regMostrar;
        $regFim = ($regFimAux > $regTotal ? $regTotal : $regFimAux);

        $data = [];
        if ($retorno) :
            for ($i = $regInicio; $i < $regFim; $i++) :
                $data['data'][] = [
                    'NomeColaborador' => $retorno[$i]['NomeColaborador'],
                    'QtdVenda' => $retorno[$i]['QtdVenda'],
                    '0' => $retorno[$i]['0'],
                    '1' => $retorno[$i]['1'],
                    '2' => $retorno[$i]['2'],
                    '3' => $retorno[$i]['3'],
                    '4' => $retorno[$i]['4'],
                    '5' => $retorno[$i]['5'],
                    '6' => $retorno[$i]['6'],
                    '7' => $retorno[$i]['7'],
                    '8' => $retorno[$i]['8'],
                    '9' => $retorno[$i]['9'],
                    '10' => $retorno[$i]['10'],
                    '11' => $retorno[$i]['11'],
                    '12' => $retorno[$i]['12'],
                    '13' => $retorno[$i]['13'],
                    '14' => $retorno[$i]['14'],
                    '15' => $retorno[$i]['15'],
                    '16' => $retorno[$i]['16'],
                    '17' => $retorno[$i]['17'],
                    '18' => $retorno[$i]['18'],
                    '19' => $retorno[$i]['19'],
                    '10' => $retorno[$i]['10'],
                    '21' => $retorno[$i]['21'],
                    '22' => $retorno[$i]['22'],
                    '23' => $retorno[$i]['23'],
                ];
            endfor;
        else:
            $data['type'] = 'info';
            $data['msg'] = 'Oops! Ainda não existem informações cadastradas. Altere o filtro ou tente mais tarde.';
        endif;
        
        $data['draw'] = intval($post['draw']);
        $data['recordsTotal'] = $regTotal;
        $data['recordsFiltered'] = $regTotal;
        echo json_encode($data);
    }

    public function get_result_chart_date() {
        $post = $this->input->post();
        $retorno = $this->Nextel->get_result_chart_date($post);
        echo json_encode($retorno);
    }

    public function get_result_chart_interval() {
        $post = $this->input->post();
        $retorno = $this->Nextel->get_result_chart_interval($post);
        echo json_encode($retorno);
    }

    public function export_file_excel() {
        $post = [
            'DataReferenciaDe' => $_GET['DataReferenciaDe'],
            'DataReferenciaAte' => $_GET['DataReferenciaAte']
        ];
        $retorno = $this->Nextel->export_file_excel($post);

        function cleanData(&$str) {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            $str = mb_convert_encoding($str, 'UTF-8');
        }

        // filename for download
        $filename = "Tabulacoes_Nextel_" . date('YmdHsi') . ".xls";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/excel; charset=UTF-8");

        $flag = false;
        foreach($retorno as $row) {
            if(!$flag) {
                echo implode("\t", array_keys($row)) . "\r\n";
                $flag = true;
            }
            array_walk($row, 'cleanData');
            echo implode("\t", array_values($row)) . "\r\n";
        }
        exit;
    }

}