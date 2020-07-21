<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_cart extends MX_Controller {
	public $data = [];

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
        $this->load->model('barang_model');

		// Set user data
		if ($this->ion_auth->logged_in())
		{
			$user = $this->ion_auth->user()->row();
			$this->data['username']		= htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');
			$this->data['full_name']	= htmlspecialchars($user->first_name.(!empty($user->last_name) ? ' '.$user->last_name : ''),ENT_QUOTES,'UTF-8');
			$this->data['cart_count']	= count($this->barang_model->getCarts());
		}
		else
		{
			redirect('auth/login', 'refresh');
		}
	}

	public function index()
	{
		$cart = $this->barang_model->getCarts();
		foreach ($cart as $key => $value)
		{
			$item = $this->barang_model->getBarangDetails($value->barang_id);
			$item->description = explode("\n",$item->description);
			$cart[$key] = (object) array_merge((array) $value, (array) $item);
		}
		$this->data['items'] = $cart;
		$this->load->view('cart',$this->data);
	}

	public function details()
	{
		// Get product ID
		$id = (int) $this->input->get('id', true);

		// Check if product exists
		if(!$data = $this->barang_model->getBarangDetails($id))
		{
			show_404();
		}
		else
		{
			$data->description = explode("\n",$data->description);
			$this->data['item'] = $data;
			$this->load->view('details',$this->data);
		}
	}

	public function add_to_cart()
	{
		$id = (int) $this->input->get('id', true);

		if(!$data = $this->barang_model->addToCart($id))
		{
			echo '<script>alert("Gagal menambahkan ke keranjang")</script>';
			redirect(site_url('my_cart'));
		}
		else
		{
			redirect(site_url('my_cart'));
		}
	}

	public function remove_from_cart()
	{
		$id = (int) $this->input->get('id', true);

		if(!$data = $this->barang_model->removeFromCart($id))
		{
			echo '<script>alert("Gagal menambahkan ke keranjang")</script>';
			redirect(site_url('my_cart'));
		}
		else
		{
			redirect(site_url('my_cart'));
		}
	}

	public function reduce_qty()
	{
		$id = (int) $this->input->get('id', true);

		if(!$data = $this->barang_model->reduceQty($id))
		{
			echo '<script>alert("Gagal mengurangi Qty di keranjang")</script>';
			redirect(site_url('my_cart'));
		}
		else
		{
			redirect(site_url('my_cart'));
		}
	}

	
}
