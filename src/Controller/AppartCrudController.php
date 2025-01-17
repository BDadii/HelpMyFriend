<?php

namespace App\Controller;

use App\Entity\Appart;
use App\Form\Appart1Type;
use App\Repository\AppartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/appart/crud')]
class AppartCrudController extends AbstractController
{
    #[Route('/', name: 'app_appart_crud_index', methods: ['GET'])]
    public function index(AppartRepository $appartRepository): Response
    {
        return $this->render('appart_crud/index.html.twig', [
            'apparts' => $appartRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_appart_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AppartRepository $appartRepository): Response
    {
        $appart = new Appart();
        $form = $this->createForm(Appart1Type::class, $appart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appartRepository->add($appart);
            return $this->redirectToRoute('app_appart_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appart_crud/new.html.twig', [
            'appart' => $appart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appart_crud_show', methods: ['GET'])]
    public function show(Appart $appart): Response
    {
        return $this->render('appart_crud/show.html.twig', [
            'appart' => $appart,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_appart_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appart $appart, AppartRepository $appartRepository): Response
    {
        $form = $this->createForm(Appart1Type::class, $appart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appartRepository->add($appart);
            return $this->redirectToRoute('app_appart_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appart_crud/edit.html.twig', [
            'appart' => $appart,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appart_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Appart $appart, AppartRepository $appartRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appart->getId(), $request->request->get('_token'))) {
            $appartRepository->remove($appart);
        }

        return $this->redirectToRoute('app_appart_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
