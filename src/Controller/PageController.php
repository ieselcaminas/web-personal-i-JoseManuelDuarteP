<?php

namespace App\Controller;

use App\Entity\Aeronave;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Propietario;
use App\Form\PropietarioFormType;
use App\Form\AeronaveFormType;

final class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $aeronaves = $doctrine->getRepository(Aeronave::class)->findAll();

        return $this->render('home.html.twig', [
            'aeronaves' => $aeronaves
        ]);
    }

    #[Route('/registrar_propietario', name: 'registrar_propietario')]
    public function registrarPropietario(ManagerRegistry $doctrine, Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $aeronave = new Propietario();
        $form = $this->createForm(PropietarioFormType::class, $aeronave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aeronave = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($aeronave);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('registrar_propietario.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/registrar_aeronave', name: 'registrar_aeronave')]
    public function registrarAeronave(ManagerRegistry $doctrine, Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $aeronave = new Aeronave();
        $form = $this->createForm(AeronaveFormType::class, $aeronave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagen = $form->get('imagen')->getData();

            if ($imagen) {
                $nombreArchivo = uniqid().'.'.$imagen->guessExtension();
                $imagen->move($this->getParameter('aeronaves_directory'), $nombreArchivo);
                $aeronave->setImagen($nombreArchivo);
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($aeronave);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('registrar_aeronave.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/aeronave/{id?1}', name: 'ver_aeronave')]
    public function verAeronave(ManagerRegistry $doctrine, int $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $aeronave = $doctrine->getRepository(Aeronave::class)->find($id);

        if (!$aeronave) {
            throw $this->createNotFoundException(
                'Ninguna aeronave encontrada con id: ' . $id
            );
        }

        $fechaFormateada = $aeronave->getFechaFormateada();

        return $this->render('ficha_aeronave.html.twig', [
            'aeronave' => $aeronave,
            'fechaFormateada' => $fechaFormateada
        ]);
    }

    #[Route('/aeronave/{id?1}/editar', name: 'editar_aeronave')]
    public function editarAeronave(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $aeronave = $doctrine->getRepository(Aeronave::class)->find($id);
        
        if ($aeronave) {
            $form = $this->createForm(AeronaveFormType::class, $aeronave);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {

                if ($form->get('cancelar')->isClicked()) {
                    return $this->redirectToRoute('home');
                }

                if($form->isValid()) {
                    $imagen = $form->get('imagen')->getData();

                if ($imagen) {
                    
                    if ($aeronave->getImagen()) {
                        $rutaImagenExistente = $this->getParameter('aeronaves_directory').'/'.$aeronave->getImagen();
                        if (file_exists($rutaImagenExistente)) {
                            unlink($rutaImagenExistente);
                        }
                    }

                    $nombreArchivo = uniqid().'.'.$imagen->guessExtension();
                    $imagen->move($this->getParameter('aeronaves_directory'), $nombreArchivo);
                    $aeronave->setImagen($nombreArchivo);
                }

                $entityManager = $doctrine->getManager();
                $entityManager->persist($aeronave);
                $entityManager->flush();
                return $this->redirectToRoute('ver_aeronave', ['id' => $aeronave->getId()]);
                }
                
            }
            return $this->render('registrar_aeronave.html.twig', [
                'form' => $form->createView()
            ]);
        } else {
            throw $this->createNotFoundException(
                'Ninguna aeronave encontrada con id: ' . $id
            );
        }
    }

    #[Route('/aeronave/{id?1}/eliminar', name: 'eliminar_aeronave')]
    public function eliminarAeronave(ManagerRegistry $doctrine, int $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $aeronave = $doctrine->getRepository(Aeronave::class)->find($id);
        if ($aeronave) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($aeronave);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        } else {
            throw $this->createNotFoundException(
                'Ninguna aeronave encontrada con id: ' . $id
            );
        }
    }
}
