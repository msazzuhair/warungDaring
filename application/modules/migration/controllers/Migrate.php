<?php

class Migrate extends MX_Controller
{

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