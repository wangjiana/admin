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
     *$data = [
     *    [
     *        "id" => "1",
     *        "children" => [
     *            [
     *                "id" => "2",
     *                "children" => [
     *                    [
     *                        "id" => "3",
     *                    ]
     *                ],
     *            ],
     *        ]
     *    ]
     *];
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
            $value[$parentName] = $parentId;
            $tempArray[] = $value;
            if (isset($value[$childrenName])) {
                $tempArray = array_merge($tempArray, treeToArray($value[$childrenName], $value[$indexKey], $indexKey, $parentName, $childrenName));
            }
        }

        return $tempArray;
    }
}

/**
 * 树形结构转为二维数组
 *
$permissions = [
    ['name' => 'xtgl', 'guard_name' => 'web', 'icon' => 'fa fa-tasks', 'menu_name' => '系统管理', 'url' => '', 'children' => [
        ['name' => 'users.index', 'guard_name' => 'web', 'icon' => 'fa fa-users', 'menu_name' => '用户列表 ', 'url' => '/users', 'children' => [
            ['name' => 'users.create', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '创建用户', 'url' => ''],
            ['name' => 'users.store', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '保存用户', 'url' => ''],
            ['name' => 'users.edit', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '编辑用户', 'url' => ''],
            ['name' => 'users.update', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '更新用户', 'url' => ''],
            ['name' => 'users.destroy', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '删除用户', 'url' => ''],
        ]]
    ]],
];
 * @param $data
 * @param int $parentId
 * @param string $indexKey
 * @param string $parentName
 * @param string $childrenName
 * @return array
 */
if (! function_exists('treeToArrayNoId')) {
    function treeToArrayNoId($data, $parentId = 0, $indexKey = 'id', $parentName = 'parent_id', $childrenName = 'children')
    {
        static $_treeToArrayNoId = 0;

        $tempArray = array();

        foreach ($data as $key => $value) {
            $value[$indexKey] = ++$_treeToArrayNoId;
            $value[$parentName] = $parentId;
            $childs = isset($value[$childrenName]) ? $value[$childrenName] : [];
            unset($value[$childrenName]);
            $tempArray[] = $value;

            if (isset($childs)) {
                $tempArray = array_merge($tempArray, treeToArrayNoId($childs, $value[$indexKey], $indexKey, $parentName, $childrenName));
            }
        }

        return $tempArray;
    }
}

if (! function_exists('arrayAddDelimiter')) {
    /**
     * 处理二维数组增加 delimiter 字段并进行层级关系排序
     * @param $array
     * @param int $parentId
     * @param string $delimiter
     * @param int $level
     * @return array
     */
    function arrayAddDelimiter(&$array, $parentId = 0, $delimiter = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level = 1)
    {
        $tempArray = array();

        foreach ($array as $key => $value) {
            if ($value['parent_id'] == $parentId) {
                unset($array[$key]);
                $value['delimiter'] = str_repeat($delimiter, $level);
                $tempArray[] = $value;
                $tempArray = array_merge($tempArray, arrayAddDelimiter($array, $value['id'], $delimiter, $level + 1));
            }
        }

        return $tempArray;
    }
}

if (! function_exists('arrayChildMerge')) {
    /**
     * 把数组的子集进行合并【三维数组转二维数组】
     * @param $array
     * @return array
     */
    function arrayChildMerge($array)
    {
        $tempArray = array();

        foreach ($array as $value) {
            $tempArray = array_merge($tempArray, $value);
        }

        return $tempArray;
    }
}

if (! function_exists('treeFindNode')) {
    /**
     * 树形结构中获取子节点【默认不返回上级节点， $rootNode = true 则返回所有上级节点】
     * @param $data
     * @param string $nodeName
     * @param string $nodeValue
     * @param bool $rootNode
     * @param string $childrenName
     * @return mixed
     */
    function treeFindNode($data, $nodeName = '', $nodeValue = '', $rootNode = false, $childrenName = 'children')
    {
        foreach ($data as $value) {
            if ($value[$nodeName] == $nodeValue) {
                return $value;
            }
            if (! empty($value[$childrenName])) {
                $tempArray = treeFindNode($value[$childrenName], $nodeName, $nodeValue, $rootNode, $childrenName);
                if ($tempArray) {
                    $rootNode ? $value[$childrenName] = [$tempArray] : $value = $tempArray;
                    return $value;
                }
            }
        }
    }
}