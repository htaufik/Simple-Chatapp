<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class Chat extends CI_Controller {

	public function index()
	{
        $data = array(
            'chat' => $this->db->order_by('id','ASC')->get('chat')->result()
        );
		$this->load->view('chat', $data);
	}

    public function store(){
        $data = array(
            'user' => $this->input->post('user'),
            'message' => $this->input->post('message'),
        );
        $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
        '554aba53b4ec71b7871d',
        '3bb849c9bb0b78965b9a',
        '1420773',
        $options
        );

        if($this->db->insert('chat', $data)){
            $push = $this->db->order_by('id','ASC');
            $push = $this->db->get('chat')->result();

            foreach($push as $key){
                $data_pusher[] = $key;
            }
            $pusher->trigger('my-channel', 'my-event', $data_pusher);
        }
    }
}
