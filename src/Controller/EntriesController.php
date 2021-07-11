<?php


namespace App\Controller;


use App\Repository\CategoriesRepository;
use App\Repository\EntriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    private $categoryRepository;

    public function __construct(EntriesRepository $entriesRepository)
    {
        $this->entriesRepository = $entriesRepository;
    }

    /**
     * @Route("/entries", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllEntries(): JsonResponse
    {
        $entries = $this->entriesRepository->getAll();

        return new JsonResponse($entries, Response::HTTP_OK);
    }

    /**
     * @Route("/entry/{id}", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getEntryById($id): JsonResponse
    {
        $entry = $this->entriesRepository->find($id);

        if(!$entry)
            return new JsonResponse("Not found!", Response::HTTP_NOT_FOUND);

        $entry = $this->entriesRepository->transform($entry);

        return new JsonResponse($entry, Response::HTTP_OK);
    }

    /**
     * @Route("/entries-www/{www}")
     * @return JsonResponse
     */
    public function getEntriesByWww($www): JsonResponse
    {
        $entries = $this->entriesRepository->findByWwwField($www);

        return new JsonResponse($entries, Response::HTTP_OK);
    }

    /**
     * @Route("/entries-category/{categoryId}")
     * @param $categoryId
     * @return JsonResponse
     */
    public function getEntriesByCategoryId($categoryId): JsonResponse
    {
        $entries = $this->entriesRepository->findByCategoryId($categoryId);

        return new JsonResponse($entries, Response::HTTP_OK);
    }

    /**
     * @Route("/add-entry", methods={"POST"})
     * @param Request $request
     * @param CategoriesRepository $categoryRepository
     * @return JsonResponse
     */
    public function addEntry(Request $request, CategoriesRepository $categoryRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $this->categoryRepository = $categoryRepository;

        $categoryId = $data['categoryId'];
        $companyName = $data['companyName'];
        $www = $data['www'];
        $address = $data['address'];
        $content = $data['content'];
        $created = $data['created'];

        $category = $this->categoryRepository->findOneBy(['id' => $categoryId]);

        if(!$category)
            return new JsonResponse("Category doesn't exist!", Response::HTTP_NOT_FOUND);

        $this->entriesRepository->addNew($category, $companyName, $www, $address, $content, $created);

        return new JsonResponse("Entry created!", Response::HTTP_CREATED);
    }

    /**
     * @Route("/update-entry/{id}", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @param CategoriesRepository $categoryRepository
     * @return JsonResponse
     */
    public function updateEntry($id, Request $request, CategoriesRepository $categoryRepository): JsonResponse
    {
        $this->categoryRepository = $categoryRepository;

        $entry = $this->entriesRepository->findOneBy(['id' => $id]);
        if(!$entry)
            return new JsonResponse("Entry doesn't exist!", Response::HTTP_NOT_FOUND);

        $data = json_decode($request->getContent(), true);
        $category = $this->categoryRepository->findOneBy(['id' => $data['categoryId']]);

        if(!$category)
            return new JsonResponse("Category doesn't exist!", Response::HTTP_NOT_FOUND);

        empty($data['categoryId']) ? true : $entry->setCategory($category);
        empty($data['companyName']) ? true : $entry->setCompanyName($data['companyName']);
        empty($data['www']) ? true : $entry->setWww($data['www']);
        empty($data['address']) ? true : $entry->setAddress($data['address']);
        empty($data['content']) ? true : $entry->setContent($data['content']);
        empty($data['created']) ? true : $entry->setCreated(\DateTime::createFromFormat("Y-m-d H:i:s", $data['created']));

        $this->entriesRepository->update($entry);

        return new JsonResponse("Entry updated!", Response::HTTP_OK);
    }

    /**
     * @Route("/del-entry/{id}", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function deleteEntry($id): JsonResponse
    {
        $entry = $this->entriesRepository->findOneBy(['id' => $id]);

        if(!$entry)
            return new JsonResponse("Entry doesn't exist!", Response::HTTP_NOT_FOUND);

        $this->entriesRepository->remove($entry);

        return new JsonResponse("Entry removed!", Response::HTTP_NO_CONTENT);
    }
}