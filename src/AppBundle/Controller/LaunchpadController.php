<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emailproject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LaunchpadController extends Controller
{
    public function indexAction(Request $request)
    {
      //$products = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Product')->findAll();

      
      $em = $this->getDoctrine()->getManager();

      $emailprojects = $em->getRepository('AppBundle:Emailproject')->findAll();

      return $this->render('launchpad/index.html', array(
          'emailprojects' => $emailprojects,
      ));
      
      
      
      
      
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
}
