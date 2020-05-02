<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Structure_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_current_structure($data) {
        if (!$this->session->userdata("USER")['is_mod_structure']) {
            $registration = $this->session->userdata('USER')['resgitration'];
            $this->db
                ->group_start()
                    ->where('matricula_elo', $registration)
                    ->or_where('matricula_elo_gestor_1', $registration)
                    ->or_where('matricula_elo_gestor_2', $registration)
                    ->or_where('matricula_elo_gestor_3', $registration)
                    ->or_where('matricula_elo_diretor', $registration)
                ->group_end();
        }
        if ($data['search']['value']) {
            $this->db
                ->group_start()
                    ->like('nome', $data['search']['value'])
                    ->or_where("'#'+CONVERT(VARCHAR(12),matricula_elo)", $data['search']['value'])
                ->group_end();
        }
        $query = $this->db
            ->select('id_estrutura,matricula_elo,nome,sexo')
            ->order_by($data['columns'][$data['order'][0]['column']]['name'], $data['order'][0]['dir'])
            ->get('MIS_ESTRUTURA.dbo.vw_estrutura_atual');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_employee($data) {
        $this->db->where('id_estrutura', $data['id']);
        $query = $this->db->get('MIS_ESTRUTURA.dbo.vw_estrutura_atual');
        if ($query->num_rows() > 0) :
            return $query->row_array();
        endif;
        return FALSE;
    }

    function get_data_select($data) {
        $select = $data['select'];
        parse_str($data['form'], $form);

        if ($select === 'gestor') {
            $query = $this->db
                ->select('PES.id_estrutura AS value, PES.nome AS title')
                ->join('MIS_ESTRUTURA.dbo.dados_corporativos AS COR', 'COR.id_estrutura=PES.id_estrutura')
                ->join('MIS_ESTRUTURA.dbo.lista_funcao AS FUN', 'FUN.id_funcao=COR.id_funcao')
                ->join('MIS_ESTRUTURA.dbo.lista_nivel_hierarquico AS NIV', 'NIV.id_nivel_hierarquico=FUN.id_nivel_hierarquico')
                ->where('NIV.cod_nivel_hierarquico = (SELECT cod_nivel_hierarquico + 1 FROM MIS_ESTRUTURA.dbo.vw_estrutura_atual WHERE id_estrutura=' . $form['id_estrutura'] . ')')
                ->get('MIS_ESTRUTURA.dbo.dados_pessoais AS PES');
        } else {
            if ($select === 'segmento') {
                $this->db->where('id_cliente', $form['id_cliente']);
            }

            $query = $this->db
                ->select("id_{$select} AS value, {$select} AS title")
                ->where('ativo', 1)
                ->order_by($select)
                ->get('MIS_ESTRUTURA.dbo.lista_' . $select);
        }
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return false;
    }

    public function update_personal_data($data) {
        $update = [
            'id_estado_civil' => $data['id_estado_civil'],
            'id_grau_instrucao' => $data['id_grau_instrucao'],
            'nome_mae' => strtoupper($data['nome_mae']),
            'nome_pai' => strtoupper($data['nome_pai']),
            'atualizado_em' => date('Y-m-d H:i:s'),
            'id_usuario_atualizacao' => $this->session->userdata('USER_ID')
        ];
        $this->db->where('id_estrutura', $data['id_estrutura'])
            ->update('MIS_ESTRUTURA.dbo.dados_pessoais', $update);
        if ($this->db->affected_rows() > 0) {
            return ['msg' => 'success'];
        }
        return ['msg' => 'Erro ao atualizar dados. Tente novamente mais tarde!'];
    }

    public function update_corporate_data($data) {
        $update = [
            'id_status_gestor' => $data['id_status_gestor'],
            'horario_entrada' => $data['horario_entrada'],
            'horario_saida' => $data['horario_saida'],
            'atualizado_em' => date('Y-m-d H:i:s'),
            'id_usuario_atualizacao' => $this->session->userdata('USER_ID')
        ];
        $this->db->where('id_estrutura', $data['id_estrutura'])
            ->update('MIS_ESTRUTURA.dbo.dados_corporativos', $update);
        if ($this->db->affected_rows() > 0) {
            return ['msg' => 'success'];
        } else {
            $insert = $update;
            $insert['id_estrutura'] = $data['id_estrutura'];
            $this->db->insert('MIS_ESTRUTURA.dbo.dados_corporativos', $insert);
            if ($this->db->affected_rows() > 0) {
                return ['msg' => 'success'];
            }
        }
        return ['msg' => 'Erro ao atualizar dados. Tente novamente mais tarde!'];
    }

    public function update_allocation_data($data) {
        $update = [
            'id_gestor' => $data['id_gestor'],
            'id_setor' => $data['id_setor'],
            'id_site' => $data['id_site'],
            'id_segmento' => $data['id_segmento'],
            'atualizado_em' => date('Y-m-d H:i:s'),
            'id_usuario_atualizacao' => $this->session->userdata('USER_ID')
        ];
        $this->db->where('id_estrutura', $data['id_estrutura'])
            ->update('MIS_ESTRUTURA.dbo.dados_alocacao', $update);
        if ($this->db->affected_rows() > 0) {
            return ['msg' => 'success'];
        } else {
            $insert = $update;
            $insert['id_estrutura'] = $data['id_estrutura'];
            $this->db->insert('MIS_ESTRUTURA.dbo.dados_alocacao', $insert);
            if ($this->db->affected_rows() > 0) {
                return ['msg' => 'success'];
            }
        }
        return ['msg' => 'Erro ao atualizar dados. Tente novamente mais tarde!'];
    }

    public function update_contact_data($data) {
        $update = [
            'telefone_celular' => $data['telefone_celular'],
            'telefone_fixo' => $data['telefone_fixo'],
            'telefone_comercial' => $data['telefone_comercial'],
            'telefone_corporativo' => $data['telefone_corporativo'],
            'email_corporativo' => strtolower($data['email_corporativo']),
            'email_pessoal' => strtolower($data['email_pessoal']),
            'telefone_emergencia' => $data['telefone_emergencia'],
            'contato_emergencia' => strtoupper($data['contato_emergencia']),
            'atualizado_em' => date('Y-m-d H:i:s'),
            'id_usuario_atualizacao' => $this->session->userdata('USER_ID')
        ];
        $this->db->where('id_estrutura', $data['id_estrutura'])
            ->update('MIS_ESTRUTURA.dbo.dados_contatos', $update);
        if ($this->db->affected_rows() > 0) {
            return ['msg' => 'success'];
        } else {
            $insert = $update;
            $insert['id_estrutura'] = $data['id_estrutura'];
            $this->db->insert('MIS_ESTRUTURA.dbo.dados_contatos', $insert);
            if ($this->db->affected_rows() > 0) {
                return ['msg' => 'success'];
            }
        }
        return ['msg' => 'error'];
    }

}