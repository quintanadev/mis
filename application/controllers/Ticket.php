<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ticket_Model', 'Ticket');
    }

    public function index() {
        $data['page_title'] = 'Help Desk';
        $data['page_subtitle'] = 'Chamados de atribuição do MIS';
        $data['views'] = ['pages/ticket/index'];

        $this->load->view('site/layout', $data);
    }

    public function created() {
        $data['page_title'] = 'Help Desk';
        $data['page_subtitle'] = 'Chamados de atribuição do MIS';
        $data['views'] = ['pages/ticket/created'];

        $this->load->view('site/layout', $data);
    }

    public function detail($id = null) {
        if (!$id) redirect('home/error_404');

        $data['page_title'] = "Detalhes do Chamado";
        $data['page_subtitle'] = 'Help Desk';
        $data['views'] = ['pages/ticket/detail'];
        $data['ticket'] = $this->Ticket->get_ticket_detail($id);

        $this->load->view('site/layout', $data);
    }

    public function get_ticket() {
        $post = $this->input->post();
        $retorno = $this->Ticket->get_ticket($post);

        $regTotal = ($retorno ? count($retorno) : 0);
        $regMostrar = (intval($post['length']) < 0 ? $regTotal : intval($post['length']));
        $regInicio = intval($post['start']);
        $regFimAux = $regInicio + $regMostrar;
        $regFim = ($regFimAux > $regTotal ? $regTotal : $regFimAux);

        $data = [];
        if ($retorno) :
            for ($i = $regInicio; $i < $regFim; $i++) :
                $data['data'][] = [
                    'IDTicket' => $retorno[$i]['IDTicket'],
                    'TipoSolicitacao' => $retorno[$i]['TipoSolicitacao'],
                    'UsuarioCadastro' => $retorno[$i]['UsuarioCadastro'],
                    'DataCadastro' => FormatarData($retorno[$i]['DataCadastro'], 'd/m/Y H:i:s'),
                    'Status' => '<span class="badge badge-' . 
                        ($retorno[$i]['Status'] === "Aberto" ? "danger" :
                        ($retorno[$i]['Status'] === "Aguardando Tratativa" ? "warning" :
                        ($retorno[$i]['Status'] === "Respondido" ? "success" :
                        "secondary"))) . '">' . $retorno[$i]['Status'] . '</span>',
                    'Acoes' => '<a href="' . base_url("ticket/detail/{$retorno[$i]['IDTicket']}") . '" class="btn btn-secondary btn-sm"><i class="mdi mdi-comment-search-outline"></i></a>'
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

    public function getTipoSolicitacao() {
        $retorno = $this->modTkt->getTipoSolicitacao();
        echo json_encode($retorno);
    }

    public function getSolicitacao() {
        $post = $this->input->post();
        $retorno = $this->modTkt->getSolicitacao($post);
        echo json_encode($retorno);
    }

    public function getOperacao() {
        $retorno = $this->modTkt->getOperacao();
        echo json_encode($retorno);
    }

    public function putTicket() {
        $post = $this->input->post();
        $retorno = $this->modTkt->putTicket($post);
        echo json_encode($retorno);
    }

    public function updateTratativa() {
        $post = $this->input->post();
        $retorno = $this->modTkt->updateTratativa($post);
        echo json_encode($retorno);
    }

    public function getTicketDetalhe() {
        $post = $this->input->post();
        $retorno = $this->modTkt->getTicketDetalhe($post);
        echo json_encode($retorno);
    }

    public function getTicketComentario() {
        $post = $this->input->post();
        $retorno = $this->modTkt->getTicketComentario($post);
        echo json_encode($retorno);
    }

}