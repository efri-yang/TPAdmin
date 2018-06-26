<?php
namespace app\admin\common;

class Tree2 {
    static public function sort($arr, $cols) {
        //子分类排序
        foreach ($arr as $k => &$v) {
            if (!empty($v['sub'])) {
                $v['sub'] = self::sort($v['sub'], $cols);
            }
            $sort[$k] = $v[$cols];
        }
        if (isset($sort)) {
            array_multisort($sort, SORT_DESC, $arr);
        }
        return $arr;
    }
    /**
     * 横向分类树
     */
    static public function hTree($arr, $pid = 0) {
        foreach ($arr as $k => $v) {
            if ($v['parent_id'] == $pid) {
                $data[$v['menu_id']] = $v;
                $data[$v['menu_id']]['sub'] = self::hTree($arr, $v['menu_id']);
            }
        }
        return isset($data) ? $data : array();
    }

    static public function hTree2($arr, $pid = 0) {
        foreach ($arr as $k => $v) {
            if ($v['pid'] == $pid) {
                $data[$v['id']] = $v;
                $data[$v['id']]['sub'] = self::hTree2($arr, $v['id']);
            }
        }
        return isset($data) ? $data : array();
    }
    /**
     * 纵向分类树
     */
    static public function vTree($arr, $pid = 0) {
        foreach ($arr as $k => $v) {
            if ($v['pid'] == $pid) {
                $data[$v['id']] = $v;
                $data += self::vTree($arr, $v['id']);
            }
        }
        return isset($data) ? $data : array();
    }

    /**
     * [getTree description]
     * $data  [数组] $data  数据  最终要展示的数据
     * $pid  [数值] $pid  获取那一层的数据
     * $tplStr  [字符串]       模板字符串
     * $resStr [字符串] 返回的字符串
     */

    public function getTree($data, $tplStr = "", $selectId = "", $resStr = "", $level = 0) {
        $total = count($data);
        $selected = "";
        $space = "";

        if ($level == 0) {
            $seat = "";
        } else {
            $seat = "|—";
        }
        $level++;
        $space = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level - 1) . $seat;
        foreach ($data as $k => $v) {
            //证明了第一层级
            if ($k == $selectId) {
                $selected = "selected";
            }
            //有子元素
            extract($v);
            eval("\$nstr = \"$tplStr\";");
            $resStr .= $nstr;
            $selected = "";
            if (count($v["sub"])) {

                $resStr = $this->getTree($v["sub"], $tplStr, $selectId, $resStr, $level);
            }
        }
        return $resStr;
    }

}
?>