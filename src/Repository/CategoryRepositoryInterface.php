<?php
/**
 * Created by PhpStorm.
 * User: gotohell
 * Date: 2020-09-04
 * Time: 20:22
 */

namespace App\Repository;


use App\Entity\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return Category[]
     */
    public function getAllCategory(): array;

    /**
     * @param int $categoryId
     * @return Category
     */
    public function getOneCategory(int $categoryId);

    /**
     * @param Category $category
     * @return Category
     */
    public function setCreateCategory(Category $category);

    /**
     * @param Category $category
     * @return Category
     */
    public function setUpdateCategory(Category $category);

    /**
     * @param Category $category
     */
    public function setDeleteCategory(Category $category);
}