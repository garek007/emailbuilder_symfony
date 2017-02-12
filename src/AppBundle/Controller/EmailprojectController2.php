<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Emailproject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmailprojectController extends Controller
{
    public function getAction(Request $request)
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
    public function copyAction()
    {
      
    }
}
