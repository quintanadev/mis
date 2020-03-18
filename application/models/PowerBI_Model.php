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

    public function get_dashboard($id) {
        $query = $this->db->where('IDDashboard', $id)
                    ->get('pbi_dashboard');
        if($query->num_rows() > 0) :
            $pbi = $query->row_array();
            if (!$this->session->userdata('USUARIO')['Funcionario'] && !$pbi['VisualizacaoCliente']) :
                return ['type' => 'danger', 'msg' => 'Sem Permissão!'];
            endif;
            $this->set_log_pbi($this->session->userdata('USU_ID'), $pbi['IDDashboard']);
            return $pbi;
        endif;
        return ['type' => 'danger', 'msg' => 'Relatório não encontrado!'];
    }

    public function set_log_pbi($usu, $pbi) {
        $data = [
            'IDUsuario' => $usu,
            'IDDashboard' => $pbi
        ];
        $query = $this->db->where($data)
                        ->where('DataReferencia', date('Y-m-d'))
                        ->get('pbi_log_dashboard');
        if ($query->num_rows() > 0) :
            $this->db->where($data)
                    ->where(['DataReferencia' => date('Y-m-d')])
                    ->update('pbi_log_dashboard', ['QtdAcessos' => $query->row_array()['QtdAcessos'] + 1]);
        else:
            $this->db->insert('pbi_log_dashboard', $data);
        endif;
        return TRUE;
    }

}