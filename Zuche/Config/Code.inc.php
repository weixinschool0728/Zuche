<?php
#vesion no
$code['vesion'] = '1.1.262200';

$code['adminMenu'] = array(
        'name' => '后台管理',
		'sub' => array(
            'user' => array(
                'name' => '用户管理',
                'uri' => '?c=User&a=userList',
                'menu_no' => 'no_1',
            ),
            'order' => array(
                'name' => '订单管理',
                'sub' => array(
                    'index' => array('name' => '订单一览', 'uri' => '?c=order&amp;a=index', 'menu_no' => 'no_2',),
                   
                ),
            ),
           
            'class' => array(
                'name' => '分类管理',
                'sub' => array(
                    'index' => array('name' => '分类一览', 'uri' => '?c=product&a=index', 'menu_no' => 'no_6',),
                ),
            ),
            'carmanger' => array(
                'name' => '车辆管理',
                'sub' => array(
                    'index' => array('name' => '车辆一览', 'uri' => '?c=car&a=mindexlist', 'menu_no' => 'no_7',),
                ),
            ),
        ),
    
);
$code['orderstatus'] = array(
    0 => "未支付",
    1 => "支付失败",
    2 => "支付成功",
    3 => "支付取消",
);
$code['sex'] = array(
    0 => "女",
    1 => "男",

);
$code['user_type'] = array(
    0 => "普通用户",
    1 => "管理员",
    2 => "超级管理员",
);
$code['u_vip'] = array(
    0 => "普通用户",
    1 => "一级会员",
    2 => "二级会员",
);

$code['order'] = array(
    'car' => array(
        'a' => array('field' => 'sort', 'default' => 'asc'),
        'b' => array('field' => 'service_type'),
    ),
    'product' => array(
        'a' => array('field' => 'product_type', 'default' => 'asc'),
    ),
);
$code['paging'] = array(
    'admin' => array(
        'one' => array(
            1 => array('count' => 10, 'name' => '10件','value' => 1,'default' => true),
            2 => array('count' => 20, 'name' => '20件','value' => 2),
            3 => array('count' => 50, 'name' => '50件','value' => 3),
            4 => array('count' => 0, 'name' => '全件','value' => 4),
        ),
    ),
    
);


$code['user'] = array(
    'role' => array(
//        0 => array('name' => 'アカウント管理者','value' => 0),
        1 => array('name' => 'アカウント副管理者','value' => 1),
        2 => array('name' => '社内ユーザ','value' => 2),
        
    ),
);

