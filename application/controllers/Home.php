<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index() {
		$data['page_title'] = 'Home';
        $data['page_subtitle'] = 'Bem-vindo ao Portal MIS!';
		$data['views'] = ['pages/user/home'];
		
		$this->load->view('site/layout', $data);
	}

	public function error_404() {
        $this->data['page_title'] = 'Página não encontrada';
        $this->data['page_subtitle'] = 'Erro 404!';
        $this->data['views'] = ['errors/error-404'];
        $this->load->view('site/layout', $this->data);
    }

    public function access_denied() {
        $this->data['page_title'] = 'Acesso Negado';
        $this->data['page_subtitle'] = '';
        $this->data['views'] = ['errors/access-denied'];
        $this->load->view('site/layout', $this->data);
    }
	
}
