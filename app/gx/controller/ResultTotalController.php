<?php
// +----------------------------------------------------------------------
// | admin [ 学无止境 ]
// +----------------------------------------------------------------------
// | Author: zzllbj@126.com
// +----------------------------------------------------------------------
namespace app\gx\controller;

use plugin\saiadmin\basic\BaseController;
use app\gx\logic\ResultTotalLogic;
use app\gx\validate\ResultTotalValidate;
use support\Request;
use support\Response;
use hg\apidoc\annotation as Apidoc;

/**
 * @Apidoc\Title("成果管理")
 */
class ResultTotalController extends BaseController
{
    
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->logic = new ResultTotalLogic();
        $this->validate = new ResultTotalValidate;
        parent::__construct();
    }

    /**
     * @Apidoc\Title("数据列表")
     * @Apidoc\Url("/gx/ResultTotal/index")
     * @Apidoc\Method("GET")
     * @Apidoc\Query("page", type="int", require=false, desc="框架自带-页码,默认1", default="1")
     * @Apidoc\Query("limit", type="int", require=false, desc="框架自带-每页数据,默认10", default="10")
     * @Apidoc\Query("saiType", type="string", require=false, desc="框架自带-获取数据类型;默认list分页;all全部数据", default="list")
     * @Apidoc\Query("orderBy", type="string", require=false, desc="框架自带-排序字段,默认主键", default="")
     * @Apidoc\Query("orderType", type="string", require=false, desc="框架自带-排序方式,默认ASC", default="")
     * @Apidoc\Query("name", type="varchar", require=false, desc="成果名称", default="")
     * @Apidoc\Returned("data", type="array", require=true, desc="分页数据")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $where = $request->more([
            ['name', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * @Apidoc\Title("保存数据")
     * @Apidoc\Url("/gx/ResultTotal/save")
     * @Apidoc\Method("POST")
     * @Apidoc\Query("name", type="varchar", require=false, desc="成果名称", default="")
     * @Apidoc\Query("class", type="int", require=false, desc="成果类型", default="")
     * @Apidoc\Query("invention_user", type="varchar", require=false, desc="发明人", default="")
     * @Apidoc\Query("patent_number", type="varchar", require=false, desc="专利号", default="")
     * @Apidoc\Query("registration_code", type="varchar", require=false, desc="登记号", default="")
     * @Apidoc\Query("licensor_user", type="varchar", require=false, desc="授权人", default="")
     * @Apidoc\Query("apply_date", type="date", require=false, desc="申请日期", default="")
     * @Apidoc\Query("public_date", type="date", require=false, desc="公告日期", default="")
     * @Apidoc\Query("public_number", type="int", require=false, desc="公告号", default="")
     * @Apidoc\Query("status", type="int", require=false, desc="状态", default="")
     * @Apidoc\Query("attachment", type="varchar", require=false, desc="附件图片", default="")
     * @param Request $request
     * @return Response
     */
    public function save(Request $request) : Response
    {
        $data = $request->post();
        if ($this->validate) {
            if (!$this->validate->scene('save')->check($data)) {
                return $this->fail($this->validate->getError());
            }
        }
        $result = $this->logic->save($data);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * @Apidoc\Title("修改数据")
     * @Apidoc\Url("/gx/ResultTotal/update")
     * @Apidoc\Method("PUT")
     * @Apidoc\Query("id", type="int", require=true, desc="主键", default="")
     * @Apidoc\Query("name", type="varchar", require=false, desc="成果名称", default="")
     * @Apidoc\Query("class", type="int", require=false, desc="成果类型", default="")
     * @Apidoc\Query("invention_user", type="varchar", require=false, desc="发明人", default="")
     * @Apidoc\Query("patent_number", type="varchar", require=false, desc="专利号", default="")
     * @Apidoc\Query("registration_code", type="varchar", require=false, desc="登记号", default="")
     * @Apidoc\Query("licensor_user", type="varchar", require=false, desc="授权人", default="")
     * @Apidoc\Query("apply_date", type="date", require=false, desc="申请日期", default="")
     * @Apidoc\Query("public_date", type="date", require=false, desc="公告日期", default="")
     * @Apidoc\Query("public_number", type="int", require=false, desc="公告号", default="")
     * @Apidoc\Query("status", type="int", require=false, desc="状态", default="")
     * @Apidoc\Query("attachment", type="varchar", require=false, desc="附件图片", default="")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id) : Response
    {
        $id = $request->input('id', $id);
        $data = $request->post();
        if ($this->validate) {
            if (!$this->validate->scene('update')->check($data)) {
                return $this->fail($this->validate->getError());
            }
        }
        $info = $this->logic->find($id);
        if (!$info) {
            return $this->fail('没有找到该数据');
        }
        $result = $this->logic->update($data, [$this->pk => $id]);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * @Apidoc\Title("读取数据")
     * @Apidoc\Url("/gx/ResultTotal/read")
     * @Apidoc\Method("GET")
     * @Apidoc\Query("id", type="int", require=true, desc="主键", default="")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function read(Request $request, $id) : Response
    {
        $id = $request->input('id', $id);
        $model = $this->logic->find($id);
        if ($model) {
            $data = is_array($model) ? $model : $model->toArray();
            return $this->success($data);
        } else {
            return $this->fail('未查找到信息');
        }
    }

    /**
     * @Apidoc\Title("修改状态")
     * @Apidoc\Url("/gx/ResultTotal/changeStatus")
     * @Apidoc\Method("POST")
     * @Apidoc\Param("id", type="int", require=true, desc="主键", default="")
     * @Apidoc\Param("status", type="int", require=true, desc="状态", default="1")
     * @param Request $request
     * @return Response
     */
    public function changeStatus(Request $request) : Response
    {
        $id = $request->input('id', '');
        $status = $request->input('status', 1);
        $result = $this->logic->where($this->pk, $id)->update(['status' => $status]);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * @Apidoc\Title("删除数据")
     * @Apidoc\Url("/gx/ResultTotal/destroy")
     * @Apidoc\Method("DELETE")
     * @Apidoc\Param("ids", type="string|array", require=true, desc="主键", default="")
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request) : Response
    {
        $ids = $request->input('ids', '');
        if (!empty($ids)) {
            $this->logic->destroy($ids);
            return $this->success('操作成功');
        } else {
            return $this->fail('参数错误，请检查');
        }
    }

    /**
     * @Apidoc\Title("回收站数据")
     * @Apidoc\Url("/gx/ResultTotal/recycle")
     * @Apidoc\Method("GET")
     * @Apidoc\Query("page", type="int", require=false, desc="框架自带-页码,默认1", default="1")
     * @Apidoc\Query("limit", type="int", require=false, desc="框架自带-每页数据,默认10", default="10")
     * @Apidoc\Query("saiType", type="string", require=false, desc="框架自带-获取数据类型;默认list分页;all全部数据", default="list")
     * @Apidoc\Query("orderBy", type="string", require=false, desc="框架自带-排序字段,默认主键", default="")
     * @Apidoc\Query("orderType", type="string", require=false, desc="框架自带-排序方式,默认ASC", default="")
     * @param Request $request
     * @return Response
     */
    public function recycle(Request $request) : Response
    {
        $where = $request->more([
            ['create_time', ''],
        ]);
        $query = $this->logic->recycle()->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * @Apidoc\Title("恢复数据")
     * @Apidoc\Url("/gx/ResultTotal/recovery")
     * @Apidoc\Method("POST")
     * @Apidoc\Param("ids", type="string|array", require=true, desc="主键", default="")
     * @param Request $request
     * @return Response
     */
    public function recovery(Request $request) : Response
    {
        $ids = $request->input('ids', '');
        if (!empty($ids)) {
            $this->logic->restore($ids);
            return $this->success('恢复成功');
        } else {
            return $this->fail('参数错误，请检查');
        }
    }

    /**
     * @Apidoc\Title("销毁数据")
     * @Apidoc\Url("/gx/ResultTotal/realDestroy")
     * @Apidoc\Method("DELETE")
     * @Apidoc\Param("ids", type="string|array", require=true, desc="主键", default="")
     * @param Request $request
     * @return Response
     */
    public function realDestroy(Request $request) : Response
    {
        $ids = $request->input('ids', '');
        if (!empty($ids)) {
            $this->logic->destroy($ids, true);
            return $this->success('操作成功');
        } else {
            return $this->fail('参数错误，请检查');
        }
    }

}