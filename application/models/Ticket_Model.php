<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_ticket($data) {
        if (!$this->session->userdata("USUARIO")['ModTicket']) :
            $this->db->where("TKT.IDUsuarioCadastro", $this->session->userdata("USU_ID"));
        endif;
        if ($data['search']['value']) :
            $this->db->group_start()
                    ->like('TSOL.TipoSolicitacao', $data['search']['value'])
                    ->or_like('USU.NomeUsuario', $data['search']['value'])
                    ->or_like('STS.Status', $data['search']['value'])
                    ->or_where("'#'+CONVERT(VARCHAR(12),TKT.IDTicket)", $data['search']['value'])
                    ->group_end();
        endif;
        $query = $this->db->select('TKT.IDTicket,TSOL.TipoSolicitacao,TKT.DataCadastro,USU.NomeUsuario AS UsuarioCadastro,STS.Status')
                        ->join('admin_usuarios AS USU', 'USU.IDUsuario=TKT.IDUsuarioCadastro')
                        ->join('ticket_tipo_solicitacoes AS TSOL', 'TSOL.IDTipoSolicitacao=TKT.IDTipoSolicitacao')
                        ->join('ticket_status AS STS', 'STS.IDStatus=TKT.IDStatus')
                        ->order_by($data['columns'][$data['order'][0]['column']]['name'], $data['order'][0]['dir'])
                        ->get('ticket_chamados AS TKT');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }
    
    public function get_ticket_detail($data) {
        $query = $this->db->select('TKT.IDTicket,CONVERT(VARCHAR(10),TKT.DataCadastro,103) AS DataCadastro,
            CONVERT(VARCHAR(8),TKT.DataCadastro,108) AS HoraCadastro,TKT.Assunto,TKT.Descricao,
            USU.NomeUsuario AS UsuarioCadastro,USU.Email AS UsuarioEmail,OPER.Operacao AS Operacao,TSOL.TipoSolicitacao,
            SOL.Solicitacao,STS.Status,CONVERT(VARCHAR(10),TKT.SLATratamento,103) AS SLATratamento,TKT.TipoFechamento')
                        ->where('TKT.IDTicket', $data)
                        ->join('admin_operacoes AS OPER', 'OPER.IDOperacao=TKT.IDOperacao')
                        ->join('ticket_tipo_solicitacoes AS TSOL', 'TSOL.IDTipoSolicitacao=TKT.IDTipoSolicitacao')
                        ->join('ticket_solicitacoes AS SOL', 'SOL.IDSolicitacao=TKT.IDSolicitacao')
                        ->join('ticket_status AS STS', 'STS.IDStatus=TKT.IDStatus')
                        ->join('admin_usuarios AS USU', 'USU.IDUsuario=TKT.IDUsuarioCadastro')
                        ->get('ticket_chamados AS TKT');
        if ($query->num_rows() > 0) :
            return $query->row_array();
        endif;
        return ['msg' => 'Nenhum registro encontrado!', 'type' => 'danger'];
    }

    public function putTicket($data) {
        $data['IDUsuarioCadastro'] = $this->session->userdata('USU_ID');
        $this->db->insert('ticket_chamados', $data);
        if ($this->db->affected_rows() > 0) :
            $msg = ['type' => 'success', 'msg' => "Ticket criado com sucesso!<br><br>Ticket N°: #{$this->db->insert_id()}"];
            $this->session->set_flashdata($msg);
            return $msg;
        endif;
        return ['type' => 'danger', 'msg' => 'Oops! Erro ao criar novo chamado.<br>Favor tente novamente mais tarde ou contate o administrador do sistema.'];
    }

    public function updateTratativa($data) {
        $usuario = $this->session->userdata('USU_ID');
        $update = [
            'IDStatus' => $data['IDStatus'],
            'IDUsuarioAtribuido' => $usuario
        ];
        if ($data['StatusOld'] === 'Aberto' && $data['IDStatus'] > 1) :
            $update = array_merge($update, [
                'TipoFechamento' => $data['TipoFechamento'],
                'SLATratamento' => FormatarDataSQL($data['SLATratamento'])
            ]);
        endif;
        $this->db->where('IDTicket', $data['IDTicket'])
                ->update('ticket_chamados', $update);
        if ($this->db->affected_rows() > 0) :
            $insert = [
                'Comentario' => $data['Comentario'],
                'IDTicket' => $data['IDTicket'],
                'IDStatus' => $data['IDStatus'],
                'IDUsuario' => $usuario
            ];
            $this->db->insert('ticket_comentarios', $insert);
            if ($this->db->affected_rows() > 0) :
                $msg = ['type' => 'success', 'msg' => "Resposta enviada com sucesso!<br><br>Ticket N°: #{$data['IDTicket']}"];
                $this->session->set_flashdata($msg);
                return $msg;
            endif;
            return ['type' => 'danger', 'msg' => 'Oops! Erro ao responder chamado.<br>Favor tente novamente mais tarde ou contate o administrador do sistema.']; 
        endif;
        return ['type' => 'danger', 'msg' => 'Oops! Erro ao responder chamado.<br>Favor tente novamente mais tarde ou contate o administrador do sistema.'];
    }

    public function getTipoSolicitacao() {
        $query = $this->db->where('Ativo', 1)
                        ->get('ticket_tipo_solicitacoes');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function getSolicitacao($data = NULL) {
        if ($data) :
            $this->db->where('IDTipoSolicitacao', $data['IDTipoSolicitacao']);
        endif;
        $query = $this->db->where('Ativo', 1)
                        ->get('ticket_solicitacoes');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function getOperacao() {
        $query = $this->db->where('Ativo', 1)
                        ->where('Filtro', 1)
                        ->order_by('Operacao')
                        ->get('admin_operacoes');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function getTicketComentario($data) {
        $query = $this->db->select('COMENT.IDTicket,CONVERT(VARCHAR(10),COMENT.DataCadastro,103) AS DataComentario,
            CONVERT(VARCHAR(8),COMENT.DataCadastro,108) AS HoraComentario,USU.NomeUsuario AS UsuarioComentario,
            USU.Avatar AS UsuarioAvatar,STS.Status,COMENT.Comentario')
                        ->where('COMENT.IDTicket', $data['IDTicket'])
                        ->join('ticket_status AS STS', 'STS.IDStatus=COMENT.IDStatus')
                        ->join('admin_usuarios AS USU', 'USU.IDUsuario=COMENT.IDUsuario')
                        ->order_by('COMENT.DataCadastro DESC')
                        ->get('ticket_comentarios AS COMENT');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return ['msg' => 'Nenhum comentário encontrado!', 'type' => 'info'];
    }

    public function getCountTicket($data) {
        if ($data['dias']) :
            $this->db->where('DataCadastro>=', date('Y-m-d', strtotime("{$data['dias']} days")));
        endif;
        $query = $this->db->count_all('ticket_chamados');
        return $query;
    }

}