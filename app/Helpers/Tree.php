<?php


namespace App\Helpers;


class Tree
{
    const ROOT = 0;

    public function maakBoom($categories, $parent = self::ROOT) {
        $boom = array();
        foreach ($categories as $category) {
            if ($category->categoryParent == $parent && $category->categoryNumber != $parent) {
                $children = $this->maakBoom($categories, $category->categoryNumber);

                if (!empty($children)) {
                    $category->categoryChildren = $children;
                } else {
                    $category->categoryChildren = [];
                }
                $boom[] = $category;
            }
        }
        return $boom;
    }
}
