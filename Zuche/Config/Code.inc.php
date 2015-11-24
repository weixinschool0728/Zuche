<?php
#vesion no
$code['vesion'] = '1.1.262200';

$code['menu'] = array(
    'service' => array(
        'name' => 'サービス一覧',
        'uri' => '?c=service',
        'menu_no' => 'no_1',
    ),
    'user' => array(
        'name' => 'お客様管理',
        'role' => array(0, 1),
        'sub' => array(
            'index' => array('name' => 'ユーザ設定', 'uri' => '?c=user&amp;a=index', 'menu_no' => 'no_2',),
            'serviceSetting' => array('name' => '利用サービス設定', 'uri' => '?c=user&amp;a=serviceSetting', 'menu_no' => 'no_3',),
            'contact' => array('name' => '連絡先情報', 'uri' => '?c=user&amp;a=contact', 'menu_no' => 'no_4',),
        ),
    ),
    'product' => array(
		'name' => '契約設定',
        'role' => array(0, 1, 3),
		'sub' => array(
			'index' => array('name' => '利用状況・契約手続', 'uri' => '?c=product&a=index', 'menu_no' => 'no_5',),
		),
	),
   /* 'iplimit' => array(
		'name' => 'セキュリティ設定',
        'role' => array(0, 1),
		'sub' => array(
			'index' => array('name' => 'IPアドレス制限', 'uri' => '?c=iplimit&a=index', 'menu_no' => 'no_6',),
		),
	),*/
    'person' => array(
		'name' => '個人アカウント情報',
        'role' => array(0, 1, 2, 3),
		'sub' => array(
			'account' => array('name' => 'プロフィール変更', 'uri' => '?c=person&a=setComp', 'menu_no' => 'no_7',),
            'email' => array('name' => 'メールアドレス変更', 'uri' => '?c=person&a=setEmail', 'menu_no' => 'no_8',),
            'password' => array('name' => 'パスワード変更', 'uri' => '?c=person&a=setPwd', 'menu_no' => 'no_9',),
            'question' => array('name' => '秘密の質問再登録', 'uri' => '?c=person&a=setQust', 'menu_no' => 'no_10',),
            'deleted' => array('name' => 'アカウント削除(筆まめクラウド退会）', 'uri' => '?c=person&a=deleted', 'menu_no' => 'no_11',),
		),
	)
);

$code['order'] = array(
    'service' => array(
        'a' => array('field' => 'service_sort', 'default' => 'asc'),
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

