<?php


namespace App\Controller;


use App\Repository\EntriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EntriesController
 * @package App\Controller
 * @Route("/api")
 */
class EntriesController extends AbstractController
{
    private $entriesRepository;

    public function __construct(EntriesRepository $entriesRepository)
    {
        $this->entriesRepository = $entriesRepository;
    }

    /**
     * @Route("/entries", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllEntries()
    {
        $entries = $this->entriesRepository->getAll();

        return new JsonResponse($entries, Response::HTTP_OK);
    }

    /**
     * @Route("/entry/{id}", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getEntryById($id)
    {
        $entry = $this->entriesRepository->find($id);

        if(!$entry)
            return new JsonResponse("Not found!", Response::HTTP_NOT_FOUND);

        $entry = $this->entriesRepository->transform($entry);

        return new JsonResponse($entry, Response::HTTP_OK);
    }
}