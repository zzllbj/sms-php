<?php
// +----------------------------------------------------------------------
// | admin [ 学无止境 ]
// +----------------------------------------------------------------------
// | Author: zzllbj@126.com
// +----------------------------------------------------------------------
namespace app\gx\model;

use plugin\saiadmin\basic\BaseModel;

/**
 * 成果管理模型
 */
class ResultTotal extends BaseModel
{

    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    /**
     * 数据库表名称
     * @var string
     */
    protected $table = 'gx_result_total';

    
    /**
     * 成果名称 搜索
     */
    public function searchNameAttr($query, $value)
    {
        $query->where('name', 'like', '%'.$value.'%');
    }


}