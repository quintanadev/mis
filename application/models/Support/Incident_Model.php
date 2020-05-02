<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incident_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_incident($data) {
        if (!$this->session->userdata("USER")['is_mod_support_incident']) :
            $this->db->where("TKT.id_user_created", $this->session->userdata("USER_ID"));
        endif;
        if ($data['search']['value']) :
            $this->db->group_start()
                    ->like('TSOL.id_request_type', $data['search']['value'])
                    ->or_like('USU.user_name', $data['search']['value'])
                    ->or_like('STS.status', $data['search']['value'])
                    ->or_where("'#'+CONVERT(VARCHAR(12),TKT.id_incident)", $data['search']['value'])
                    ->group_end();
        endif;
        $query = $this->db->select('TKT.id_incident,TSOL.request_type,TKT.created_at,USU.user_name AS user_created,STS.status,OPE.operation,OPE.image')
                        ->join('admin_users AS USU', 'USU.id_user=TKT.id_user_created')
                        ->join('support_incidents_request_type AS TSOL', 'TSOL.id_request_type=TKT.id_request_type')
                        ->join('support_incidents_status AS STS', 'STS.id_status=TKT.id_status')
                        ->join('admin_operations AS OPE', 'OPE.id_operation=TKT.id_operation')
                        ->order_by($data['columns'][$data['order'][0]['column']]['name'], $data['order'][0]['dir'])
                        ->get('support_incidents AS TKT');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }
    
    public function get_incident_detail($data) {
        $query = $this->db->select('TKT.id_incident,CONVERT(VARCHAR(10),TKT.created_at,103) AS created_at,
            CONVERT(VARCHAR(8),TKT.created_at,108) AS created_hour,TKT.subject,TKT.description,
            USU.user_name AS user_created,USU.email AS email,OPER.operation,TSOL.request_type,
            SOL.request,STS.status,CONVERT(VARCHAR(10),TKT.sla_solution,103) AS sla_solution,TKT.is_deferred')
                        ->where('TKT.id_incident', $data['id'])
                        ->join('admin_operations AS OPER', 'OPER.id_operation=TKT.id_operation')
                        ->join('support_incidents_request_type AS TSOL', 'TSOL.id_request_type=TKT.id_request_type')
                        ->join('support_incidents_request AS SOL', 'SOL.id_request=TKT.id_request')
                        ->join('support_incidents_status AS STS', 'STS.id_status=TKT.id_status')
                        ->join('admin_users AS USU', 'USU.id_user=TKT.id_user_created')
                        ->get('support_incidents AS TKT');
        if ($query->num_rows() > 0) :
            return $query->row_array();
        endif;
        return ['msg' => 'Nenhum registro encontrado!', 'type' => 'danger'];
    }

    public function post_incident($data) {
        $data['id_user_created'] = $this->session->userdata('USER_ID');
        $this->db->insert('support_incidents', $data);
        if ($this->db->affected_rows() > 0) :
            $msg = ['type' => 'success', 'msg' => "Incidente criado com sucesso!<br><br>Ticket N°: #{$this->db->insert_id()}"];
            $this->session->set_flashdata($msg);
            return $msg;
        endif;
        return ['type' => 'danger', 'msg' => 'Oops! Erro ao criar novo chamado.<br>Favor tente novamente mais tarde ou contate o administrador do sistema.'];
    }

    public function post_comment($data) {
        $usuario = $this->session->userdata('USER_ID');
        $update = [
            'id_status' => $data['id_status'],
            'id_user_assigned' => $usuario
        ];
        if ($data['StatusOld'] === 'Aberto' && $data['id_status'] > 1) :
            $update = array_merge($update, [
                'TipoFechamento' => $data['TipoFechamento'],
                'sla_solution' => FormatarDataSQL($data['SLATratamento'])
            ]);
        endif;
        $this->db->where('id_incident', $data['id_incident'])
                ->update('support_incidents', $update);
        if ($this->db->affected_rows() > 0) :
            $insert = [
                'comment' => $data['comment'],
                'id_incident' => $data['id_incident'],
                'id_status' => $data['id_status'],
                'id_user' => $usuario
            ];
            $this->db->insert('support_incidents_comment', $insert);
            if ($this->db->affected_rows() > 0) :
                $msg = ['type' => 'success', 'msg' => "Resposta enviada com sucesso!<br><br>Ticket N°: #{$data['IDTicket']}"];
                $this->session->set_flashdata($msg);
                return $msg;
            endif;
            return ['type' => 'danger', 'msg' => 'Oops! Erro ao responder chamado.<br>Favor tente novamente mais tarde ou contate o administrador do sistema.']; 
        endif;
        return ['type' => 'danger', 'msg' => 'Oops! Erro ao responder chamado.<br>Favor tente novamente mais tarde ou contate o administrador do sistema.'];
    }

    public function get_request_type() {
        $query = $this->db->where('is_active', 1)
                        ->get('support_incidents_request_type');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_request($data = NULL) {
        if ($data) :
            $this->db->where('id_request_type', $data['id_request_type']);
        endif;
        $query = $this->db->where('is_active', 1)
                        ->get('support_incidents_request');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_operation() {
        $query = $this->db->where('is_active', 1)
                        ->where('is_filter', 1)
                        ->order_by('operation')
                        ->get('admin_operations');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_incident_comment($data) {
        $query = $this->db->select('COMENT.id_incident,CONVERT(VARCHAR(10),COMENT.created_at,103) AS created_at,
            CONVERT(VARCHAR(8),COMENT.created_at,108) AS created_hour,USU.user_name AS user_name,USU.is_mod_support_incident,
            USU.avatar,STS.status,COMENT.comment')
                        ->where('COMENT.id_incident', $data['id'])
                        ->join('support_incidents_status AS STS', 'STS.id_status=COMENT.id_status')
                        ->join('admin_users AS USU', 'USU.id_user=COMENT.id_user')
                        ->order_by('COMENT.created_at DESC')
                        ->get('support_incidents_comment AS COMENT');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return ['msg' => 'Nenhum comentário encontrado!', 'type' => 'info'];
    }

}