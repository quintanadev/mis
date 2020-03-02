<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $logged;

    public function __construct() {
        parent::__construct();
        $this->validateSession();
    }

    public function validateSession() {
        $this->logged = $this->session->userdata('USU_LOGADO');
        if ($this->logged) :
            $this->load->model('System_Model', 'System');
            $this->System->setSessionUsuario();
            if ($this->session->userdata('USUARIO')['ResetSenha']) :
                $this->session->set_flashdata(['msg' => 'Favor alterar sua senha.']);
                redirect(base_url('user/change-password'), 'refresh');
            endif;
            if (!$this->session->userdata('USUARIO')['Admin'] && strstr($this->session->userdata('MENU_ATUAL')['MenuURL'], 'admin')) :
                redirect('access-denied', 'refresh');
            endif;
            return TRUE;
        else:
            redirect(base_url('user/login'), 'refresh');
        endif;
    }

}
