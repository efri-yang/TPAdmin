<?php
namespace app\admin\common;

class Tree {
    protected $repeatPlaceholder = "&nbsp;&nbsp;&nbsp;&nbsp;";

    /**
     * 分类排序（降序）
     */
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
            if ($v['pid'] == $pid) {
                $data[$v['id']] = $v;
                $data[$v['id']]['sub'] = self::hTree($arr, $v['id']);
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
        $space = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $level - 1) . $seat;
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

    public function getSideMenu($levelId, $currentId, $parentIds, $data, $sideMenuText = "", $repeatNum = 0) {
        $child = $this->getChild($levelId, $data);
        $repeatText = str_repeat($this->repeatPlaceholder, $repeatNum);
        if (is_array($child)) {
            foreach ($child as $key => $value) {
                $subChild = $this->getChild($value["id"], $data);
                if ($subChild) {

                    if (array_search($value["id"], $parentIds, true) !== false) {
                        $sideMenuText .= '<li class="treeview active hactive"><a href="javascript:void(0);"><span class="fl">' . $repeatText . '</span><i class="iconfont f14">&#xe65d;</i><span class="txt">' . $value['title'] . '</span><span class="more"></span></a><ul class="treeview-menu">';
                    } else {
                        $sideMenuText .= '<li class="treeview"><a href="javascript:void(0);"><span class="fl">' . $repeatText . '</span><i class="iconfont f14">&#xe65d;</i><span class="txt">' . $value['title'] . '</span><span class="more"></span></a><ul class="treeview-menu">';
                    }
                    $repeatNum++;
                    $sideMenuText = $this->getSideMenu($value["id"], $currentId, $parentIds, $data, $sideMenuText, $repeatNum);

                    $sideMenuText .= "</ul></li>";
                } else {

                    if ($value["id"] == $currentId || array_search($value["id"], $parentIds, true) !== false) {

                        $sideMenuText .= '<li class="current"><a href="' . url($value["url"]) . '"><span class="fl">' . $repeatText . '</span><i class="iconfont f14">&#xe65d;</i><span class="txt">' . $value['title'] . '</span></a></li>';
                    } else {

                        $sideMenuText .= '<li><a href="' . url($value["url"]) . '"><span class="fl">' . $repeatText . '</span><i class="iconfont f14">&#xe65d;</i><span class="txt">' . $value['title'] . '</span></a></li>';
                    }
                }
            }
        }
        return $sideMenuText;
    }

    public function getChild($id, $data) {
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v["pid"] == $id) {
                $arr[] = $v;
            }
        }
        return !empty($arr) ? $arr : false;
    }

    //

}

?>