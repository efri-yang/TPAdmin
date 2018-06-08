<?php
namespace app\admin\common;

class Tree {
    protected $repeatPlaceholder = "&nbsp;&nbsp;&nbsp;&nbsp;";


    /**
     * 数据排序
     */




//    static public function sort($arr, $cols) {
//        foreach ($arr as $k => &$v) {
//            if (!empty($v['sub'])) {
//                $v['sub'] = self::sort($v['sub'], $cols);
//            }
//            $sort[$k] = $v[$cols];
//        }
//        if(isset($sort)){
//            array_multisort($sort, SORT_DESC, $arr);
//        }
//        return $arr;
//    }
//    /**
//     * 横向分类树
//     */
//    static public function hTree($arr, $pid = 0) {
//        foreach ($arr as $k => $v) {
//            if ($v['parent_id'] == $pid) {
//                $data[$v['id']] = $v;
//                $data[$v['id']]['sub'] = self::hTree($arr, $v['id']);
//            }
//        }
//        return isset($data) ? $data : array();
//    }
//    /**
//     * 纵向分类树
//     */
//    static public function vTree($arr, $pid = 0) {
//        foreach ($arr as $k => $v) {
//            if ($v['parent_id'] == $pid) {
//                $data[$v['id']] = $v;
//                $data += self::vTree($arr, $v['id']);
//            }
//        }
//        return isset($data) ? $data : array();
//    }
//
//    /**
//        *传进来模板字符算,还有节点,选择的id
//     */
//    public function  getTree($nodeNum,$data,$tplStr="",$selId="",$reStr=""){
//        //获取传进来节点的所有子元素(例如传进来的是0，那么表示获取所有根节点元素)
//        $realData=self::vTree($data,$nodeNum);
//    }








    public function getSideMenu($levelId, $currentId, $parentIds, $data, $sideMenuText = "", $repeatNum = 0) {
        $child = $this->getChild($levelId, $data);
        $repeatText = str_repeat($this->repeatPlaceholder, $repeatNum);
        if (is_array($child)) {
            foreach ($child as $key => $value) {
                $subChild = $this->getChild($value["menu_id"], $data);
                if ($subChild) {

                    if (array_search($value["menu_id"], $parentIds, true) !== false) {
                        $sideMenuText .= '<li class="treeview active hactive"><a href="javascript:void(0);"><span class="fl">' . $repeatText . '</span><i class="iconfont f14">&#xe65d;</i><span class="txt">' . $value['title'] . '</span><span class="more"></span></a><ul class="treeview-menu">';
                    } else {
                        $sideMenuText .= '<li class="treeview"><a href="javascript:void(0);"><span class="fl">' . $repeatText . '</span><i class="iconfont f14">&#xe65d;</i><span class="txt">' . $value['title'] . '</span><span class="more"></span></a><ul class="treeview-menu">';
                    }
                    $repeatNum++;
                    $sideMenuText = $this->getSideMenu($value["menu_id"], $currentId, $parentIds, $data, $sideMenuText, $repeatNum);

                    $sideMenuText .= "</ul></li>";
                } else {

                    if ($value["menu_id"] == $currentId || array_search($value["menu_id"], $parentIds, true) !== false) {

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
            if ($v["parent_id"] == $id) {
                $arr[] = $v;
            }
        }
        return !empty($arr) ? $arr : false;
    }

    public function getMenu($levelId, $data, $str = "", $repeatNum = 0) {
        $child = $this->getChild($levelId, $data);
        $repeatText = str_repeat($this->repeatPlaceholder, $repeatNum);

        if ($repeatNum) {
            $repeatLine = "|— ";

        } else {
            $repeatLine = "";

        }
        $repeatNum++;
        if (is_array($child)) {
            foreach ($child as $key => $value) {
                switch ($value["log_type"]) {
                    case 1:
                        $logType = 'get';
                        break;
                    case 2:
                        $logType = 'post';
                        break;
                    case 3:
                        $logType = 'input';
                        break;
                    case 1:
                        $logType = 'delete';
                        break;
                    default:
                        $logType = 'get';

                }
                $subChild = $this->getChild($value["menu_id"], $data);
                if ($subChild) {
                    $roler = "parent";
                } else {
                    $roler = "single";
                }
                $str .= '<tr>';
                $str .= '<td>' . $value["menu_id"] . '</td>';
                $str .= '<td class="align-l">' . $repeatText . $repeatLine . $value["title"] . '</td>';
                $str .= '<td class="align-l">' . $value["url"] . '</td>';
                $str .= '<td>' . $value["parent_id"] . '</td>';
                $str .= '<td><i class="iconfont ' . $value["icon"] . '"></i>' . $value["icon"] . '</td>';
                $str .= '<td>' . $value["sort_id"] . '</td>';
                $str .= '<td>' . ($value["status"] == 1 ? "正常" : "禁用") . '</td>';
                $str .= '<td>' . $logType . '</td>';
                $str .= '<td><a href="' . url("admin_menu/del", ["id" => $value["menu_id"]]) . '" class="am-btn am-btn-danger am-btn-xs mr5" data-roler="' . $roler . '">删除</a><a href="' . url("admin_menu/edit", ["id" => $value["menu_id"]]) . '" class="am-btn am-btn-primary am-btn-xs">修改</a></td>';
                $str .= '</tr>';
                if ($subChild) {
                    $str = $this->getMenu($value["menu_id"], $data, $str, $repeatNum);
                }

            }
        }

        return $str;
    }

    public function getOptions($levelId, $data,$selectId=0,$str = "", $repeatNum = 1) {
        if($levelId==0){
            $str .= '<option value="0" '.($selectId==0 ? 'selected' :'').'>根目录</option>';
        }
        $child = $this->getChild($levelId, $data);
        $repeatText = str_repeat($this->repeatPlaceholder, $repeatNum);
        if ($repeatNum) {
            $repeatLine = "|— ";
        } else {
            $repeatLine = "";
        }
        $repeatNum++;
        if (is_array($child)) {
            foreach ($child as $key => $value) {

                $str .= '<option '.($selectId==$value['menu_id'] ? 'selected' :'').' value="' . $value["menu_id"] . '">' . $repeatText . $repeatLine . $value["title"] . '</option>';

                $subChild = $this->getChild($value["menu_id"], $data);
                if ($subChild) {
                    $str = $this->getOptions($value["menu_id"], $data,$selectId,$str, $repeatNum);
                }

            }
        }

        return $str;
    }






}

?>