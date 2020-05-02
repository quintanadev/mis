<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incident extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Support/Incident_Model', 'Incident');
    }

    public function index() {
        $data['page_title'] = 'Help Desk';
        $data['page_subtitle'] = 'Chamados de atribuição do MIS';
        $data['views'] = ['pages/support/incident/index'];

        $this->load->view('site/layout', $data);
    }

    public function created() {
        $data['page_title'] = 'Help Desk';
        $data['page_subtitle'] = 'Chamados de atribuição do MIS';
        $data['views'] = ['pages/support/incident/created'];

        $this->load->view('site/layout', $data);
    }

    public function detail() {
        $id = $_GET['id'];
        if (!$id) redirect('home/error_404');

        $data['page_title'] = "Detalhes do Chamado";
        $data['page_subtitle'] = 'Help Desk';
        $data['views'] = ['pages/support/incident/detail'];

        $this->load->view('site/layout', $data);
    }

    public function get_incident() {
        $post = $this->input->post();
        $retorno = $this->Incident->get_incident($post);

        $regTotal = ($retorno ? count($retorno) : 0);
        $regMostrar = (intval($post['length']) < 0 ? $regTotal : intval($post['length']));
        $regInicio = intval($post['start']);
        $regFimAux = $regInicio + $regMostrar;
        $regFim = ($regFimAux > $regTotal ? $regTotal : $regFimAux);

        $data = [];
        if ($retorno) :
            for ($i = $regInicio; $i < $regFim; $i++) :
                $data['data'][] = [
                    'id_incident' => '#' . substr('000000' . $retorno[$i]['id_incident'], -6, 6),
                    'operation' => '<img src="' . base_url($retorno[$i]['image']) . '" alt="' . $retorno[$i]['operation'] . '" title="' . $retorno[$i]['operation'] . '" class="rounded-circle avatar-xs" />',
                    'request_type' => $retorno[$i]['request_type'],
                    'user_created' => $retorno[$i]['user_created'],
                    'created_at' => FormatarData($retorno[$i]['created_at'], 'd/m/Y H:i:s'),
                    'status' => '<span class="badge badge-' . 
                        ($retorno[$i]['status'] === "Aberto" ? "danger" :
                        ($retorno[$i]['status'] === "Aguardando Tratativa" ? "warning" :
                        ($retorno[$i]['status'] === "Respondido" ? "success" :
                        "secondary"))) . '">' . $retorno[$i]['status'] . '</span>',
                    'actions' => '<a href="' . base_url("support/incident/detail?id={$retorno[$i]['id_incident']}") . '" class="btn btn-secondary btn-sm"><i class="mdi mdi-comment-search-outline"></i></a>'
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

    public function get_incident_detail() {
        $post = $this->input->post();
        $retorno =$this->Incident->get_incident_detail($post);
        echo json_encode($retorno);
    }

    public function get_incident_comment() {
        $post = $this->input->post();
        $retorno = $this->Incident->get_incident_comment($post);
        echo json_encode($retorno);
    }

    public function get_request_type() {
        $retorno = $this->Incident->get_request_type();
        echo json_encode($retorno);
    }

    public function get_request() {
        $post = $this->input->post();
        $retorno = $this->Incident->get_request($post);
        echo json_encode($retorno);
    }

    public function get_operation() {
        $retorno = $this->Incident->get_operation();
        echo json_encode($retorno);
    }

    public function post_incident() {
        $post = $this->input->post();
        $retorno = $this->Incident->post_incident($post);
        echo json_encode($retorno);
    }

    public function post_comment() {
        $post = $this->input->post();
        $retorno = $this->Incident->post_comment($post);
        echo json_encode($retorno);
    }

}