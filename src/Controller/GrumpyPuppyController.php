<?php

namespace App\Controller;

use App\Entity\GrumpyPuppy;
use App\Form\GrumpyPuppyType;
use App\Repository\GrumpyPuppyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/grumpy/puppy")
 */
class GrumpyPuppyController extends AbstractController
{
    /**
     * @Route("/", name="grumpy_puppy_index", methods={"GET"})
     */
    public function index(GrumpyPuppyRepository $grumpyPuppyRepository): Response
    {
        return $this->render('grumpy_puppy/index.html.twig', [
            'grumpy_puppies' => $grumpyPuppyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="grumpy_puppy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $grumpyPuppy = new GrumpyPuppy();
        $form = $this->createForm(GrumpyPuppyType::class, $grumpyPuppy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grumpyPuppy);
            $entityManager->flush();

            return $this->redirectToRoute('grumpy_puppy_index');
        }

        return $this->render('grumpy_puppy/new.html.twig', [
            'grumpy_puppy' => $grumpyPuppy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grumpy_puppy_show", methods={"GET"})
     */
    public function show(GrumpyPuppy $grumpyPuppy): Response
    {
        return $this->render('grumpy_puppy/show.html.twig', [
            'grumpy_puppy' => $grumpyPuppy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="grumpy_puppy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GrumpyPuppy $grumpyPuppy): Response
    {
        $form = $this->createForm(GrumpyPuppyType::class, $grumpyPuppy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('grumpy_puppy_index', [
                'id' => $grumpyPuppy->getId(),
            ]);
        }

        return $this->render('grumpy_puppy/edit.html.twig', [
            'grumpy_puppy' => $grumpyPuppy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grumpy_puppy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GrumpyPuppy $grumpyPuppy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grumpyPuppy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grumpyPuppy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('grumpy_puppy_index');
    }
}
