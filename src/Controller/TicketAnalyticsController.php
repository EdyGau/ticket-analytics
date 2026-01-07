<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\Service\TicketAnalyticsImportService;
use App\Exception\InvalidAnalyticsDataException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Handles user requests for financial analytics dashboard and data stream processing.
 */
final class TicketAnalyticsController extends AbstractController
{
    #[Route('/analytics', name: 'app_analytics', methods: ['GET', 'POST'])]
    public function index(Request $request, TicketAnalyticsImportService $import): Response
    {
        $session = $request->getSession();

        if ($request->isMethod('POST')) {
            $file = $request->files->get('excel_file');
            if ($file) {
                try {
                    $data = $import->importToCollection($file);
                    $session->set('analytics_data', $data);

                    if ($request->isXmlHttpRequest()) {
                        return $this->render('analytics/partials/_results.html.twig', ['data' => $data]);
                    }
                } catch (InvalidAnalyticsDataException $e) {
                    $this->addFlash('error', $e->getMessage());

                    return $request->isXmlHttpRequest() ? new Response($e->getMessage(), 400) : $this->redirectToRoute('app_analytics');
                }
            }

            return $this->redirectToRoute('app_analytics');
        }

        $data = $session->get('analytics_data', []);
        if (!empty($data)) {
            $session->remove('analytics_data');
        }

        return $this->render('analytics/index.html.twig', ['data' => $data]);
    }
}
