<?php

namespace AppBundle\Controller;

use AnotherBundle\Service\LuckyNumberGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends Controller
{
    protected $luckyNumberGenerator;

    public function __construct(LuckyNumberGenerator $luckyNumberGenerator)
    {
        $this->luckyNumberGenerator = $luckyNumberGenerator;    
    }

    public function showAction(Request $request)
    {
        $data = [
            'number' => $this->luckyNumberGenerator->get()
        ];

        return $this->render('@app_bundle_resources/home/index.html.twig', $data);
    }
}
