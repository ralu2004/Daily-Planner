<?php

namespace RalucaAdam\MyDailyPlanner\controllers;

use RalucaAdam\MyDailyPlanner\models\Category;

class CategoryController extends Controller
{
    public function create()
    {
        // Category creation logic
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = new Category();
            $category->name = $_POST['name'];

            if ($category->create()) {
                echo "Category created successfully!";
            } else {
                echo "Failed to create category.";
            }
        }
    }

    public function update($id)
    {
        // Category update logic
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = new Category();
            $category->id = $id;
            $category->name = $_POST['name'];

            if ($category->update()) {
                echo "Category updated successfully!";
            } else {
                echo "Failed to update category.";
            }
        }
    }

    public function delete($id)
    {
        // Category deletion logic
        $category = new Category();
        $category->id = $id;

        if ($category->delete()) {
            echo "Category deleted successfully!";
        } else {
            echo "Failed to delete category.";
        }
    }

    public function listCategories()
    {
        // List categories logic
        $category = new Category();
        $categories = $category->getAll();
        echo json_encode($categories);
    }
}
