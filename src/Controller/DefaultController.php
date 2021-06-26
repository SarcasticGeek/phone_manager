<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @Route("/", name="main_page")
     */
    public function index(Request $request)
    {
        return $this->redirect($this->generateUrl('customers_index'));
    }

}