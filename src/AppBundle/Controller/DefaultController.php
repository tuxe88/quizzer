<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\TextLoader;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        if($request->getMethod()=='POST'){
            try{
                $textLoader = new TextLoader($_FILES["archivo"]);
            }catch (\Exception $e){
                die($e->getMessage());
            }
            die($textLoader->getText());
        }

        return $this->render('default/index.html.twig');
    }
}
