<?php


namespace AppBundle\Controller\ApiController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * @Prefix("api-")
 * @NamePrefix("api-")
 */
class ApiController extends Controller 
{

    /**
     * Return the information of user profile
     *@Rest\View(serializerGroups={"profile"})
     * @Rest\Get("profile")
     * 
     */
    public function getProfileAction(Request $request)
    {
        $profile = ["profile" => []];

        $data = $this->getDoctrine()->getRepository("AppBundle:User")->findAll();
        $host = $this->generateUrl('homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL) . "uploads/images/profile/";


        foreach ($data as $key => $value) {

            $photo = $value->getPhoto();
            $lienComplet = $photo ? $photo = $host . $photo : $photo = "Aucune image n'a été ajouter";


            $content = [
                'id' => $value->getId(),
                'lastName' => $value->getLastName(),
                'prenom' => $value->getUsername(),
                'adress' => $value->getAdress(),
                'photo' => $lienComplet,
                'city' => $value->getCity(),
                'country' => $value->getCountry(),
                'phone' => $value->getPhoneSeparate(),
                'age' => $value->getAge()->format("d-m-Y"),
                'permis' => $value->getPermis(),
                'vehicule' => $value->getVehicule(),
                'job' => $value->getJob(),
                'facebook' => $value->getUserFacebook(),
                'linkedin' => $value->getUserLinkedin(),
                'instagram' => $value->getUserInstagram(),
                'twitter' => $value->getUserTwitter(),
                'pinterest' => $value->getUserPinterest(),
                'youtube' => $value->getUserYoutube(),

            ];
            array_push($profile["profile"], $content);
        }
        return $profile;
    }


    /**
     * Liste des Categorie sous forme d'api
     * @Rest\View(serializerGroups={"categorie"})
     * @Rest\Get("categories")
     */
    public function getCategoriesAction(Request $request)
    {


        $categorie = ["categorie" => []];

        $data = $this->getDoctrine()->getRepository("AppBundle:Categorie")->findAll();

        foreach ($data as $key => $value) {

            $id = $value->getId();
            $title = $value->getTitle();

            $contenu = [];
            $host = $this->generateUrl('homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL) . "uploads/images/content/";

            foreach ($value->getContents() as $key => $tab) {

                $image = $tab->getBrochure();
                $lienComplet = $image ? $image = $host . $image : $image = "Aucune image n'a été ajouter";
                
                $contenues = [
                    "id" => $tab->getId(),
                    "title" => $tab->getTitle(),
                    "description" => $tab->getText(),
                    "note" => $tab->getNote(),
                    "dateStart" => $tab->getDateStart(),
                    "dateEnd" => $tab->getDateEnd(),
                    "categorie" => $tab->getCategorie()->getTitle(),
                    "createdAt" => $tab->getCreatedAt(),
                    "image" =>  $lienComplet

                ];
                array_push($contenu, $contenues);
            }

            $categories = [
                'id' => $id,
                'title' => $title,
                'contenu' => $contenu
            ];
            array_push($categorie['categorie'], $categories);

            
        }
        
        return $categorie;
    }
    
}