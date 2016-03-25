<?php
#vesion no
$code['vesion'] = '1.1.262200';

$code['adminMenu'] = array(
        'name' => '后台管理',
		'sub' => array(
            'user' => array(
                'name' => '用户管理',
                'uri' => '?c=admin&a=userList',
                'menu_no' => 'no_1',
            ),
            'order' => array(
                'name' => '订单管理',
                'sub' => array(
                    'index' => array('name' => 'ユーザ設定', 'uri' => '?c=user&amp;a=index', 'menu_no' => 'no_2',),
                    'serviceSetting' => array('name' => '利用サービス設定', 'uri' => '?c=user&amp;a=serviceSetting', 'menu_no' => 'no_3',),
                    'contact' => array('name' => '連絡先情報', 'uri' => '?c=user&amp;a=contact', 'menu_no' => 'no_4',),
                ),
            ),
            'orderLog' => array(
                'name' => '订单日志',
                'sub' => array(
                    'index' => array('name' => '利用状況・契約手続', 'uri' => '?c=product&a=index', 'menu_no' => 'no_5',),
                ),
            ),
            'class' => array(
                'name' => '分类管理',
                'sub' => array(
                    'index' => array('name' => '利用状況・契約手続', 'uri' => '?c=product&a=index', 'menu_no' => 'no_6',),
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

