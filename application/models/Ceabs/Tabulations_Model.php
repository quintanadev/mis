<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabulations_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_result_table($data) {
        $query = $this->db->query("SELECT
                PVT.Finalizador,FIN.QtdTotalTabulacao,
                PVT.[0],PVT.[1],PVT.[2],PVT.[3],PVT.[4],PVT.[5],PVT.[6],PVT.[7],
                PVT.[8],PVT.[9],PVT.[10],PVT.[11],PVT.[12],PVT.[13],PVT.[14],PVT.[15],
                PVT.[16],PVT.[17],PVT.[18],PVT.[19],PVT.[20],PVT.[21],PVT.[22],PVT.[23]
            FROM (
                SELECT RES.Finalizador,DATEPART(HOUR,RES.DataHoraResultado) AS Intervalo,
                    ROUND(CONVERT(FLOAT,COUNT(*))" . ($data['filters']['Visao'] === 'percentual' ? "
                    /(SELECT COUNT(*) FROM " . $this->DB_TABLES['ceabs_result'] . " AS ITV 
                    WHERE ITV.DataReferencia >= '" . FormatarDataSQL($data['filters']['DataReferenciaDe']) . "'
                    AND ITV.DataReferencia <= '" . FormatarDataSQL($data['filters']['DataReferenciaAte']) . "'
                    AND DATEPART(HOUR,ITV.DataHoraResultado)=DATEPART(HOUR,RES.DataHoraResultado)
                    )*100" : "") . ",2) AS QtdTabulacao
                FROM " . $this->DB_TABLES['ceabs_result'] . " AS RES
                WHERE RES.DataReferencia >= '" . FormatarDataSQL($data['filters']['DataReferenciaDe']) . "'
                AND RES.DataReferencia <= '" . FormatarDataSQL($data['filters']['DataReferenciaAte']) . "'
                GROUP BY Finalizador,DATEPART(HOUR,DataHoraResultado)
            ) AS RES PIVOT (
                SUM(QtdTabulacao) FOR [Intervalo] IN (
                    [0],[1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12],
                    [13],[14],[15],[16],[17],[18],[19],[20],[21],[22],[23])
            ) AS PVT
            INNER JOIN (
                SELECT Finalizador,ROUND(CONVERT(FLOAT,COUNT(*))" . ($data['filters']['Visao'] === 'percentual' ? "
                    /(SELECT COUNT(*) FROM " . $this->DB_TABLES['ceabs_result'] . " AS ITV 
                    WHERE ITV.DataReferencia >= '" . FormatarDataSQL($data['filters']['DataReferenciaDe']) . "'
                    AND ITV.DataReferencia <= '" . FormatarDataSQL($data['filters']['DataReferenciaAte']) . "'
                    )*100" : "") . ",2) AS QtdTotalTabulacao
                FROM " . $this->DB_TABLES['ceabs_result'] . "
                WHERE DataReferencia >= '" . FormatarDataSQL($data['filters']['DataReferenciaDe']) . "'
                AND DataReferencia <= '" . FormatarDataSQL($data['filters']['DataReferenciaAte']) . "'
                GROUP BY Finalizador
            ) AS FIN ON FIN.Finalizador=PVT.Finalizador
            ORDER BY [" . $data['columns'][$data['order'][0]['column']]['name'] . "] " . $data['order'][0]['dir']);
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_result_chart_date($data) {
        if (isset($data['filters']['DataReferenciaAte'])) :
            $this->db->where("CONVERT(VARCHAR(6),RES.DataReferencia,112)", substr($data['filters']['DataReferenciaAte'], 6, 4) . substr($data['filters']['DataReferenciaAte'], 3, 2));
        endif;
        $this->db->group_by('RES.DataReferencia');
        $this->db->order_by('RES.DataReferencia', 'ASC');
        $query = $this->db->select('CONVERT(VARCHAR(10),RES.DataReferencia,103) AS DataReferencia, SUM(FIN.QtdAgendamento) AS QtdAgendamento, SUM(FIN.QtdSucesso) AS QtdSucesso, COUNT(*) AS QtdTabulacao')
                        ->join($this->DB_TABLES['ceabs_fin'] . ' AS FIN', 'FIN.IDFinalizador=RES.IDFinalizador', 'LEFT')
                        ->get($this->DB_TABLES['ceabs_result'] . ' AS RES');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_result_chart_interval($data) {
        $this->db->where("RES.DataReferencia >=", FormatarDataSQL($data['filters']['DataReferenciaDe']));
        $this->db->where("RES.DataReferencia <=", FormatarDataSQL($data['filters']['DataReferenciaAte']));
        $this->db->group_by('DATEPART(HOUR,RES.DataHoraResultado)');
        $this->db->order_by('1', 'ASC');
        $query = $this->db->select('DATEPART(HOUR,RES.DataHoraResultado) AS Intervalo, SUM(FIN.QtdAgendamento) AS QtdAgendamento, SUM(FIN.QtdSucesso) AS QtdSucesso, SUM(FIN.QtdInsucesso) AS QtdInsucesso, COUNT(*) AS QtdTabulacao')
                        ->join($this->DB_TABLES['ceabs_fin'] . ' AS FIN', 'FIN.IDFinalizador=RES.IDFinalizador', 'LEFT')
                        ->get($this->DB_TABLES['ceabs_result'] . ' AS RES');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function export_file_excel($data) {
        $this->db->where("RES.DataReferencia >=", FormatarDataSQL($data['DataReferenciaDe']));
        $this->db->where("RES.DataReferencia <=", FormatarDataSQL($data['DataReferenciaAte']));
        $this->db->order_by('RES.DataHoraResultado', 'DESC');
        $query = $this->db->select('DATEPART(HOUR,RES.DataHoraResultado) AS Intervalo, RES.*')
                        ->join($this->DB_TABLES['ceabs_fin'] . ' AS FIN', 'FIN.IDFinalizador=RES.IDFinalizador', 'LEFT')
                        ->get($this->DB_TABLES['ceabs_result'] . ' AS RES');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

}