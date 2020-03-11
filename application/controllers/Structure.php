<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Structure extends MY_Controller {
	
	public function __construct() {
        parent::__construct();
        $this->load->model('Structure_Model', 'Structure');
	}
	
	public function index() {
		$data['page_title'] = 'Estrutura';
        $data['page_subtitle'] = 'Lista de Colaboradores';
		$data['views'] = ['pages/structure/index'];
		
		$this->load->view('site/layout', $data);
    }
    
    public function employee($id = null) {
        if ($id) {
            $col = $this->Structure->getemployees($id);
            if ($col) {
                $data['page_title'] = 'Estrutura';
                $data['page_subtitle'] = 'Lista de Colaboradores';
                $data['views'] = [
                    'pages/estrutura/colaborador',
                    'pages/estrutura/editar-pessoais',
                    'pages/estrutura/editar-corporativos',
                    'pages/estrutura/editar-alocacao',
                    'pages/estrutura/historico-alocacao',
                    'pages/estrutura/editar-acessos',
                    'pages/estrutura/editar-contatos'
                ];
                $data['colaborador'] = $col;
                
                $this->load->view('layout', $data);
            } else {
                redirect(base_url('estrutura'));
            }            
        } else {
            redirect(base_url('acesso-negado'));
        }
    }
	
	public function get_current_structure() {
		$post = $this->input->post();
        $retorno = $this->Estrutura->get_current_structure($post);

        $regTotal = ($retorno ? count($retorno) : 0);
        $regMostrar = (intval($post['length']) < 0 ? $regTotal : intval($post['length']));
        $regInicio = intval($post['start']);
        $regFimAux = $regInicio + $regMostrar;
        $regFim = ($regFimAux > $regTotal ? $regTotal : $regFimAux);

        $data = [];
        if ($retorno) :
            for ($i = $regInicio; $i < $regFim; $i++) :
                $data['data'][] = [
                    'IDEstrutura' => $retorno[$i]['IDEstrutura'],
                    'NomeColaborador' => $retorno[$i]['NomeColaborador'],
                    'MatriculaElo' => $retorno[$i]['MatriculaElo'],
                    'Sexo' => $retorno[$i]['Sexo'],
                    'Acoes' => '<a href="' . base_url("estrutura/colaborador/{$retorno[$i]['IDEstrutura']}") . '" class="btn btn-secondary btn-xs"><i class="fe-edit"></i></a>'
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
    
    function get_data_select() {
        $post = $this->input->post();
        $data = $this->Structure->get_data_select($post);
        echo json_encode(['data' => $data]);
    }

    public function update_personal_data() {
        $post = $this->input->post();
        $data = $this->Structure->update_personal_data($post);
        echo json_encode(['data' => $data]);
    }

    public function update_corporate_data() {
        $post = $this->input->post();
        $data = $this->Structure->update_corporate_data($post);
        echo json_encode(['data' => $data]);
    }

    public function update_allocation_data() {
        $post = $this->input->post();
        $data = $this->Structure->update_allocation_data($post);
        echo json_encode(['data' => $data]);
    }

    public function put_contact_data() {
        $post = $this->input->post();
        $data = $this->Structure->put_contact_data($post);
        echo json_encode(['data' => $data]);
    }
    
}