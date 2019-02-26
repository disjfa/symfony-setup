<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AgreeableKangarooController extends AbstractController
{
    /**
     * @Route("/agreeable/kangaroo", name="agreeable_kangaroo")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AgreeableKangarooController.php',
        ]);
    }
}
