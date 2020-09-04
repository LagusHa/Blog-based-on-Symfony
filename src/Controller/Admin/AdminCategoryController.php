<?php
/**
 * Created by PhpStorm.
 * User: gotohell
 * Date: 2020-07-07
 * Time: 20:39
 */

namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Категории';
        $forRender['category'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/category/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/category/create", name="admin_category_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid()))
        {
            $this->categoryRepository->setCreateCategory($category);
            $this->addFlash('success', 'Категория добавлена');
            return $this->redirectToRoute('admin_category');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Создание категории';
        $forRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig', $forRender);
    }

    /**
     * @Route("/admin/category/edit/{id}", name="admin_category_edit")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(int $id, Request $request)
    {
        $category = $this->categoryRepository->getOneCategory($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid()))
        {
            if ($form->get('save')->isClicked()){
                $this->categoryRepository->setUpdateCategory($category);
                $this->addFlash('success', 'Категория изменена');
            }
            if ($form->get('delete')->isClicked()){
                $this->categoryRepository->setDeleteCategory($category);
                $this->addFlash('success', 'Категория удалена');
            }
            return $this->redirectToRoute('admin_category');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование категории';
        $forRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig', $forRender);
    }
}