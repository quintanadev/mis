<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function validate_network() {
        $int = explode('.', (isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : $_SERVER['SERVER_ADDR']));
        $ext = explode('.', $_SERVER['REMOTE_ADDR']);
        if ($int[0] === $ext[0] || $int[1] === $ext[1]) :
            return TRUE;
        endif;
        return FALSE;
    }

    public function validate_ldap($user, $password) {
        $domain = "GRUPOELO.INT";
        $user .= "@{$domain}";
        $base_dn = 'DC=GRUPOELO,DC=INT';
        $filter = "(&(objectClass=user)(samaccountname={$user}))";
        $connect = ldap_connect($domain);
        if ($connect) :
            // We have to set this option for the version of Active Directory we are using.
            ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
            ldap_set_option($connect, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.
            
            @$bind = ldap_bind($connect, $user, $password);
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

    public function get_user($user, $login = FALSE) {
        if ($user) :
            $query = $this->db->where('id_user', $user)
                            ->get('admin_users');
            if ($query->num_rows() > 0) :
                return $query->row_array();
            endif;
        else:
            $query = $this->db->where('registration', (is_numeric(substr($login, 1)) ? intval($login) : $login))
                            ->get('admin_users');
            if ($query->num_rows() > 0) :
                return $query->row_array();
            else:
                $query = $this->db->where('login', $login)
                            ->get('admin_users');
                if ($query->num_rows() > 0) :
                    return $query->row_array();
                endif;
            endif;
        endif;
        return FALSE;
    }

    public function post_user($data) {
        $insert = [
            'registration' => $data['registration'],
            'login' => strtolower($data['login']),
            'password' => md5($data['password']),
            'user_name' => strtoupper($data['user_name']),
            'email' => strtolower($data['email'])
        ];
        $this->db->insert('admin_users', $insert);
        if ($this->db->affected_rows() > 0) :
            return TRUE;
        endif;
        return FALSE;
    }

    public function get_structure($registration) {
        $query = $this->db->where('matricula_elo', $registration)
                        ->get('MIS_ESTRUTURA.dbo.vw_estrutura_atual');
        if ($query->num_rows() > 0) :
            return $query->row_array();
        endif;
        return FALSE;
    }

    public function get_user_operations($registration) {
        $query = $this->db->distinct()
                        ->select('cliente AS operation')
                        ->group_start()
                            ->where('matricula_elo', $registration)
                            ->or_where('matricula_elo_gestor_1', $registration)
                            ->or_where('matricula_elo_gestor_2', $registration)
                            ->or_where('matricula_elo_gestor_3', $registration)
                            ->or_where('matricula_elo_diretor', $registration)
                        ->group_end()
                        ->where('cliente IS NOT NULL')
                        ->get('MIS_ESTRUTURA.dbo.vw_estrutura_atual');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function get_permission_operations($user) {
        $query = $this->db->distinct()
                        ->select('OPER.tags AS operation')
                        ->join('admin_operations' . ' AS OPER', 'OPER.id_operation=PUO.id_operation')
                        ->where('PUO.id_user', $user)
                        ->get('permission_user_operation' . ' AS PUO');
        if ($query->num_rows() > 0) :
            return $query->result_array();
        endif;
        return FALSE;
    }

    public function post_log_user($users, $event) {
        $insert = [
            'id_user' => $users,
            'log_type' => $event,
            'id_session' => session_id(),
            'browser' => $this->input->user_agent(),
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ];
        $this->db->insert('admin_log_system', $insert);
        return TRUE;
    }

    public function post_user_session() {
        /**
         * Define configurações GLOBAIS da aplicação
         */
        $queryGlobal = $this->db->get('admin_global_config')->result_array();
        $configGlobal = [];
        foreach ($queryGlobal as $key => $value) {
            $configGlobal[$value['config_tag']] = $value['config_value'];
        }

        /**
         * Define dados do USUARIO
         */
        $user = $this->get_user($this->session->userdata('USER_ID'));

        /**
         * Define Configurações do USUÁRIO
         */
        $queryUser = $this->db->where('id_user', $this->session->userdata('USU_ID'))
                            ->get('admin_user_config')
                            ->result_array();
        $configUser = [];
        foreach ($queryUser as $key => $value) :
            $configUser[$value['config_tag']] = $value['config_value'];
        endforeach;

        /**
         * Define MENU da aplicação
         */
        if (!$user['is_employee']) {
            $this->db->where(['client_access' => 1]);
        }
        if (!$user['is_admin']) {
            $this->db->where(['admin_access' => 0]);
        }
        $menuP = $this->db->where(['app' => 'portal', 'is_active' => 1])
                            ->order_by('level ASC,order ASC')
                            ->get('admin_menus')
                            ->result_array();
        $menuPortal = [];
        foreach ($menuP as $key => $value) {
            if ($value['level'] === 0) {
                $menuPortal[$value['id_menu']] = $value;
            } elseif ($value['level'] === 1) {
                $menuPortal[$value['id_title']]['menu'][$value['id_menu']] = $value;
            } elseif ($value['level'] === 2) {
                $menuPortal[$value['id_title']]['menu'][$value['id_group']]['menu_group'][$value['id_menu']] = $value;
            } elseif ($value['level'] === 3) {
                $menuPortal[$value['id_title']]['menu'][$value['id_group']]['menu_group'][$value['id_subgroup']]['menu_subgroup'][$value['id_menu']] = $value;
            }
        }
        
        /**
         * Define dados do MENU ATUAL da aplicação
         */
        $menuCurrent = $this->db->where(['app' => 'portal', 'url' => $this->uri->uri_string()])
                            ->get('admin_menus')
                            ->row_array();
        if ($menuCurrent['id_menu'] > 1) :
            $this->post_log_menu($this->session->userdata('USER_ID'), $menuCurrent['id_menu']);
        endif;

        /**
         * Define SCRIPTS a serem carregados
         */
        $scripts = $this->db->select('script')
                ->where(['route' => uri_string()])
                ->order_by('order', 'ASC')
                ->get('admin_routes_scripts')
                ->result_array();

        /**
         * Define dados de ESTRUTURA
         */
        $structure = $this->get_structure($user['registration']);

        /**
         * Define OPERAÇÕES de acesso
         */
        $op = $this->get_permission_operations($this->session->userdata('USER_ID'));
        if (!$op) :
            $op = $this->get_user_operations($user['registration']);
        endif;

        $operations = [];
        if ($op) :
            foreach ($op as $value) :
                array_push($operations, $value['operation']);
            endforeach;
        endif;
        
        /**
         * Salva dados na sessão
         */
        $this->session->set_userdata([
            'CONFIG_G' => $configGlobal,
            'CONFIG_U' => $configUser,
            'MENU_PORTAL' => $menuPortal,
            'MENU_CURRENT' => $menuCurrent,
            'MENU_SCRIPTS' => $scripts,
            'STRUCTURE' => $structure,
            'USER' => $user,
            'USER_NAME' => explode(' ', $user['user_name'])[0],
            'USER_OPERATIONS' => explode(',', implode(',', $operations))
        ]);

        return TRUE;
    }

    public function post_log_menu($user, $menu) {
        $data = [
            'id_user' => $user,
            'id_menu' => $menu
        ];
        $query = $this->db->where($data)
                        ->where('reference_date', date('Y-m-d'))
                        ->get('admin_log_menu');
        if ($query->num_rows() > 0) :
            $this->db->where($data)
                    ->where(['reference_date' => date('Y-m-d')])
                    ->update('admin_log_menu', [
                        'count_access' => $query->row_array()['count_access'] + 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
        else:
            $this->db->insert('admin_log_menu', $data);
        endif;
        return TRUE;
    }

    public function count_log_system($data = NULL) {
        $query = $this->db->where('created_at>=' , date('Y-m-d', strtotime("{$data['dias']} days")))
                ->where('log_type', 'LOGIN')
                ->get('admin_log_system');
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
            $select = $this->db->where(['config_tag' => $key, 'id_user' => $this->session->userdata('USU_ID')])
                            ->get('admin_user_config');
            if ($select->num_rows() > 0) :
                $this->db->where(['config_tag' => $key, 'id_user' => $this->session->userdata('USU_ID')])
                        ->update('admin_user_config', ['config_value' => $value]);
                if ($this->db->affected_rows() > 0) :
                    $success++;
                else:
                    $error++;
                endif;
            else:
                $this->db->insert('admin_user_config', ['config_tag' => $key, 'id_user' => $this->session->userdata('USU_ID'), 'config_value' => $value]);
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

    public function update_password($data) {
        $update = [
            'password' => md5($data['Senha']),
            'updated_at' => date('Y-m-d H:i:s'),
            'reset_password' => 0
        ];
        $this->db->where('id_user', $this->session->userdata('USU_ID'))
                ->update('admin_users', $update);
        if ($this->db->affected_rows() > 0) :
            return TRUE;
        endif;
        return FALSE;
    }

    public function get_route() {
        $route = uri_string();
        $query = $this->db->where('route', $route)
                ->get('admin_routes');
        if (!$query->num_rows()) {
            $this->db->insert('admin_routes', ['route' => $route]);
            $query = $this->db->where('route', $route)
                    ->get('admin_routes');
            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return FALSE;
        }
        return $query->row_array();
    }

    public function get_birthdays() {
        $query = $this->db
            ->select('id_estrutura,nome')
            ->where('CONVERT(VARCHAR(5),data_nascimento,103)', date('d/m'))
            ->order_by('nome')
            ->get('MIS_ESTRUTURA.dbo.vw_estrutura_atual');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

}