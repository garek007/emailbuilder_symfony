<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function overviewAction(Request $request)
    {
      $products = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Product')->findAll();
      return $this->render('product/overview.html', ['products' => $products]);
    }
  
    public function addAction(Request $request)
    {
      $product = new Product($request->get('name'),str_replace('.','',$request->get('price')));
      $product->setSku($request->get('sku'));
      
      $em = $this->getDoctrine()->getEntityManager();
      $em->persist($product);
      $em->flush($product);
      
      return $this->redirectToRoute('product_overview');
                             
      
                           
    }
    public function importAction(Request $request)
    {

	

        //get company from database
        //some mysql query, fill in later
        //check who is logged in and pull from their table
      //$company = "company_1";
      
       $company = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Product')->findAll();
      return $this->render('product/overview.html', ['company' => $company]);
      
      
        /*
        PASS COMPANY TO TWIG FILE AND RUN THIS LOOP THERE
        $jsonfile = file_get_contents('company/'.$company.'/_templates.json');
        $company_details = json_decode($jsonfile, true);

        $templateNames = array_keys($company_details['templates']);
       


      foreach($templateNames as $module){
        $folder = 'company/'.$company_details['company']."/";
        switch($module){
          case "events-build":
          case "freeform":$popup = "popup";$link=$folder.'index.php';break;
          default:$link=$folder.$module.'.php';$popup="";break;
        }


        echo '<a href="'.$link.'" id="'.$module.'" class="'.$popup.' fullhtml" data-module="'.$module.'" data-company="'.$company_details['company'].'"> 
        <img src="company/'.$company_details['company']."/templates/".$module.'.icn.gif" /></a>';

      }
 */


      
    }
}
