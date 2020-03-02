<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Formata data de acordo com a formatação passada
 * @formatacao = "dd/mm/aaaa hh:mm:ss"
 */
if (!function_exists('FormatarData')) {

    function FormatarData($valor, $formatacao = "d/m/Y H:i:s") {
        if ($valor) {
            $data = date_create($valor);
            $data_formatada = date_format($data, $formatacao);

            return $data_formatada;
        }
        return FALSE;
    }

}

/**
 * Formata data para inserir no Banco
 * @formatacao = "aaaa-mm-dd hh:mm:ss"
 */
if (!function_exists('FormatarDataSQL')) {

    function FormatarDataSQL($valor) {
        if ($valor) {
            $data = ($valor == '' ? NULL : implode('-', array_reverse(explode('/', $valor))));
            return $data;
        }
        return NULL;
    }

}

/**
 * Formata CPF
 * @formatacao = "000.000.000-00"
 */
if (!function_exists('FormatarCPF')) {

    function FormatarCPF($valor) {
        if ($valor) {
            $cpf = substr($valor, 0, 3);
            $cpf .= '.';
            $cpf .= substr($valor, 3, 3);
            $cpf .= '.';
            $cpf .= substr($valor, 6, 3);
            $cpf .= '-';
            $cpf .= substr($valor, 9, 2);

            return $cpf;
        }
        return FALSE;
    }

}


/**
 * Convert mês de formato STRING para INT
 * @formatacao = "mm"
 */
if (!function_exists('ConverterTextoMes')) {

    function ConverterTextoMes($valor) {

        $mes_formatado = '';
        if ($valor === 'JANEIRO') {
            $mes_formatado = '01';
        } elseif ($valor === 'FEVEREIRO') {
            $mes_formatado = '02';
        } elseif ($valor === 'MARÇO') {
            $mes_formatado = '03';
        } elseif ($valor === 'ABRIL') {
            $mes_formatado = '04';
        } elseif ($valor === 'MAIO') {
            $mes_formatado = '05';
        } elseif ($valor === 'JUNHO') {
            $mes_formatado = '06';
        } elseif ($valor === 'JULHO') {
            $mes_formatado = '07';
        } elseif ($valor === 'AGOSTO') {
            $mes_formatado = '08';
        } elseif ($valor === 'SETEMBRO') {
            $mes_formatado = '09';
        } elseif ($valor === 'OUTUBRO') {
            $mes_formatado = '10';
        } elseif ($valor === 'NOVEMBRO') {
            $mes_formatado = '11';
        } elseif ($valor === 'DEZEMBRO') {
            $mes_formatado = '12';
        }

        return $mes_formatado;
    }

}
