<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;

class Barang_model extends CI_Model {

    private $user_id;
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        if ($this->ion_auth->logged_in()) $this->user_id = $this->ion_auth->user()->row()->id;
        else $this->user_id = 0;
    }

    /**
     * Get item stock
     */
    function getItemStock($id)
    {
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->where('barang.id', $id);
        $this->db->order_by('timestamp','asc');
        $item = $this->db->get()->row();

        $this->db->select('sum(qty) as sold');
        $this->db->from('pembelian_barang');
        $this->db->where('pembelian_barang.barang_id', $id);
        $sold = $this->db->get()->row()->sold;

        if (!empty($item)) return $item->stock - $sold;
        else return false;
    }

    /**
     * Get all cart items
     */
    function getCarts()
    {
        $this->db->select('barang_id, qty');
        $this->db->from('cart_barang');
        $this->db->where('cart_barang.user_id', $this->user_id);
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
        $this->db->select('*');
        $this->db->from('cart_barang');
        $this->db->where('cart_barang.user_id', $this->user_id);
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
        $this->db->select('*');
        $this->db->from('cart_barang');
        $this->db->where('cart_barang.user_id', $this->user_id);
        $this->db->where('cart_barang.status', 1);
        $this->db->where('cart_barang.barang_id', $id);
        $this->db->order_by('timestamp','asc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    /**
     * Get total payment
     */
    function getTotal()
    {
        $sum = 0;
        $weight = 0;
        $cart = $this->getCarts();
        foreach ($cart as $key => $value)
        {
            $item = $this->getBarangDetails($value->barang_id);
            $sum += $value->qty * $item->price;
            $weight += $value->qty * $item->weight;
        }

        return $sum + ceil($weight/1000) * 20000;
    }

    /**
     * Get total weight
     */
    function getWeight()
    {
        $weight = 0;
        $cart = $this->getCarts();
        foreach ($cart as $key => $value)
        {
            $item = $this->getBarangDetails($value->barang_id);
            $weight += $value->qty * $item->weight;
        }

        return $weight;
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
        foreach ($query as $k => $v)
        {
            $query[$k]->stock = $this->getItemStock($v->id);
        }

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
        $query->stock = $this->getItemStock($id);

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
     * Get latest checkout
     * 
     * @param int   $id ID Pembayaran
     */
    function getLatestCheckout()
    {
        $this->db->select('*');
        $this->db->from('pembelian');
        $this->db->where('user_id', $this->user_id);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    /**
     * Get latest checkout
     * 
     * @param int   $id ID Pembayaran
     */
    function getCheckoutByRef($ref)
    {
        $this->db->select('*');
        $this->db->from('pembelian');
        $this->db->where('user_id', $this->user_id);
        $this->db->where('kode_bayar', $ref);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
    }

    /**
     * Get latest checkout
     * 
     * @param int   $id ID Pembayaran
     */
    function getCheckoutStatusByRef($ref)
    {
        $this->db->select('*');
        $this->db->from('pembelian');
        $this->db->where('user_id', $this->user_id);
        $this->db->where('kode_bayar', $ref);
        $this->db->order_by('timestamp','desc');
        $query = $this->db->get()->row();
        if (!empty($query))
        {
            $this->db->select('*');
            $this->db->from('pembelian_barang');
            $this->db->where('pembelian_ref', $query->kode_bayar);
            $barang = $this->db->get()->result();
            $query->barang = $barang;
            return $query;
        }        
        else return false;
    }

    /**
     * Get latest checkout
     * 
     * @param int   $id ID Pembayaran
     */
    function getPembelian($id)
    {
        $this->db->select('*');
        $this->db->from('pembelian');
        $this->db->where('user_id', $this->user_id);
        $this->db->where('id', $id);
        $this->db->order_by('timestamp','desc');

        $query = $this->db->get()->row();
        if (!empty($query)) return $query;
        else return false;
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
            $this->user_id = $this->ion_auth->user()->row()->id; 
            $cart = $this->getCartByItem($id);

            if ($cart->qty >= $this->getItemStock($id))
            {
                return false;
            }


            if ($cart)
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
                    'user_id' => $this->user_id,
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
            $this->user_id = $this->ion_auth->user()->row()->id; 

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
            $this->user_id = $this->ion_auth->user()->row()->id; 

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

    /**
     * Proceed to the payment. Every checkout is considered to be paid
     * 
     * @param int   $id ID Barang
     */
    function proceed($address)
    {
        // Generate payment code
        $code = (int) date('Ymdhis').rand(100,999);

        $data = array(
            'kode_bayar' => $code,
            'user_id' => $this->user_id,
            'penerima' => $address['nama'],
            'alamat' => $address['alamat'],
            'kode_pos' => $address['kode_pos'],
            'nomor_telepon' => $address['nomor_telepon'],
            'total' => $this->getTotal(),
            'weight' => $this->getWeight()
        );

        $result = $this->db->insert('pembelian',$data);
        return $result ? $code : false;
    }

    /**
     * Dummy payment method.
     * 
     * @param int   $id ID Pembayaran
     */
    function pay($id)
    {
        $data = array(
            'status' => 1
        );

        $result = $this->db->update('pembelian',$data,array('kode_bayar' => $id));
        
        $carts = $this->getCarts();
        $status = true;
        foreach ($carts as $cart)
        {
            $this->removeFromCart($cart->barang_id);
            $data = array(
                'pembelian_ref' => $id,
                'barang_id' => $cart->barang_id,
                'qty' => $cart->qty
            );
            $dump = $this->db->insert('pembelian_barang',$data);
            $status = $status & $dump;
        }

        return $result & $status;
    }

    /**
     * Send Shipping Data.
     * 
     * @param int   $id ID Pembayaran
     */
    function send($id)
    {
        if ($pembelian = $this->getCheckoutByRef($id))
        {
            $data = array(
                'pengirim'          => 'WarungDaring',
                'alamat_pengirim'   => 'Jalan Menuju Kebahagiaan no 1 Bantul, DI Yogyakarta 559994 085848820866',
                'penerima'          => $pembelian->penerima,
                'alamat_penerima'   => $pembelian->alamat.' '.$pembelian->kode_pos.' '.$pembelian->nomor_telepon,
                'berat_total'       => $pembelian->weight
            );

            $_client = new Client();
    
            $response = $_client->post(
                'http://localhost/ekspedisiWebService/pengiriman/api/send',
                array(
                    'form_params'   => array(
                        'identifier'    => 'warungdaring',
                        'key'           => '05075520204622787',
                        'data'          => json_encode($data)
                    )
                )
            );
            $insert['resi'] =  json_decode($response->getBody()->getContents(), true);;
            $this->db->update('pembelian',$insert,array('kode_bayar' => $id));
            return $insert['resi'];
        }
        return false;
    }

    function getPengiriman($id)
    {
        if ($pembelian = $this->getCheckoutByRef($id))
        {
            $_client = new Client();
    
            $response =  $_client->request('GET', 'http://localhost/ekspedisiWebService/pengiriman/api/', [
                'query' => [
                    'resi' => $pembelian->resi
                ]
            ]);
            $result =  json_decode($response->getBody()->getContents(), true);;
            return $result;
        }
        return false;
    }
}