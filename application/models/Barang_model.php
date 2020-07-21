<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all cart items
     */
    function getCarts()
    {
        $user_id = $this->ion_auth->user()->row()->id;
        $this->db->select('barang_id, qty');
        $this->db->from('cart_barang');
        $this->db->where('cart_barang.user_id', $user_id);
        $this->db->where('cart_barang.status', 1);
        $this->db->order_by('timestamp','asc');

        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * Get single cart item
     * 
     * @param int   $id Cart ID
     */
    function getCart($id)
    {
        $user_id = $this->ion_auth->user()->row()->id;
        $this->db->select('*');
        $this->db->from('cart_barang');
        $this->db->where('cart_barang.user_id', $user_id);
        $this->db->where('cart_barang.status', 1);
        $this->db->where('cart_barang.id', $id);
        $this->db->order_by('timestamp','asc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    /**
     * Get single cart item by item ID
     * 
     * @param int   $id Item ID
     */
    function getCartByItem($id)
    {
        $user_id = $this->ion_auth->user()->row()->id;
        $this->db->select('*');
        $this->db->from('cart_barang');
        $this->db->where('cart_barang.user_id', $user_id);
        $this->db->where('cart_barang.status', 1);
        $this->db->where('cart_barang.barang_id', $id);
        $this->db->order_by('timestamp','asc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    /**
     * Mengambil data barang dari database, dengan limit dan page
     * @param int   $limit Limit number of data in a page
     * @param int   $limit Offset number of data in a page
     * @return array|bool Satu baris detail barang
     */
    function getBarang($limit, $page)
    {
        $offset = ($page - 1) * $limit;
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->order_by('timestamp','desc');
        $this->db->limit($limit, $offset);

        $query = $this->db->get()->result();
        return $query;
    }

    /**
     * Mengambil detail info barang dari database
     * @param int   $id ID barang
     * @return array|bool Satu baris detail barang
     */
    function getBarangDetails($id)
    {
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->where('barang.id', $id);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    function getPages($limit)
    {
        $this->db->select('*');
        $this->db->from('barang');

        $query = $this->db->get()->result();
        $maxPage = ceil((double) count($query) / $limit);
        return $maxPage;
    }

    /**
     * Menambahkan barang ke keranjang
     * 
     * @param int   $id ID Barang
     */
    function addToCart($id)
    {
        if(!$this->getBarangDetails($id))
        {
            return false;
        }
        else
        {
            $user_id = $this->ion_auth->user()->row()->id; 

            if ($cart = $this->getCartByItem($id))
            {
                $data = array(
                    'qty' => $cart->qty + 1
                );
                $result = $this->db->update('cart_barang',$data,array('barang_id' => $id));
            }
            else
            {
                // Insert data
                $data = array(
                    'user_id' => $user_id,
                    'barang_id'=> $id
                );
                $result = $this->db->insert('cart_barang',$data);
            }

            return $result;
        }
    }

    /**
     * Menghapus barang dari keranjang
     * 
     * @param int   $id ID Barang
     */
    function removeFromCart($id)
    {
        if(!$this->getBarangDetails($id))
        {
            return false;
        }
        else
        {
            $user_id = $this->ion_auth->user()->row()->id; 

            if ($cart = $this->getCartByItem($id))
            {
                $data = array(
                    'qty' => 0,
                    'status' => 0
                );
                $result = $this->db->update('cart_barang',$data,array('barang_id' => $id));
            }
            else $result = false;

            return $result;
        }
    }

    /**
     * Mengurangi qty barang dari keranjang
     * 
     * @param int   $id ID Barang
     */
    function reduceQty($id)
    {
        if(!$this->getBarangDetails($id))
        {
            return false;
        }
        else
        {
            $user_id = $this->ion_auth->user()->row()->id; 

            if ($cart = $this->getCartByItem($id))
            {
                if ($cart->qty > 1)
                {
                    $data = array(
                        'qty' => $cart->qty - 1
                    );
                    $result = $this->db->update('cart_barang',$data,array('barang_id' => $id));
                }
                else
                {
                    $data = array(
                        'qty' => 0, 
                        'status' => 0
                    );
                    $result = $this->db->update('cart_barang',$data,array('barang_id' => $id));
                }
            }
            else $result = false;

            return $result;
        }
    }
}