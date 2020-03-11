<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabulations_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_result_table($data) {
        $query = $this->db->query("SELECT
                PVT.MatriculaElo,PVT.NomeColaborador,COL.QtdVenda,
                PVT.[0],PVT.[1],PVT.[2],PVT.[3],PVT.[4],PVT.[5],PVT.[6],PVT.[7],
                PVT.[8],PVT.[9],PVT.[10],PVT.[11],PVT.[12],PVT.[13],PVT.[14],PVT.[15],
                PVT.[16],PVT.[17],PVT.[18],PVT.[19],PVT.[20],PVT.[21],PVT.[22],PVT.[23]
            FROM (
                SELECT TAB.MatriculaElo,EST.NomeColaborador,DATEPART(HOUR,DataHoraTabulacao) AS Intervalo,SUM(STT.QtdVenda) AS QtdVenda
                FROM " . $this->DB_TABLES['nextel_tab'] . " AS TAB
                INNER JOIN " . $this->DB_TABLES['nextel_stt'] . " AS STT ON STT.IDStatus=TAB.IDStatus
                LEFT JOIN " . $this->DB_TABLES['estrutura-atual'] . " AS EST ON EST.MatriculaElo=TAB.MatriculaElo
                WHERE DataReferencia >= '" . FormatarDataSQL($data['filters']['DataReferenciaDe']) . "'
                AND DataReferencia <= '" . FormatarDataSQL($data['filters']['DataReferenciaAte']) . "'
                GROUP BY TAB.MatriculaElo,EST.NomeColaborador,DATEPART(HOUR,DataHoraTabulacao)
            ) AS RES PIVOT (
                SUM(QtdVenda) FOR [Intervalo] IN (
                    [0],[1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12],
                    [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23])
            ) AS PVT
            INNER JOIN (
                SELECT TAB.MatriculaElo,SUM(QtdVenda) AS QtdVenda
                FROM " . $this->DB_TABLES['nextel_tab'] . " AS TAB
                INNER JOIN " . $this->DB_TABLES['nextel_stt'] . " AS STT ON STT.IDStatus=TAB.IDStatus
                LEFT JOIN " . $this->DB_TABLES['estrutura-atual'] . " AS EST ON EST.MatriculaElo=TAB.MatriculaElo
                WHERE DataReferencia >= '" . FormatarDataSQL($data['filters']['DataReferenciaDe']) . "'
                AND DataReferencia <= '" . FormatarDataSQL($data['filters']['DataReferenciaAte']) . "'
                GROUP BY TAB.MatriculaElo
            ) AS COL ON COL.MatriculaElo=PVT.MatriculaElo
            ORDER BY [" . $data['columns'][$data['order'][0]['column']]['name'] . "] " . $data['order'][0]['dir']);
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_result_chart_date($data) {
        if (isset($data['filters']['DataReferenciaAte'])) :
            $this->db->where("CONVERT(VARCHAR(6),TAB.DataHoraTabulacao,112)", substr($data['filters']['DataReferenciaAte'], 6, 4) . substr($data['filters']['DataReferenciaAte'], 3, 2));
        endif;
        $this->db->group_by('TAB.DataReferencia');
        $this->db->order_by('TAB.DataReferencia', 'ASC');
        $query = $this->db->select('CONVERT(VARCHAR(10),TAB.DataReferencia,103) AS DataReferencia, SUM(STT.QtdVenda) AS QtdVenda, COUNT(*) AS QtdTabulacao')
                        ->join($this->DB_TABLES['nextel_stt'] . ' AS STT', 'STT.IDStatus=TAB.IDStatus')
                        ->get($this->DB_TABLES['nextel_tab'] . ' AS TAB');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_result_chart_interval($data) {
        $this->db->where("TAB.DataReferencia >=", FormatarDataSQL($data['filters']['DataReferenciaDe']));
        $this->db->where("TAB.DataReferencia <=", FormatarDataSQL($data['filters']['DataReferenciaAte']));
        $this->db->group_by('DATEPART(HOUR,TAB.DataHoraTabulacao)');
        $this->db->order_by('1', 'ASC');
        $query = $this->db->select('DATEPART(HOUR,TAB.DataHoraTabulacao) AS Intervalo, SUM(STT.QtdVenda) AS QtdVenda, SUM(CON.QtdInsucesso) AS QtdInsucesso, COUNT(*) AS QtdTabulacao')
                        ->join($this->DB_TABLES['nextel_stt'] . ' AS STT', 'STT.IDStatus=TAB.IDStatus')
                        ->join($this->DB_TABLES['nextel_cond'] . ' AS CON', 'CON.Condicao=TAB.Condicao', 'LEFT')
                        ->get($this->DB_TABLES['nextel_tab'] . ' AS TAB');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function export_file_excel($data) {
        $this->db->where("TAB.DataReferencia >=", FormatarDataSQL($data['DataReferenciaDe']));
        $this->db->where("TAB.DataReferencia <=", FormatarDataSQL($data['DataReferenciaAte']));
        $this->db->order_by('TAB.DataHoraTabulacao', 'DESC');
        $query = $this->db->select("DATEPART(HOUR,TAB.DataHoraTabulacao) AS Intervalo,TAB.DataHoraTabulacao,                
                TAB.MatriculaElo,EST.ds_nome_colaborador AS NomeColaborador,
                TAB.IDTabulacao,TAB.Telefone,TAB.CPF,TAB.QuantidadeLinhas,CAM.Campanha,
                CASE WHEN TAB.Debito=1 THEN 'SIM' WHEN TAB.Debito=0 THEN 'NAO' ELSE '' END AS Debito,
                CASE WHEN TAB.Portabilidade=1 THEN 'SIM' WHEN TAB.Portabilidade=0 THEN 'NAO' ELSE '' END AS Portabilidade,
                STT.Status,TAB.Condicao,PLA.PlanoVendido")
                        ->join($this->DB_TABLES['nextel_stt'] . ' AS STT', 'STT.IDStatus=TAB.IDStatus', 'LEFT')
                        ->join($this->DB_TABLES['nextel_cam'] . ' AS CAM', 'CAM.IDCampanha=TAB.IDStatus', 'LEFT')
                        ->join($this->DB_TABLES['nextel_pla'] . ' AS PLA', 'PLA.IDPlanoVendido=TAB.IDPlanoVendido', 'LEFT')
                        ->join($this->DB_TABLES['estrutura_atual'] . ' AS EST', 'EST.MatriculaElo=TAB.MatriculaElo', 'LEFT')
                        ->get($this->DB_TABLES['nextel_tab'] . ' AS TAB');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

}