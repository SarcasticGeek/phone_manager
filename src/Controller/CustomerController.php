<?php

namespace App\Controller;

use App\Constant\PaginationConstant;
use App\Service\CountryManagerInterface;
use App\Service\CustomerManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @Route("/customers", name="customers_index")
     */
    public function index(Request $request, CustomerManagerInterface $customerManager, CountryManagerInterface $countryManager)
    {
        return $this->render('Customer/index.html.twig',
        [
            'pagination' => $customerManager->list(
                $request->query->all(),
                $request->query->get('page', PaginationConstant::DEFAULT_PAGE),
                $request->query->get('limit', PaginationConstant::DEFAULT_LIMIT)
            ),
            'countries' => $countryManager->getAll(),
        ]);
    }

}