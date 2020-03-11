<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PowerBI_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_dashboard_list() {
        // LISTA DE OPERAÇÕES - 1) Tabela do Portal; 2) Estrutura
        if (!$this->session->userdata('USUARIO')['Funcionario'] || (!$this->session->userdata('USUARIO')['Admin'] && in_array($this->session->userdata('ESTRUTURA')['id_nivel_hierarquico'], [2, 3]))) :
            $this->db->group_start();
            for ($i = 0; $i < count($this->session->userdata('USU_OPERS')); $i++) :
                if ($i > 0) :
                    $this->db->or_like('OPER.Alias', $this->session->userdata('USU_OPERS')[$i]);
                else:
                    $this->db->like('OPER.Alias', $this->session->userdata('USU_OPERS')[$i]);
                endif;
            endfor;
            $this->db->group_end();
        endif;
        // Filtros Para Clientes
        if (!$this->session->userdata('USUARIO')['Funcionario']) {
            $this->db->where(['PBI.VisualizacaoCliente' => 1]);
        }
        // Filtro Para Relatórios Que Não São Publicos
        if (!$this->session->userdata('USUARIO')['Admin']) {
            $this->db->group_start();
            $this->db->where("CASE WHEN PBI.Publico=0 THEN IDDashboard ELSE NULL END IN (SELECT IDDashboard FROM admin_per_usuarios_dashboard WHERE IDUsuario={$this->session->userdata('USU_ID')} AND Visualizar=1)");
            $this->db->or_where("PBI.Publico=1");
            $this->db->group_end();
        }
        // Ocultar Relatórios Conforme Permissão
        $this->db->where("PBI.IDDashboard NOT IN (SELECT IDDashboard FROM admin_per_usuarios_dashboard WHERE IDUsuario={$this->session->userdata('USU_ID')} AND Visualizar=0)");
        // Consulta Default
        $query = $this->db->join('admin_operacoes AS OPER', 'OPER.IDOperacao=PBI.IDOperacao', 'LEFT')
                    ->where(['PBI.Ativo' => 1])
                    ->order_by('OPER.Operacao ASC, PBI.Dashboard ASC')
                    ->get('pbi_dashboard AS PBI');
        if($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

}