<?php
$config = array(
    'post' => array(
        array(
            'field' => 'title',
            'label' => '帖子标题',
            'rules' => 'required|min_length[5]'
        ),
        array(
            'field' => 'content',
            'label' => '帖子内容',
            'rules' => 'required'
        ),
        array(
            'field' => 'sid',
            'label' => '栏目',
            'rules' => 'integer'
        )
    ),
    'comment' =>array(
        array(
            'field' => 'comment',
            'label' => '回复内容区域',
            'rules' => 'required'
        )

)
);


