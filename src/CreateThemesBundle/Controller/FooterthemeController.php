<?php

namespace CreateThemesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CreateThemesBundle\Entity\Footertheme;
use CreateThemesBundle\Form\FooterthemeType;

/**
 * Footertheme controller.
 *
 * @Route("/footertheme")
 */
class FooterthemeController extends Controller
{
    /**
     * Lists all Footertheme entities.
     *
     * @Route("/", name="footertheme_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $footerthemes = $em->getRepository('CreateThemesBundle:Footertheme')->findAll();

        return $this->render('footertheme/index.html.twig', array(
            'footerthemes' => $footerthemes,
        ));
    }

    /**
     * Creates a new Footertheme entity.
     *
     * @Route("/new", name="footertheme_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $footertheme = new Footertheme();
        $form = $this->createForm('CreateThemesBundle\Form\FooterthemeType', $footertheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($footertheme);
            $em->flush();

            return $this->redirectToRoute('footertheme_show', array('id' => $footertheme->getId()));
        }

        return $this->render('footertheme/new.html.twig', array(
            'footertheme' => $footertheme,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Footertheme entity.
     *
     * @Route("/{id}", name="footertheme_show")
     * @Method("GET")
     */
    public function showAction(Footertheme $footertheme)
    {
        $deleteForm = $this->createDeleteForm($footertheme);

        return $this->render('footertheme/show.html.twig', array(
            'footertheme' => $footertheme,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Footertheme entity.
     *
     * @Route("/{id}/edit", name="footertheme_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Footertheme $footertheme)
    {
        $deleteForm = $this->createDeleteForm($footertheme);
        $editForm = $this->createForm('CreateThemesBundle\Form\FooterthemeType', $footertheme);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($footertheme);
            $em->flush();

            return $this->redirectToRoute('footertheme_edit', array('id' => $footertheme->getId()));
        }

        return $this->render('footertheme/edit.html.twig', array(
            'footertheme' => $footertheme,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Footertheme entity.
     *
     * @Route("/{id}", name="footertheme_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Footertheme $footertheme)
    {
        $form = $this->createDeleteForm($footertheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($footertheme);
            $em->flush();
        }

        return $this->redirectToRoute('footertheme_index');
    }

    /**
     * Creates a form to delete a Footertheme entity.
     *
     * @param Footertheme $footertheme The Footertheme entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Footertheme $footertheme)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('footertheme_delete', array('id' => $footertheme->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
