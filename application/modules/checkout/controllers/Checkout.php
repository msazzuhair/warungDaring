<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MX_Controller {
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
		// Validation Rules
		$config = array(
			array(
				'field' => 'nama',
				'label' => 'nama',
				'rules' => 'required|alpha_numeric_spaces'
			),
			array(
				'field' => 'alamat',
				'label' => 'alamat',
				'rules' => 'required'
			),
			array(
				'field' => 'kode_pos',
				'label' => 'kode pos',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'nomor_telepon',
				'label' => 'nomor telepon',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$cart = $this->barang_model->getCarts();
			foreach ($cart as $key => $value)
			{
				$item = $this->barang_model->getBarangDetails($value->barang_id);
				$item->description = explode("\n",$item->description);
				$cart[$key] = (object) array_merge((array) $value, (array) $item);
			}
			$this->data['items'] = $cart;
			$this->load->view('checkout',$this->data);
		}
		else
		{
				$data = $_POST;
				$payment = $this->barang_model->proceed($data);
				redirect(site_url('checkout/payment?ref='.$payment));
		}
	}

	public function payment()
	{
		// Get payment code
		$ref = (int) $this->input->get('ref', true);
		if ($data = $this->barang_model->getCheckoutByRef($ref))
		{
			$this->data['checkout'] = $data;
			$this->load->view('payment',$this->data);
		}
		else
		{
			show_404();
		}
	}

	public function pay()
	{
		// Get payment code
		$ref = (int) $this->input->get('ref', true);
		if ($data = $this->barang_model->getCheckoutByRef($ref))
		{
			if ($pay = $this->barang_model->pay($ref))
			{
				if ($send = $this->barang_model->send($ref))
				{
					redirect(site_url('checkout/status?ref='.$ref));
				}
			}
			else
			{
				echo '<script>alert("Gagal Bayar")</script>';
				redirect(site_url('checkout/payment?ref='.$ref));
			}
		}
		else
		{
			show_404();
		}
	}

	public function status()
	{
		$ref = (int) $this->input->get('ref', true);
		$pembelian = $this->barang_model->getCheckoutStatusByRef($ref);
		if ($pembelian)
		{
			$pengiriman = $this->barang_model->getPengiriman($ref);
			$this->data['item'] = $pembelian;
			$this->data['pengiriman'] = $pengiriman;
			$this->load->view('status',$this->data);
		}
		else show_404();
	}
}
