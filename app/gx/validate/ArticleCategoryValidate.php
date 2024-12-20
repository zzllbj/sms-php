<?php
// +----------------------------------------------------------------------
// | admin [ 学无止境 ]
// +----------------------------------------------------------------------
// | Author: zzllbj@126.com
// +----------------------------------------------------------------------
namespace app\gx\validate;

use think\Validate;

/**
 * 文章分类验证器
 */
class ArticleCategoryValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'parent_id' => 'require',
        'category_name' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'parent_id' => '上级菜单必须填写',
        'category_name' => '分类标题必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'parent_id',
            'category_name',
        ],
        'update' => [
            'parent_id',
            'category_name',
        ],
    ];

}
