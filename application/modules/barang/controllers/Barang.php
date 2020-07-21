<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends MX_Controller {
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
	}

	public function index()
	{
		// Get page parameter
		$page = (int) $this->input->get('page', true);

		// Get page and total page
		$this->data['page']  = $page;
		$this->data['pages'] = $this->barang_model->getPages(9);

		// Show 404 if page exceeding number of max page
		if($page > $this->data['pages']) show_404();

		// Check if there is no page parameter defined
		if (empty($page) or $page < 1) $page = 1;

		// Get barang list from db by page number
		$this->data['items'] = $this->barang_model->getBarang(9,$page);

		$this->load->view('catalog',$this->data);
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
			redirect(site_url('barang/details?id='.$id));
		}
		else
		{
			redirect(site_url('barang/details?id='.$id));
		}
	}
}
