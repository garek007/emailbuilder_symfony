<?php

namespace AppBundle\Controller;

//use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BuildemailController extends Controller
{
  
    //ok here's how this has to work
    //check to see if user is logged in
  //if not, send them back to home page
  //if so see what company they are with
  //and what project they click on in the last page
  //then fetch all fields from that project from the projects table in the DB
  //you're going to need an entity (I think) and definitely new orm.yml in the config folder
  
  //seems I'm going to have to buid the control panel from here too....
    public function checkUser(Request $request)
    {
      
    }
  
  
    public function overviewAction(Request $request)
    {
      //$products = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:Product')->findAll();
      //return $this->render('buildemail.html', ['products' => $products]);
       return $this->render('buildemail.html');
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
