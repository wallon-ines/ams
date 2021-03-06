<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {



   public function __construct() {
      parent::__construct();
      $this->load->library('cas');
      $this->cas->force_auth();
      $this->Users->create();
      $this->load->library('form_validation');  
      $this->load->helper(array('form', 'url'));
   }

   
    public function result() {
        $this->load->model('search_model');
        $search_term= $this->input->get('s');
        $data['titre']='Résultat de la recherche pour "'.$search_term.'"';
        $data['search_term']=$search_term;
        // Use a model to retrieve the results.
        $data['results'] = $this->search_model->get_results($search_term);
        $data['title'] = "Résultat de la recherche";
        $data['user'] = $this->cas->user()->userlogin;
        $this->load->view('themes/header', $data);
	$this->load->view('search/result', $data);

	$this->load->view('themes/footer');
    }
    
    public function advanced() {
        $this->load->model('search_model');
        $data['title'] = "Recherche multicritère";
        $data['user'] = $this->cas->user()->userlogin;
        $this->load->view('themes/header', $data);
        
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert"> <a href="#" class="close" data-dismiss="alert">&times;</a>', '</div>');
	    $this->form_validation->set_rules('nom', 'Nom', 'trim');
	    $this->form_validation->set_rules('distrib', 'Distribution', 'trim');
	    $this->form_validation->set_rules('ip', 'IP', 'trim|valid_ip');
	    $this->form_validation->set_rules('referent', 'Referent', 'trim');
        
        
        if ($this->input->get('submit') == FALSE) {
            $this->load->view('search/form', $data);
        }
        else {
            $data['title'] = "Résultat de la recherche";
            $data['titre']='Résultat de la recherche multicritère';
            // Use a model to retrieve the results.
            $data['results'] = $this->search_model->avanced($this->input->get('nom'),$this->input->get('distrib'),$this->input->get('ip'),$this->input->get('referent'));
             $data['search_term']="";
            $this->load->view('search/result', $data);
        }
	//$this->load->view('search/result', $data);
	$this->load->view('themes/footer');
    }     
   
}