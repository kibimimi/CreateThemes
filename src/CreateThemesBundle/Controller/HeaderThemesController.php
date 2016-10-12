<?php

namespace CreateThemesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CreateThemesBundle\Entity\HeaderThemes;
use CreateThemesBundle\Form\HeaderThemesType;

/**
 * HeaderThemes controller.
 *
 * @Route("/headerthemes")
 */
class HeaderThemesController extends Controller
{
    /**
     * Lists all HeaderThemes entities.
     *
     * @Route("/", name="headerthemes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $headerThemes = $em->getRepository('CreateThemesBundle:HeaderThemes')->findAll();

        return $this->render('headerthemes/index.html.twig', array(
            'headerThemes' => $headerThemes,
        ));
    }

    /**
     * Creates a new HeaderThemes entity.
     *
     * @Route("/new", name="headerthemes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $headerTheme = new HeaderThemes();
        $form = $this->createForm('CreateThemesBundle\Form\HeaderThemesType', $headerTheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($headerTheme);
            $em->flush();

            return $this->redirectToRoute('headerthemes_show', array('id' => $headerTheme->getId()));
        }

        return $this->render('headerthemes/new.html.twig', array(
            'headerTheme' => $headerTheme,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a HeaderThemes entity.
     *
     * @Route("/{id}", name="headerthemes_show")
     * @Method("GET")
     */
    public function showAction(HeaderThemes $headerTheme)
    {
        $deleteForm = $this->createDeleteForm($headerTheme);

        return $this->render('headerthemes/show.html.twig', array(
            'headerTheme' => $headerTheme,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing HeaderThemes entity.
     *
     * @Route("/{id}/edit", name="headerthemes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, HeaderThemes $headerTheme)
    {
        $deleteForm = $this->createDeleteForm($headerTheme);
        $editForm = $this->createForm('CreateThemesBundle\Form\HeaderThemesType', $headerTheme);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($headerTheme);
            $em->flush();

            return $this->redirectToRoute('headerthemes_edit', array('id' => $headerTheme->getId()));
        }

        return $this->render('headerthemes/edit.html.twig', array(
            'headerTheme' => $headerTheme,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a HeaderThemes entity.
     *
     * @Route("/{id}", name="headerthemes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, HeaderThemes $headerTheme)
    {
        $form = $this->createDeleteForm($headerTheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($headerTheme);
            $em->flush();
        }

        return $this->redirectToRoute('headerthemes_index');
    }

    /**
     * Creates a form to delete a HeaderThemes entity.
     *
     * @param HeaderThemes $headerTheme The HeaderThemes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(HeaderThemes $headerTheme)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('headerthemes_delete', array('id' => $headerTheme->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
