<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Content;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContentType;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Content controller.
 *
 * @Route("content")
 */
class ContentController extends Controller
{

    /**
     * Creates a new content entity.
     *
     * @Route("/new", name="content_new")
     * @Method({"POST", "GET"})
     */
    public function newAction(Request $request)
    {
        
        $product = new Content();
        $form = $this->createForm(ContentType::class, $product);
        $form->handleRequest($request);
        
        
        /**
         * Traitement Ajax
         */
        if($request->isXmlHttpRequest()){
            sleep(2);
            if ($form->isValid()) {
                $data = $form->getData();

                if($product->getBrochure()){

                    // ==== Traitement ici ===== \\
                    /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                    $file = $product->getBrochure();
                    $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                    $file->move(
                        $this->getParameter('image_directory'),
                        $fileName
                    );

                    $product->setBrochure($fileName);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($product);
                    $em->flush();
                    
                    // ==== Fin de traitement ici ===== \\

                    $validation = $this->addFlash(
                        'successing',
                        'Le contenu à bien été ajouté'
                    );
                    echo json_encode([$validation, "valid" => "<span class='fa fa-check'></span> Enregistrement redirection en cours"]);
                    header('Content-Type: application/json');
                    http_response_code(200);
                    die();

                }elseif(!$product->getBrochure()) {

                    // ==== Traitement ici ===== \\
                    $em = $this->getDoctrine()->getMAnager();
                    $em->persist($product);
                    $em->flush();
                    // ==== Fin de traitement ici ===== \\

                    $validation = $this->addFlash(
                        'successing',
                        'Le contenu à bien été ajouté'
                    );
                    echo json_encode([$validation, "valid" => "<span class='fa fa-check'></span> Enregistrement redirection en cours"]);
                    header('Content-Type: application/json');
                    http_response_code(200);
                    die();

                } else {
                    $error = ['error' => 'Une erreur est survenue'];
                    echo json_encode($error);
                    header('Content-Type: application/json');
                    http_response_code(400);
                    die();
                }
            }
        }


        /**
         * Traitement PHP
         */
        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            

            if ($product->getBrochure()) {
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $product->getBrochure();

                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );

                $product->setBrochure($fileName);

                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();
                $this->addFlash(
                    'successing',
                    'Le contenu à bien été ajouté'
                );
            } elseif (!$product->getBrochure()) {
                $em = $this->getDoctrine()->getMAnager();
                $em->persist($product);
                $em->flush();
                $this->addFlash(
                    'successing',
                    'Le contenu à bien été ajouté'
                );
            } else {
                $this->addFlash(
                    'dangering',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('homepage');
            
        }

        return $this->render('content/image.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * Method for delete one of Content
     * @Route("/{id}/remove", name="content_remove")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository("AppBundle:Content")->find($id);
        $image = $content->getBrochure();

        if ($image) {
            // Suppression du fichier dans le dossier du projet
            
            $fs = new Filesystem();
            $host = $this->get('kernel')->getRootDir() . '/../web/uploads/images/content/' . $image;
            
            $em->remove($content);
            $fs->remove($host);
            $em->flush();
            $this->addFlash(
                'successing',
                'Le contenu à bien été supprimé'
            );

        } elseif (!$image) {
            $em->remove($content);
            $em->flush();
            $this->addFlash(
                'successing',
                "Le contenu à bien été supprimé"
            );
        } else {
            $this->addFlash(
                'dangering',
                "Une erreur est survenue"
            );
        }
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/{id}/show", name="content_show")
     * @Method({"GET"})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository("AppBundle:Content")->find($id);

        return $this->render('content/show.html.twig', array(
            'cont' => $content,
        ));
    }

    /**
     * Displays a form to edit an existing content entity.
     *
     * @Route("/{id}/edit", name="content_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Content $content)
    {
        $editForm = $this->createForm('AppBundle\Form\ContentType', $content);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $image = $content->getBrochure();
        $test = $em->getUnitOfWork();
        $originalData = $test->getOriginalEntityData($content);
        $originalImage = $originalData["brochure"];
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            

            if ($content->getBrochure() != null) {
                if ($originalImage) {
                    $fs = new Filesystem();
                    $old_file = $this->get('kernel')->getRootDir() . '/../web/uploads/images/content/'. $originalImage;
                    $fs->remove($old_file);

                    $fileName = $this->generateUniqueFileName() . '.' . $content->getBrochure()->guessExtension();
                    $image->move(
                        $this->getParameter('image_directory'),
                        $fileName
                    );
                    $content->setBrochure($fileName);

                    $em->persist($content);
                    $em->flush();

                } else {
                    // J'enregistre la photo avec son contenu
                    $fileName = $this->generateUniqueFileName() . '.' . $content->getBrochure()->guessExtension();
                    $content->getBrochure()->move(
                        $this->getParameter('image_directory'),
                        $fileName
                    );
                    $content->setBrochure($fileName);
                    $em->persist($content);
                    $em->flush();
                }
            } else {
                $content->setBrochure($originalImage);
                $em->persist($content);
                $em->flush();
            }
            
            $this->addFlash(
                'successing',
                'Le contenu à bien été modifié'
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('content/edit.html.twig', array(
            'content' => $content,
            'edit_form' => $editForm->createView(),
        ));
    }

}