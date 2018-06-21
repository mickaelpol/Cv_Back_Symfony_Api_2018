<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Content;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ImageController extends Controller
{



    // /**
    //  * Creates a new content entity.
    //  *
    //  * @Route("/new", name="content_new")
    //  * @Method({"POST"})
    //  */
    public function testAction(Request $request)
    {
        
        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);
        return $this->render('content/image.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
}