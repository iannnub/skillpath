<?php

class ErrorController extends Controller {
    public function index() {
        $data['title'] = '404 - Not Found';
        
        $this->view('templates/header', $data);
        $this->view('errors/404', $data);
        $this->view('templates/footer');
    }
}