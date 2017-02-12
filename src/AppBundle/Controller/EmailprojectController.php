<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emailproject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

//use Symfony\Component\Finder\Finder;


/**
 * Emailproject controller.
 *
 */
class EmailprojectController extends Controller
{
    /**
     * Lists all emailproject entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $loggedInUser = $this->getUser();
        $username = $loggedInUser->getUsername();
        
        //$emailprojects = $em->getRepository('AppBundle:Emailproject')->findAll();
        $emailprojects = $em->getRepository('AppBundle:Emailproject')->loadUserProjects($username);

        return $this->render('emailproject/index.html.twig', array(
            'emailprojects' => $emailprojects,
        ));
    }

    /**
     * Creates a new emailproject entity.
     *
     */
    public function newAction(Request $request)
    {
        $d = new \DateTime();
        $emailproject = new Emailproject($request->get('body'),$request->get('title'), $d);
        $loggedInUser = $this->getUser();
      
 
        $emailproject
          ->setUsername($loggedInUser->getUsername())
          ->setEmail($loggedInUser->getEmail())
          ->setCompany($loggedInUser->getCompany());

        $form = $this->createForm('AppBundle\Form\EmailprojectType', $emailproject);
        $form->handleRequest($request);
      
      

       if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emailproject);
            $em->flush($emailproject);

            return $this->redirectToRoute('emailproject_show', array('id' => $emailproject->getId()));
        }
       
        return $this->render('emailproject/new.html.twig', array(
            'emailproject' => $emailproject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a emailproject entity.
     *
     */
    public function showAction(Emailproject $emailproject)
    {
        $deleteForm = $this->createDeleteForm($emailproject);

        return $this->render('emailproject/show.html.twig', array(
            'emailproject' => $emailproject,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing emailproject entity.
     *
     */
    public function editAction(Request $request, Emailproject $emailproject)
    {
        $deleteForm = $this->createDeleteForm($emailproject);
        $editForm = $this->createForm('AppBundle\Form\EmailprojectType', $emailproject);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('emailproject_index', array('id' => $emailproject->getId()));
        }

        return $this->render('emailproject/edit.html.twig', array(
            'emailproject' => $emailproject,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function buildAction(Request $request, Emailproject $emailproject)
    {
        $company = $emailproject->getCompany();

        $json_file = file_get_contents($this->get('kernel')->getRootDir().'/Resources/views/company/sdta/_templates.json');
        $modules = json_decode($json_file,true);
        $moduleNames = array_keys($modules['templates']);

        
        return $this->render('emailproject/build.html', array(
            'emailproject' => $emailproject,
            'moduleNames' => $moduleNames,
        ));
    }  
    public function ajaxAction(Request $request)
    {
      $loggedInUser = $this->getUser();
      $company = $loggedInUser->getCompany();

      $options = $request->request->get('options');
      
      switch($options['flag']){
        case "sdta-custom-insertSignature":
          $name=$options['name'];

          if($options['oddEven']=="true"){			
            echo $twig->render($company.'/templates/signatures.'.$name.'.html');
          }else{
            echo $twig->render($company.'/templates/signatures.row.html', array('name' => $name));
          }
          break;

        case "dropModule":
          $module = $options['module'];
          //an idea, I'll delete when I'm good and ready
          //$controls = json_decode(file_get_contents('company/'.$company.'/_controls.json'), true);
          //echo $controls['controls']['toggle_sponsored'][0];

          return $this->render('company/'.$company.'/templates/'.$module.'.lyt.php', 
          array('module' => $module)         
          ); 
          break;
        case "saveProject":
          $html = $options['html'];
          $projectID = $options['projectNum'];
          $em = $this->getDoctrine()->getEntityManager();


          $repo = $this->getDoctrine()->getRepository('AppBundle:Emailproject');
          $emailproject = $em->getRepository('AppBundle:Emailproject')->find($projectID);
          $emailproject->setBody($html);

          $em->flush($emailproject);


          return new Response();


          break;
        default:break;	

        case "syncToExacttarget":
        $html = $options['html'];
        $etID = $options['etID'];
        break;				
        default:break;	
      }      
      
      
     

    }

    /**
     * Deletes a emailproject entity.
     *
     */
    public function deleteAction(Request $request, Emailproject $emailproject)
    {
        $form = $this->createDeleteForm($emailproject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($emailproject);
            $em->flush($emailproject);
        }

        return $this->redirectToRoute('emailproject_index');
    }
  
    public function deleteMultipleAction(Request $request)
    {  
      $inputs = $request->get('delete');
      //var_dump($inputs);
      $em = $this->getDoctrine()->getManager();
      //$repo = $this->getDoctrine()->getRepository('AppBundle:Emailproject');
      foreach($inputs as $projectID){
        $emailproject = $em->getRepository('AppBundle:Emailproject')->find($projectID);
        $em->remove($emailproject);
        $em->flush($emailproject);        
        
        
        
        
      }
      
                      
        //$emailprojects = $em->getRepository('AppBundle:Emailproject')->findAll();
           //$emailproject = $em->find('AppBundle:Emailproject',1);
           //$emailproject = $this->getDoctrine()->getRepository('AppBundle:Emailproject')->find($projectID);
           
           
           
       
      
      
      
        //if ($form->isSubmitted() && $form->isValid()) {
           // $em = $this->getDoctrine()->getManager();
            //$em->remove($emailproject);
            //$em->flush($emailproject);
       // }

        return $this->redirectToRoute('emailproject_index');      
      
      
      
 // $deleteprojects = $_POST['delete'];
	//foreach($deleteprojects as $projid){
		//echo $projid;
		//$query = "DELETE FROM projects WHERE Project_Number='$projid'";
		//$results = mysqli_query($con,$query);	
  }
    
  

    /**
     * Creates a form to delete a emailproject entity.
     *
     * @param Emailproject $emailproject The emailproject entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Emailproject $emailproject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emailproject_delete', array('id' => $emailproject->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
