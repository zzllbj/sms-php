<?php
// +----------------------------------------------------------------------
// | admin [ 学无止境 ]
// +----------------------------------------------------------------------
// | Author: zzllbj@126.com
// +----------------------------------------------------------------------
namespace app\gx\validate;

use think\Validate;
use app\gx\model\UsersInfo;

/**
 * 人员信息验证器
 */
class UsersInfoValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'name' => 'require',
        'tel' => 'require|mobile|unique:'.UsersInfo::class,
        'born_date' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'name.require' => '姓名必须填写',
        'tel.require' => '电话必须填写',
        'tel.unique' => '此电话号码已经存在，请更换号码！',
        'tel.mobile' => '手机号码不正确，无语了',
        'born_date' => '必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'name',
            'tel',
            'born_date',
        ],
        'update' => [
            'name',
            'tel',
            'born_date',
        ],
    ];

}
