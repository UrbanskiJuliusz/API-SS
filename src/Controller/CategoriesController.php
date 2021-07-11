<?php


namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  @Route("/api")
 */
class CategoriesController extends AbstractController
{
    private $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * @Route("/categories", methods={"GET"})
     */
    public function getAllCategories(): JsonResponse
    {
        $categories = $this->categoriesRepository->getAll();

        return new JsonResponse($categories, Response::HTTP_OK);
    }

    /**
     * @Route("/category/{id}", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getCategory($id): JsonResponse
    {
        $category = $this->categoriesRepository->findOneBy(['id' => $id]);
        if(!$category)
            return new JsonResponse("Category doesn't exist!", Response::HTTP_NOT_FOUND);

        $category = $this->categoriesRepository->transform($category);

        return new JsonResponse($category, Response::HTTP_OK);
    }

    /**
     * @Route("/add-category", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addCategory(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $categoryName = $data['name'];
        $orderView = $data['orderView'];

        $this->categoriesRepository->addNew($categoryName, $orderView);

        return new JsonResponse("Category created!", Response::HTTP_OK);
    }

    /**
     * @Route("/update-category/{id}", methods={"PUT"})
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateCategory(Request $request, $id): JsonResponse
    {
        $category = $this->categoriesRepository->findOneBy(['id' => $id]);
        if(!$category)
            return new JsonResponse("Entry doesn't exist!", Response::HTTP_NOT_FOUND);

        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $category->setName($data['name']);
        empty($data['orderView']) ? true : $category->setOrderView($data['orderView']);

        $this->categoriesRepository->update($category);

        return new JsonResponse("Category updated!", Response::HTTP_OK);
    }

    /**
     * @Route("/del-category/{id}", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function deleteCategory($id): JsonResponse
    {
        $category = $this->categoriesRepository->findOneBy(['id' => $id]);

        if(!$category)
            return new JsonResponse("Category doesn't find!", Response::HTTP_NOT_FOUND);

        if(count($category->getEntries()) != 0)
            return new JsonResponse("Category contains entries!", Response::HTTP_CONFLICT);

        $this->categoriesRepository->remove($category);

        return new JsonResponse("Category removed!", Response::HTTP_NO_CONTENT);
    }
}