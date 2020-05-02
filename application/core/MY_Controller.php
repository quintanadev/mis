<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $logged;

    public function __construct() {
        parent::__construct();
        $this->validate_session();
    }

    public function validate_session() {
        $this->logged = $this->session->userdata('USER_LOGGED');
        if ($this->logged) :
            $this->load->model('System_Model', 'System');
            $route = $this->System->get_route();
            $this->System->post_user_session();
            if ($this->session->userdata('USUARIO')['reset_password']) :
                $this->session->set_flashdata(['msg' => 'Favor alterar sua senha.']);
                redirect(base_url('user/change-password'), 'refresh');
            endif;
            if (!$this->session->userdata('USER')['is_admin'] && $this->session->userdata('MENU_CURRENT')['admin_access']) :
                redirect('access-denied', 'refresh');
            endif;
            return TRUE;
        else:
            redirect(base_url('user/login'), 'refresh');
        endif;
    }

}
