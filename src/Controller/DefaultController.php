<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return $this->redirect($this->generateUrl('customers_index'));
    }

}