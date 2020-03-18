<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function validaRedeInterna() {
        $int = explode('.', (isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : $_SERVER['SERVER_ADDR']));
        $ext = explode('.', $_SERVER['REMOTE_ADDR']);
        if ($int[0] === $ext[0] || $int[1] === $ext[1]) :
            return TRUE;
        endif;
        return FALSE;
    }

    public function validaActiveDirectory($usuario, $senha) {
        $domain = "GRUPOELO.INT";
        $usuario .= "@{$domain}";
        $base_dn = 'DC=GRUPOELO,DC=INT';
        $filter = "(&(objectClass=user)(samaccountname={$usuario}))";
        $connect = ldap_connect($domain);
        if ($connect) :
            // We have to set this option for the version of Active Directory we are using.
            ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
            ldap_set_option($connect, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.
            
            @$bind = ldap_bind($connect, $usuario, $senha);
            if ($bind) :
                ldap_control_paged_result($connect, 1);
                $search = ldap_search($connect, $base_dn, $filter, ['userprincipalname', 'displayname', 'samaccountname', 'cn', 'memberof']);
                $infos = ldap_get_entries($connect, $search);
                ldap_close($connect);
                return $infos;
            else:
                ldap_close($connect);
                return false;
            endif;
        endif;
    }

    public function getUsuario($usu, $login = FALSE) {
        if ($usu) :
            $query = $this->db->where('IDUsuario', $usu)
                            ->get('admin_usuarios');
            if ($query->num_rows() > 0) :
                return $query->row_array();
            endif;
        else:
            $query = $this->db->where('MatriculaElo', (is_numeric(substr($login, 1)) ? intval($login) : $login))
                            ->get('admin_usuarios');
            if ($query->num_rows() > 0) :
                return $query->row_array();
            else:
                $query = $this->db->where('Login', $login)
                            ->get('admin_usuarios');
                if ($query->num_rows() > 0) :
                    return $query->row_array();
                endif;
            endif;
        endif;
        return FALSE;
    }

    public function postUsuario($data) {
        $insert = [
            'MatriculaElo' => $data['MatriculaElo'],
            'Login' => strtolower($data['Login']),
            'Senha' => md5($data['Senha']),
            'NomeUsuario' => strtoupper($data['NomeUsuario']),
            'Email' => strtolower($data['Email'])
        ];
        $this->db->insert('admin_usuarios', $insert);
        if ($this->db->affected_rows() > 0) :
            return TRUE;
        endif;
        return FALSE;
    }

    public function getEstrutura($matricula) {
        $query = $this->db->where('MatriculaElo', $matricula)
                        ->get($this->DB_TABLES['estrutura-atual']);
        if ($query->num_rows() > 0) :
            return $query->row_array();
        endif;
        return FALSE;
    }

    public function getOperacoesUsuario($matricula) {
        $query = $this->db->distinct()
                        ->select('Cliente AS operacao')
                        ->group_start()
                            ->where('MatriculaElo', $matricula)
                            ->or_where('IDGestorImediato', $matricula)
                            ->or_where('IDGestor2', $matricula)
                            ->or_where('IDGestor3', $matricula)
                            ->or_where('IDDiretor', $matricula)
                        ->group_end()
                        ->where('Cliente IS NOT NULL')
                        ->get($this->DB_TABLES['estrutura-atual']);
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function getOperacoesPermissoes($usuario) {
        $query = $this->db->distinct()
                        ->select('OPER.Alias AS operacao')
                        ->join('admin_operacoes' . ' AS OPER', 'OPER.IDOperacao=PUO.IDOperacao')
                        ->where('PUO.IDUsuario', $usuario)
                        ->get('admin_per_usuarios_operacoes' . ' AS PUO');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function setLogSistema($usu, $evn) {
        $insert = [
            'IDUsuario' => $usu,
            'Evento' => $evn,
            'IDSession' => session_id(),
            'Navegador' => $this->input->user_agent(),
            'IPOrigem' => $_SERVER['REMOTE_ADDR']
        ];
        $this->db->insert('admin_log_sistema', $insert);
        return TRUE;
    }

    public function setSessionUsuario() {
        /**
         * Define configurações GLOBAIS da aplicação
         */
        $queryGlobal = $this->db->get('admin_configuracoes_globais')->result_array();
        $configGlobal = [];
        foreach ($queryGlobal as $key => $value) {
            $configGlobal[$value['ConfigAlias']] = $value['ConfigValor'];
        }

        /**
         * Define dados do USUARIO
         */
        $usuario = $this->getUsuario($this->session->userdata('USU_ID'));

        /**
         * Define Configurações do USUÁRIO
         */
        $queryUser = $this->db->where('IDUsuario', $this->session->userdata('USU_ID'))
                            ->get('admin_configuracoes_usuarios')
                            ->result_array();
        $configUser = [];
        foreach ($queryUser as $key => $value) :
            $configUser[$value['ConfigAlias']] = $value['ConfigValor'];
        endforeach;

        /**
         * Define MENU da aplicação
         */
        if (!$usuario['Funcionario']) {
            $this->db->where(['AcessoCliente' => 1]);
        }
        if (!$usuario['Admin']) {
            $this->db->where(['AcessoAdmin' => 0]);
        }
        $menuP = $this->db->where(['MenuAPP' => 'portal', 'Ativo' => 1])
                            ->order_by('MenuTipo ASC,Ordem ASC')
                            ->get('admin_menus')
                            ->result_array();
        $menuPortal = [];
        foreach ($menuP as $key => $value) {
            if ($value['MenuTipo'] === 0) {
                $menuPortal[$value['IDMenu']] = $value;
            } elseif ($value['MenuTipo'] === 1) {
                $menuPortal[$value['IDMenuTitulo']]['Menu'][$value['IDMenu']] = $value;
            } elseif ($value['MenuTipo'] === 2) {
                $menuPortal[$value['IDMenuTitulo']]['Menu'][$value['IDMenuGrupo']]['MenuGrupo'][$value['IDMenu']] = $value;
            } elseif ($value['MenuTipo'] === 3) {
                $menuPortal[$value['IDMenuTitulo']]['Menu'][$value['IDMenuGrupo']]['MenuGrupo'][$value['IDSubMenuGrupo']]['SubMenuGrupo'][$value['IDMenu']] = $value;
            }
        }
        
        /**
         * Define dados do MENU ATUAL da aplicação
         */
        $menuAtual = $this->db->where(['MenuAPP' => 'portal', 'MenuURL' => $this->uri->uri_string()])
                            ->get('admin_menus')
                            ->row_array();
        if ($menuAtual['IDMenu'] > 1) :
            $this->setLogMenu($this->session->userdata('USU_ID'), $menuAtual['IDMenu']);
        endif;

        /**
         * Define SCRIPTS a serem carregados
         */
        $scripts = $this->db->select('SCR.Script')
                ->where(['AMS.IDMenu' => $menuAtual['IDMenu']])
                ->join('admin_scripts AS SCR', 'SCR.IDScript=AMS.IDScript')
                ->get('admin_menus_scripts AS AMS')
                ->result_array();

        /**
         * Define dados de ESTRUTURA
         */
        $estrutura = $this->getEstrutura($usuario['MatriculaElo']);

        /**
         * Define OPERAÇÕES de acesso
         */
        $op = $this->getOperacoesPermissoes($this->session->userdata('USU_ID'));
        if (!$op) :
            $op = $this->getOperacoesUsuario($usuario['MatriculaElo']);
        endif;

        $operacoes = [];
        if ($op) :
            foreach ($op as $value) :
                array_push($operacoes, $value['operacao']);
            endforeach;
        endif;
        
        /**
         * Salva dados na sessão
         */
        $this->session->set_userdata([
            'CONFIG_G' => $configGlobal,
            'CONFIG_U' => $configUser,
            'MENU_PORTAL' => $menuPortal,
            'MENU_ATUAL' => $menuAtual,
            'MENU_SCRIPTS' => $scripts,
            'ESTRUTURA' => $estrutura,
            'USUARIO' => $usuario,
            'USU_NOME' => explode(' ', $usuario['NomeUsuario'])[0],
            'USU_SOBRENOME' => array_reverse(explode(' ', $usuario['NomeUsuario']))[0],
            'USU_OPERS' => explode(',', implode(',', $operacoes))
        ]);

        return TRUE;
    }

    public function setLogMenu($usu, $menu) {
        $data = [
            'IDUsuario' => $usu,
            'IDMenu' => $menu
        ];
        $query = $this->db->where($data)
                        ->where('DataReferencia', date('Y-m-d'))
                        ->get('admin_log_menu');
        if ($query->num_rows() > 0) :
            $this->db->where($data)
                    ->where(['DataReferencia' => date('Y-m-d')])
                    ->update('admin_log_menu', ['QtdAcessos' => $query->row_array()['QtdAcessos'] + 1]);
        else:
            $this->db->insert('admin_log_menu', $data);
        endif;
        return TRUE;
    }

    public function getLogSistema($data = NULL) {
        $query = $this->db->where('DataCadastro>=' , date('Y-m-d', strtotime("{$data['dias']} days")))
                ->where('Evento', 'LOGIN')
                ->get('admin_log_sistema');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    /**
     * Atualiza Configurações Pessoais do Usuário
     *
     * @param [type] $data
     * @return void
     */
    public function update_settings_user($data) {
        $error = 0;
        $success = 0;
        foreach ($data as $key => $value) :
            $select = $this->db->where(['ConfigAlias' => $key, 'IDUsuario' => $this->session->userdata('USU_ID')])
                            ->get('admin_configuracoes_usuarios');
            if ($select->num_rows() > 0) :
                $this->db->where(['ConfigAlias' => $key, 'IDUsuario' => $this->session->userdata('USU_ID')])
                        ->update('admin_configuracoes_usuarios', ['ConfigValor' => $value]);
                if ($this->db->affected_rows() > 0) :
                    $success++;
                else:
                    $error++;
                endif;
            else:
                $this->db->insert('admin_configuracoes_usuarios', ['ConfigAlias' => $key, 'IDUsuario' => $this->session->userdata('USU_ID'), 'ConfigValor' => $value]);
                if ($this->db->affected_rows() > 0) :
                    $success++;
                else:
                    $error++;
                endif;
            endif;
        endforeach;
        if (!$error) :
            $this->session->set_flashdata(['type' => 'success', 'msg' => "Total de {$success} configurações salvas com sucesso!"]);
        endif;
        return ['type' => ($error > 0 ? 'danger' : 'success'), 'msg' => ($error > 0 ? "Oops! Erro ao atualizar {$error} configurações." : 'Configurações salvas com sucesso!')];
    }

    public function set_password($data) {
        $update = [
            'Senha' => md5($data['Senha']),
            'DataAlteracao' => date('Y-m-d H:i:s'),
            'ResetSenha' => 0
        ];
        $this->db->where('IDUsuario', $this->session->userdata('USU_ID'))
                ->update('admin_usuarios', $update);
        if ($this->db->affected_rows() > 0) :
            return TRUE;
        endif;
        return FALSE;
    }

}