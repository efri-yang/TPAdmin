<?php
namespace app\admin\common;

class Tree {
    protected $repeatPlaceholder = "&nbsp;&nbsp;&nbsp;&nbsp;";
    public $arr = [];
    public $icon = ['│', '├', '└'];
    public $nbsp = "&nbsp;";
    private $str = '';

    public $ret = '';

    public function init($arr = []) {
        $this->arr = $arr;
        $this->ret = '';
        return is_array($arr);
    }

    //获取当前menu的下一级子元素(注意仅仅是下一级)
    public function getChild($id) {
        $newArr = [];
        if (is_array($this->arr)) {
            foreach ($this->arr as $k => $v) {
                if ($v["pid"] == $id) {
                    $newArr[$k] = $v;
                }
            }
        }
        return $newArr ? $newArr : false;
    }

    public function getTree($myid, $str, $sid = 0, $adds = '', $str_group = '') {
        $number = 1;
        //一级栏目
        $child = $this->getChild($myid); //得到子级同级数组
        if (is_array($child)) {
            $total = count($child); //子级数组个数
            foreach ($child as $id => $value) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2]; //最后1个，前置符号为“└”
                } else {
                    $j .= $this->icon[1]; //否则，前置符号为“├”
                    $k = $adds ? $this->icon[0] : ''; //额外前置符号
                }
                //如果有前缀的时候，那么pid=0的menu 就是=》前缀|—选项名，
                //如果没有前缀的时候,那么pid=0的menu 就是=》选项名，
                //
                $spacer = $adds ? $adds . $j : '';
                $selected = $id == $sid ? 'selected' : '';

                $parentId = $value['pid'];
                @extract($value);

                $parentId == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";"); //顶级

                $this->ret .= $nstr;

                $nbsp = $this->nbsp;
                $this->getTree($id, $str, $sid, $adds . $k . $nbsp, $str_group); //递归子级数组
                $number++;
            }
        }
        return $this->ret;
    }

    /**
     * 横向分类树
     */
    static public function hTree($arr, $pid = 0) {
        foreach ($arr as $k => $v) {
            if ($v['pid'] == $pid) {
                $data[$v['id']] = $v;
                $data[$v['id']]['sub'] = self::hTree2($arr, $v['id']);
            }
        }
        return isset($data) ? $data : array();
    }

    public function getChild2($id, $data) {
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v["pid"] == $id) {
                $arr[] = $v;
            }
        }
        return !empty($arr) ? $arr : false;
    }

    public function getSideMenu($levelId, $currentId, $parentIds, $data, $sideMenuText = "", $repeatNum = 0) {
        $child = $this->getChild2($levelId, $data);
        $repeatText = str_repeat($this->repeatPlaceholder, $repeatNum);

        if (is_array($child)) {
            foreach ($child as $key => $value) {
                $subChild = $this->getChild2($value["id"], $data);
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
}

?>