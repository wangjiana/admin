<?php

if (! function_exists('arrayToTree')) {
    /**
     * 数组转为树形结构，父级找子级
     * 减少循环次数（unset($array[$key]) 删除已被选定无用数据， 加【&】减少无用数据，如果不加【&】$array 会保持传入递归函数之前的 unset($array) 之后的状态）
     * @param $array
     * @param int $parentId
     * @param string $indexKey
     * @param string $parentName
     * @param string $childrenName
     * @return array
     */
    function arrayToTree(&$array, $parentId = 0, $indexKey = 'id', $parentName = 'parent_id', $childrenName = 'children')
    {
        $tempArray = array();
        foreach ($array as $key => $value) {
            if ($value[$parentName] == $parentId) {
                unset($array[$key]);
                $value[$childrenName] = arrayToTree($array, $value[$indexKey], $indexKey, $parentName, $childrenName);
                $tempArray[] = $value;
            }
        }
        return $tempArray;
    }
}

if (! function_exists('treeToArray')) {
    /**
     * 树形结构转为二维数组
     * @param $data
     * @param int $parentId
     * @param string $indexKey
     * @param string $parentName
     * @param string $childrenName
     * @return array
     */
    function treeToArray($data, $parentId = 0, $indexKey = 'id', $parentName = 'parent_id', $childrenName = 'children')
    {
        $tempArray = array();
        foreach ($data as $key => $value) {
            $tempArray[] = [$indexKey => $value[$indexKey], $parentName => $parentId];
            if (isset($value[$childrenName])) {
                $tempArray = array_merge($tempArray, treeToArray($value[$childrenName], $value[$indexKey], $indexKey, $parentName, $childrenName));
            }
        }
        return $tempArray;
    }
}