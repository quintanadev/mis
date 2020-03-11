<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Structure_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_current_structure($data) {
        if (!$this->session->userdata("USUARIO")['ModEstrutura']) :
            // $this->db->where("TKT.IDUsuarioCadastro", $this->session->userdata("USU_ID"));
        endif;
        if ($data['search']['value']) :
            $this->db->group_start()
                    ->like('PES.NomeColaborador', $data['search']['value'])
                    ->or_where("'#'+CONVERT(VARCHAR(12),PES.IDEstrutura)", $data['search']['value'])
                    ->group_end();
        endif;
        $query = $this->db->select('PES.*')
                        ->order_by($data['columns'][$data['order'][0]['column']]['name'], $data['order'][0]['dir'])
                        ->get($this->DB_TABLES['estrutura-pessoais'] . ' AS PES');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_employee($id) {
        $this->db->where('IDEstrutura', $id);
        $query = $this->db->get($this->DB_TABLES['estrutura-atual']);
        if ($query->num_rows() > 0) :
            return $query->row_array();
        endif;
        return FALSE;
    }

    function get_data_select($data) {
        if ($data['coluna'] === 'Segmento') {
            $this->db->where('IDCliente', $data['cliente']);
            $this->db->join($this->DB_TABLES['estrutura-lista-operacao'] . ' AS O', 'O.IDSegmento=A.IDSegmento');
        } elseif ($data['coluna'] === 'GestorImediato') {
            $data['coluna'] = 'NomeColaborador';

            $cod = $this->db->where('IDEstrutura', $data['id'])
                            ->get($this->DB_TABLES['estrutura-atual'])
                            ->row_array()['CodNivelHierarquico'];

            $this->db->select("A.IDEstrutura AS IDGestorImediato, A.NomeColaborador + ' - ' + CONVERT(VARCHAR(9),A.MatriculaElo) AS GestorImediato")
                    ->join($this->DB_TABLES['estrutura-corporativos'] . ' AS C', 'C.IDEstrutura=A.IDEstrutura')
                    ->join($this->DB_TABLES['estrutura-lista-funcao'] . ' AS F', 'F.IDFuncao=C.IDFuncao')
                    ->join($this->DB_TABLES['estrutura-lista-nivel-hierarquico'] . ' AS H', 'H.IDNivelHierarquico=F.IDNivelHierarquico')
                    ->where("H.CodNivelHierarquico>1");
        }
        $query = $this->db->order_by($data['coluna'])
                ->get($this->DB_TABLES[$data['tabela']] . ' AS A');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return false;
    }

    public function update_personal_data($data) {
        $update = [
            'IDEstadoCivil' => $data['IDEstadoCivil'],
            'IDGrauInstrucao' => $data['IDGrauInstrucao'],
            'DataAlteracao' => date('Y-m-d H:i:s'),
            'UsuarioAlteracao' => $this->session->userdata('USU_ID')
        ];
        $this->db->where('IDEstrutura', $data['IDEstrutura'])
            ->update($this->DB_TABLES['estrutura-pessoais'], $update);
        if ($this->db->affected_rows() > 0) {
            return ['msg' => 'success'];
        }
        return ['msg' => 'error'];
    }

    public function update_corporate_data($data) {
        $update = [
            'IDStatusGestor' => $data['IDStatusGestor'],
            'HorarioEntrada' => $data['HorarioEntrada'],
            'HorarioSaida' => $data['HorarioSaida'],
            'DataAlteracao' => date('Y-m-d H:i:s'),
            'UsuarioAlteracao' => $this->session->userdata('USU_ID')
        ];
        $this->db->where('IDEstrutura', $data['IDEstrutura'])
            ->update($this->DB_TABLES['estrutura-corporativos'], $update);
        if ($this->db->affected_rows() > 0) {
            return ['msg' => 'success'];
        }
        return ['msg' => 'error'];
    }

    public function update_allocation_data($data) {
        $operacao = $this->db->where(['IDCliente' => $data['IDCliente'], 'IDSegmento' => $data['IDSegmento']])
                            ->get($this->DB_TABLES['estrutura-lista-operacao'])
                            ->row_array()['IDOperacao'];
        $update = [
            'IDGestorImediato' => $data['IDGestorImediato'],
            'IDSetor' => $data['IDSetor'],
            'IDSite' => $data['IDSite'],
            'IDOperacao' => $operacao,
            'DataAlteracao' => date('Y-m-d H:i:s'),
            'UsuarioAlteracao' => $this->session->userdata('USU_ID')
        ];
        $this->db->where('IDEstrutura', $data['IDEstrutura'])
            ->update($this->DB_TABLES['estrutura-corporativos'], $update);
        if ($this->db->affected_rows() > 0) {
            return ['msg' => 'success'];
        }
        return ['msg' => 'error'];
    }

    public function put_contact_data($data) {
        $update = [
            'TelefoneFixo01' => $data['TelefoneFixo01'],
            'TelefoneFixo02' => $data['TelefoneFixo02'],
            'TelefoneCelular01' => $data['TelefoneCelular01'],
            'TelefoneCelular02' => $data['TelefoneCelular02'],
            'TelefoneCorporativo' => $data['TelefoneCorporativo'],
            'TelefoneComercial' => $data['TelefoneComercial'],
            'TelefoneEmergencia' => $data['TelefoneEmergencia'],
            'ContatoEmergencia' => $data['ContatoEmergencia'],
            'EmailPessoal' => $data['EmailPessoal'],
            'EmailCorporativo' => $data['EmailCorporativo'],
            'DataAlteracao' => date('Y-m-d H:i:s'),
            'UsuarioAlteracao' => $this->session->userdata('USU_ID')
        ];
        $this->db->where('IDEstrutura', $data['IDEstrutura'])
            ->update($this->DB_TABLES['estrutura-contatos'], $update);
        if ($this->db->affected_rows() > 0) {
            return ['msg' => 'success'];
        }
        return ['msg' => 'error'];
    }

}