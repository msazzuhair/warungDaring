<?php

class Migrate extends MX_Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->load->database();
        $this->load->model('barang_model');

		// Set user data
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->in_group('admin'))
        {
            show_404();
        }
	}

    public function index()
    {
        $this->load->library('migration');

        if ($this->migration->current() === FALSE)
        {
                show_error($this->migration->error_string());
        }
        else echo 'Database migration worked! Database structure is up to date.';
    }

}