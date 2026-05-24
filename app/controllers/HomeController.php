<?php

class HomeController extends Controller {
    public function index() {
        $roadmapModel = $this->model('RoadmapModel');
        
        $data['title'] = 'SkillPath - Temukan Jalur Belajarmu';
        // Kita ambil 3 atau 6 roadmap terbaru untuk dipajang di depan
        $data['featured_roadmaps'] = $roadmapModel->getLatestRoadmaps(3);

        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}