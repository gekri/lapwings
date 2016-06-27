<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Entity\Speler;
use AppBundle\Form\SpelerType;

/**
 * Speler controller.
 *
 * @Route("/admin/speler")
 */
class SpelerController extends Controller
{
    /**
     * Lists all Speler entities.
     *
     * @Route("/", name="speler_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $spelers = $em->getRepository('AppBundle:Speler')->findAll();

        return $this->render('speler/index.html.twig', array(
            'spelers' => $spelers,
        ));
    }

    /**
     * Creates a new Speler entity.
     *
     * @Route("/new", name="speler_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $speler = new Speler();
//        $form = $this->createForm('AppBundle\Form\SpelerType', $speler);

        $form = $this->createFormBuilder($speler)
            ->add('voornaam')
            ->add('achternaam')
            ->add('geboortedatum', DateType::class, array(
                'widget' =>'single_text',
                'html5' => false,
            ))
            ->add('aansluitingsdatum', DateType::class, array(
                'widget' =>'single_text',
                'html5' => false,
            ))
            ->add('aansluitingsnummer')
            ->add('eindeAansluiting', DateType::class, array(
                'widget' =>'single_text',
                'html5' => false,
                'required' => false,
            ))
            ->add('file')
            ->getForm();



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($speler);
            $em->flush();

            return $this->redirectToRoute('speler_show', array('id' => $speler->getId()));
        }

        return $this->render('speler/new.html.twig', array(
            'speler' => $speler,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Speler entity.
     *
     * @Route("/{id}", name="speler_show")
     * @Method("GET")
     */
    public function showAction(Speler $speler)
    {
        $deleteForm = $this->createDeleteForm($speler);

        return $this->render('speler/show.html.twig', array(
            'speler' => $speler,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Speler entity.
     *
     * @Route("/{id}/edit", name="speler_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Speler $speler)
    {
        $deleteForm = $this->createDeleteForm($speler);


        //$file = new UploadedFile($speler->getAbsolutePath(), $speler->getPath());
        //$path = $speler->getPath(); echo $path;
        //$speler->setFile($file);



        $editForm = $this->createForm('AppBundle\Form\SpelerType', $speler);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($speler);
            $em->flush();

            return $this->redirectToRoute('speler_show', array('id' => $speler->getId()));
        }

        return $this->render('speler/edit.html.twig', array(
            'speler' => $speler,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Speler entity.
     *
     * @Route("/{id}", name="speler_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Speler $speler)
    {
        $form = $this->createDeleteForm($speler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($speler);
            $em->flush();
        }

        return $this->redirectToRoute('speler_index');
    }

    /**
     * Creates a form to delete a Speler entity.
     *
     * @param Speler $speler The Speler entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Speler $speler)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('speler_delete', array('id' => $speler->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
