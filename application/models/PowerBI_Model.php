<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PowerBI_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_dashboard_list() {
        // LISTA DE OPERAÇÕES - 1) Tabela do Portal; 2) Estrutura
        if (!$this->session->userdata('USER')['is_employee'] || (!$this->session->userdata('USER')['is_admin'] && in_array($this->session->userdata('STRUCTURE')['id_nivel_hierarquico'], [2, 3]))) :
            $this->db->group_start();
            for ($i = 0; $i < count($this->session->userdata('USER_OPERATIONS')); $i++) :
                if ($i > 0) :
                    $this->db->or_like('OPER.tags', $this->session->userdata('USER_OPERATIONS')[$i]);
                else:
                    $this->db->like('OPER.tags', $this->session->userdata('USER_OPERATIONS')[$i]);
                endif;
            endfor;
            $this->db->group_end();
        endif;
        // Filtros Para Clientes
        if (!$this->session->userdata('USER')['is_employee']) {
            $this->db->where(['PBI.client_access' => 1]);
        }
        // Filtro Para Relatórios Que Não São Publicos
        if (!$this->session->userdata('USER')['is_admin']) {
            $this->db->group_start();
            $this->db->where("CASE WHEN PBI.is_public=0 THEN id_dashboard ELSE NULL END IN (SELECT id_dashboard FROM permission_user_dashboard WHERE id_user={$this->session->userdata('USER_ID')} AND is_visible=1)");
            $this->db->or_where("PBI.is_public", 1);
            $this->db->group_end();
        }
        // Ocultar Relatórios Conforme Permissão
        $this->db->where("PBI.id_dashboard NOT IN (SELECT id_dashboard FROM permission_user_dashboard WHERE id_user={$this->session->userdata('USER_ID')} AND is_visible=0)");
        // Consulta Default
        $query = $this->db->join('admin_operations AS OPER', 'OPER.id_operation=PBI.id_operation', 'LEFT')
                    ->where(['PBI.is_active' => 1])
                    ->order_by('OPER.operation ASC, PBI.dashboard ASC')
                    ->get('powerbi_dashboard AS PBI');
        if($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_dashboard($id) {
        $query = $this->db->where('id_dashboard', $id)
                    ->get('powerbi_dashboard');
        if($query->num_rows() > 0) :
            $pbi = $query->row_array();
            if (!$this->session->userdata('USER')['is_employee'] && !$pbi['client_access']) :
                return ['type' => 'danger', 'msg' => 'Sem Permissão!'];
            endif;
            $this->set_log_pbi($this->session->userdata('USER_ID'), $pbi['id_dashboard']);
            return $pbi;
        endif;
        return ['type' => 'danger', 'msg' => 'Relatório não encontrado!'];
    }

    public function set_log_pbi($usu, $pbi) {
        $data = [
            'id_user' => $usu,
            'id_dashboard' => $pbi
        ];
        $query = $this->db->where($data)
                        ->where('reference_date', date('Y-m-d'))
                        ->get('powerbi_log_dashboard');
        if ($query->num_rows() > 0) :
            $this->db->where($data)
                    ->where(['reference_date' => date('Y-m-d')])
                    ->update('powerbi_log_dashboard', [
                        'count_access' => $query->row_array()['count_access'] + 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
        else:
            $this->db->insert('powerbi_log_dashboard', $data);
        endif;
        return TRUE;
    }

}