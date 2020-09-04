<?php
/**
 * Created by PhpStorm.
 * User: gotohell
 * Date: 2020-07-07
 * Time: 19:30
 */

namespace App\Controller\Admin;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AdminBaseController
{
    private $categoryRepository;
    private $postRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, PostRepositoryInterface $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/admin/post", name="admin_post")
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Посты';
        $forRender['posts'] = $this->postRepository->getAllPost();
        $forRender['check_category'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/post/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/post/create", name="admin_post_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid()))
        {
            $file = $form->get('image')->getData();
            $this->postRepository->setCreatePost($post, $file);
            $this->addFlash('success', 'Пост добавлен');
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Создание поста';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $forRender);
    }

    /**
     * @Route("/admin/post/edit/{id}", name="admin_post_edit")
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(int $id, Request $request)
    {
        $post = $this->postRepository->getOnePost($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if (($form->isSubmitted()) && ($form->isValid()))
        {
            if ($form->get('save')->isClicked()){
                $file = $form->get('image')->getData();
                $this->postRepository->setUpdatePost($post, $file);
                $this->addFlash('success', 'Пост изменен');
            }
            if ($form->get('delete')->isClicked()){
                $this->postRepository->setDeletePost($post);
                $this->addFlash('success', 'Пост удален');
            }
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование поста';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $forRender);
    }
}