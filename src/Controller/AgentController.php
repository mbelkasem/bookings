<?php

namespace App\Controller;

use App\Repository\AgentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/agent')]
class AgentController extends AbstractController
{
    #[Route('/', name: 'app_agent')]
    public function index(AgentRepository $agentRepository): Response
    {
        $agents = $agentRepository->findAll();
        return $this->render('agent/index.html.twig', [
            'agents' => $agents,
        ]);
    }

    #[Route('/{id}', name: 'agent_show', methods: ['GET'])]
    public function show(int $id, AgentRepository $agentRepository): Response
    {
        $agent = $agentRepository->find($id);
        return $this->render('agent/show.html.twig', [
            'agent' => $agent,
        ]);
    }
    
}
