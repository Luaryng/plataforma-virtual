<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mempresas extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_empresasxnombre($data)
    {
        $result = $this->db->query("SELECT 
          tb_empresas.emp_id as codigo,
          tb_empresas.emp_razon_social as nombre,
          tb_empresas.emp_ruc as ruc,
          tb_empresas.emp_direccion as direccion,
          tb_empresas.emp_telefono as telefono,
          tb_empresas.cod_distrito as iddistrito,
          tb_distrito.dis_nombre as distrito,
          tb_empresas.emp_contacto_apellidos as capellidos,
          tb_empresas.emp_contacto_nombres as cnombres,
          tb_empresas.emp_contacto_celular as ctelefono
        FROM
          tb_empresas
          INNER JOIN tb_distrito ON (tb_empresas.cod_distrito = tb_distrito.dis_codigo)
          WHERE CONCAT(tb_empresas.emp_ruc,' ',tb_empresas.emp_razon_social) LIKE ?
        ORDER BY  tb_empresas.emp_razon_social ASC ", $data);
        return $result->result();
    }

    public function mInsert_empresa($items)
    {
        $this->db->query("CALL `sp_tb_empresas_insert`(?,?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return $res->row();    
    }

    public function mUpdate_empresa($items)
    {
        $this->db->query("CALL `sp_tb_empresas_update`(?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida, @nid as newcod');
        
        return   $res->row();    
    }

    public function m_filtrar_empresaxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_empresas.emp_id as codigo,
          tb_empresas.emp_razon_social as nombre,
          tb_empresas.emp_ruc as ruc,
          tb_empresas.emp_direccion as direccion,
          tb_empresas.emp_telefono as telefono,
          tb_empresas.cod_distrito as iddistrito,
          tb_empresas.emp_contacto_apellidos as capellidos,
          tb_empresas.emp_contacto_nombres as cnombres,
          tb_empresas.emp_contacto_celular as ctelefono,
          tb_distrito.cod_provincia AS idprovincia,
          tb_provincia.cod_departamento AS iddepartamento
        FROM
          tb_empresas
          INNER JOIN tb_distrito ON (tb_empresas.cod_distrito = tb_distrito.dis_codigo)
          INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
          WHERE tb_empresas.emp_id = ? LIMIT 1", $codigo);

        return $result->row();
    }

    public function m_eliminaempresa($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_empresas where emp_id = ? ", $codigo);
        
        return 1;
    }


}

