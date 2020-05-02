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
    
    public function employee() {
        $id = (isset($_GET['id']) ? $_GET['id'] : false);
        if ($id) {
            $col = $this->Structure->get_employee(['id' => $id]);
            if ($col) {
                $edit = (isset($_GET['edit']) ? $_GET['edit'] : false);
                if ($edit) {
                    $data['page_title'] = 'Estrutura';
                    $data['page_subtitle'] = 'Editar Dados';
                    $data['views'] = ['pages/structure/employee-edit-' . $edit];
                } else {
                    $data['page_title'] = 'Estrutura';
                    $data['page_subtitle'] = 'Dados do Colaborador';
                    $data['views'] = ['pages/structure/employee'];
                }
                $this->load->view('site/layout', $data);
            } else {
                redirect(base_url('structure'));
            }            
        } else {
            redirect(base_url('structure'));
        }
    }
	
	public function get_current_structure() {
		$post = $this->input->post();
        $retorno = $this->Structure->get_current_structure($post);

        $regTotal = ($retorno ? count($retorno) : 0);
        $regMostrar = (intval($post['length']) < 0 ? $regTotal : intval($post['length']));
        $regInicio = intval($post['start']);
        $regFimAux = $regInicio + $regMostrar;
        $regFim = ($regFimAux > $regTotal ? $regTotal : $regFimAux);

        $data = [];
        if ($retorno) :
            for ($i = $regInicio; $i < $regFim; $i++) :
                $data['data'][] = [
                    'id_estrutura' => $retorno[$i]['id_estrutura'],
                    'nome' => $retorno[$i]['nome'],
                    'matricula_elo' => $retorno[$i]['matricula_elo'],
                    'sexo' => $retorno[$i]['sexo'],
                    'actions' => '<a href="' . base_url("structure/employee?id={$retorno[$i]['id_estrutura']}") . '" class="btn btn-secondary btn-xs"><i class="fe-edit"></i></a>
                        <a href="' . base_url("structure/push-employee?id={$retorno[$i]['id_estrutura']}") . '" class="btn btn-primary btn-xs"><i class="fe-heart"></i></a>'
                ];
            endfor;
        endif;
        
        $data['draw'] = intval($post['draw']);
        $data['recordsTotal'] = $regTotal;
        $data['recordsFiltered'] = $regTotal;
        echo json_encode($data);
    }

    function get_employee() {
        $post = $this->input->post();
        $data = $this->Structure->get_employee($post);
        echo json_encode($data);
    }
    
    function get_data_select() {
        $post = $this->input->post();
        $data = $this->Structure->get_data_select($post);
        echo json_encode($data);
    }

    public function update_personal_data() {
        $post = $this->input->post();
        $data = $this->Structure->update_personal_data($post);
        echo json_encode($data);
    }

    public function update_corporate_data() {
        $post = $this->input->post();
        $data = $this->Structure->update_corporate_data($post);
        echo json_encode($data);
    }

    public function update_allocation_data() {
        $post = $this->input->post();
        $data = $this->Structure->update_allocation_data($post);
        echo json_encode($data);
    }

    public function update_contact_data() {
        $post = $this->input->post();
        $data = $this->Structure->update_contact_data($post);
        echo json_encode($data);
    }
    
}