<?php

class Pmm_reports extends CI_Model {
	private $db2;
    private $db3;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('crud_global');
        $this->load->model('pmm/pmm_model');
		$this->db2 = $this->load->database('database2', TRUE);
		$this->db3 = $this->load->database('database3', TRUE);
    }

}
