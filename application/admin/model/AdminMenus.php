<?php
namespace app\admin\model;
use think\Model;

class AdminMenus extends Model {
    protected $pk = 'menu_id';
    protected $resultSetType = 'collection';
    //每个adminMenus 中的项都对应auth_rule 中的其中一个项，但是事实上 authrules 中的menu_id 并不是如我们设想的那样foreign key
    //这个是一一对应的  默认的 join 类型为 INNER
    //SELECT * FROM `think_admin_menus` inner JOIN think_auth_rules on think_admin_menus.menu_id=think_auth_rules.menu_id where think_admin_menus.menu_id=1  不需要外键关联也是可以查询的
    public function authRule() {
        return $this->hasOne('AuthRules', 'menu_id', 'menu_id');
    }
}
?>