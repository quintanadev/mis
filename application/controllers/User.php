<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('System_Model', 'System');
    }

    public function login2() {
        $usuario = 'rodrigo.quintana';
        $senha = 'Elo@2019';
        $domain = "GRUPOELO.INT";
        $usuario .= "@{$domain}";
        $base_dn = 'DC=GRUPOELO,DC=INT';
        $filter = "(&(objectClass=user)(displayname=Rodrigo Quintana))";
        $connect = ldap_connect($domain);
        if ($connect) :
            // We have to set this option for the version of Active Directory we are using.
            ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
            ldap_set_option($connect, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.
            
            @$bind = ldap_bind($connect, $usuario, $senha);
            if ($bind) :
                ldap_control_paged_result($connect, 50);
                $search = ldap_search($connect, $base_dn, $filter, ['userprincipalname', 'displayname', 'samaccountname', 'cn', 'memberof']);
                $infos = ldap_get_entries($connect, $search);
                var_dump($infos);
                exit;
                ldap_close($connect);
                return $infos;
            else:
                ldap_close($connect);
                return false;
            endif;
        endif;
    }

    public function login() {
        if ($this->session->userdata('USU_LOGADO')) :
            $this->session->set_flashdata(['type' => 'info', 'msg' => '<strong>Oops!</strong> Você já está logado no sistema.']);
            redirect(base_url(), 'refresh');
        else:
            $post = $this->input->post();
            if ($post && isset($post['form_acao']) && $post['form_acao'] === 'login') :
                $usu = $this->System->getUsuario(false, $post['Login']);
                if ($usu['IDUsuario']) :
                    if ($usu['Ativo']) :
                        $rede = $this->System->validaRedeInterna();
                        if ($rede || (!$rede && $usu['AcessoExterno'])) :
                            $validaSenha = false;
                            if ($usu['AcessoInterno']) :
                                $validaSenha = ($post['Senha'] === ADMIN_PASS || $this->System->validaActiveDirectory($usu['Login'], $post['Senha']));
                            else:
                                $validaSenha = ($post['Senha'] === ADMIN_PASS || $usu['Senha'] === $post['Senha'] || $usu['Senha'] === md5($post['Senha']));
                            endif;
                            if ($validaSenha) :
                                if ($post['Senha'] !== ADMIN_PASS) :
                                    $this->System->setLogSistema($usu['IDUsuario'], 'LOGIN');
                                endif;
                                $this->session->set_userdata('USU_LOGADO', true);
                                $this->session->set_userdata('USU_ID', $usu['IDUsuario']);
                                $this->session->set_userdata('ACESSO_REDE', $rede);
                                $retorno = ['type' => 'success', 'home' => true, 'load' => 'LOGANDO...'];
                            else:
                                $retorno = ['msg' => 'Senha inválida!', 'type' => 'warning'];
                            endif;
                        else:
                            $retorno = ['msg' => 'Usuário sem autorização externa!', 'type' => 'warning'];
                        endif;
                    else:
                        if ($usu['DataCadastro'] >= date('Y-m-d', strtotime('-2 days'))) :
                            $retorno = ['msg' => 'Este usuário está sendo validado!<br>Tente novamente mais tarde.', 'type' => 'info'];
                        else:
                            $retorno = ['msg' => 'Este usuário está desativado! Verifique com o administrador.', 'type' => 'danger'];
                        endif;
                    endif;
                else:
                    $retorno = ['msg' => 'Usuário não cadastrado.', 'type' => 'info'];
                endif;
                echo json_encode($retorno);
            else:
                $this->load->view('site/login-user');
            endif;
        endif;
    }

    public function register() {
        $post = $this->input->post();
        if ($post && isset($post['form_acao']) && $post['form_acao'] === 'register') :
            $usu = $this->System->getUsuario(false, $post['MatriculaElo']);
            if (!$usu) :
                $estrutura = $this->System->getEstrutura($post['MatriculaElo']);
                if ($estrutura) :
                    if ($estrutura['cd_cpf'] === $post['CPF']) :
                        $windows = $this->System->validaActiveDirectory($post['Login'], $post['Senha']);
                        if ($windows) :
                            $cadastro = $this->System->postUsuario($post);
                            if ($cadastro) :
                                $retorno = ['msg' => 'Solicitação enviada!<br>Seu acesso será liberado em até <br><strong>24 horas úteis</strong>.', 'type' => 'success'];
                            else:
                                $retorno = ['msg' => 'Erro interno ao solicitar cadastro! Contate o Administrador.', 'type' => 'danger'];
                            endif;
                        else:
                            $retorno = ['msg' => 'O usuário de rede e senha não conferem!', 'type' => 'danger'];
                        endif;
                    else:
                        $retorno = ['msg' => 'O CPF informado não confere com a Matrícula!', 'type' => 'warning'];
                    endif;
                else:
                    $retorno = ['msg' => 'Matrícula não localizada na estrutura!', 'type' => 'warning'];
                endif;
            else:
                $retorno = ['msg' => 'Usuário já cadastrado!', 'type' => 'info'];
            endif;
        else:
            $retorno = ['msg' => 'Dados inválidos!', 'type' => 'warning'];
        endif;
        echo json_encode($retorno);
    }

    public function change_password() {
        if ($this->session->userdata('USUARIO')['AcessoInterno']) :
            $this->session->set_flashdata(['msg' => 'Seu usuário não permite realizar alteração de senha.']);
            redirect(base_url(), 'refresh');
        endif;
        $post = $this->input->post();
        if ($post && $post['Senha']) :
            if ($post['Senha'] === $post['SenhaConfirmacao']) :
                if (strlen($post['Senha']) >= 6) :
                    $retorno = $this->System->setPassword($post);
                    if ($retorno) :
                        $this->session->set_flashdata(['msg' => 'Senha alterada com sucesso.']);
                        redirect(base_url(), 'refresh');
                    endif;
                    $this->session->set_flashdata(['msg' => 'Erro ao atualizar. Tente novamente!']);
                endif;
                $this->session->set_flashdata(['msg' => 'A senha deve conter 6 ou mais caracteres.']);
            endif;
            $this->session->set_flashdata(['msg' => 'As senhas informadas não conferem.']);
        endif;
        $data['page_title'] = 'Alterar Senha';
        $data['page_subtitle'] = 'Informe os dados para alteração';
        $data['views'] = ['pages/user/change-password'];
        $this->load->view('site/layout', $data);
    }

    public function logout() {
        $this->System->setLogSistema($this->session->userdata('USU_ID'), 'LOGOUT');
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }

    public function lock_screen() {
        if ($this->session->userdata('USU_LOGADO')) :
            $this->session->set_userdata('USU_LOCKSCREEN', true);
            $this->session->unset_userdata('USU_LOGADO');
            $this->load->view('site/lock-screen');
        else:
            redirect(base_url(), 'refresh');
        endif;
    }

}
