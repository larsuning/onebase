<?php
// +---------------------------------------------------------------------+
// | OneBase    | [ WE CAN DO IT JUST THINK ]                            |
// +---------------------------------------------------------------------+
// | Licensed   | http://www.apache.org/licenses/LICENSE-2.0 )           |
// +---------------------------------------------------------------------+
// | Author     | Bigotry <3162875@qq.com>                               |
// +---------------------------------------------------------------------+
// | Repository | https://gitee.com/Bigotry/OneBase                      |
// +---------------------------------------------------------------------+

namespace app\apips\controller;

/**
 * 公共基础接口控制器
 */
class Inspection extends ApiBase
{

	/**
     * 获取采购订单数据
     */
    public function getPurchase()
    {
        return $this->apiReturn($this->logicInspection->getPurchase($this->param));
    }

    /*
    *根据采购订单获取已生成的数据
    */
    public function getDataByPurchase()
    {
        return $this->apiReturn($this->logicInspection->getDataByPurchase($this->param));
        
    }

    /*
    *根据采购单ID获取商品数据
    */
    public function getGoods()
    {
        return $this->apiReturn($this->logicInspection->getGoods($this->param));
    }

    /*
    *将商品添加入表里
     */
    public function inspectionAdd()
    {
    	return $this->apiReturn($this->logicInspection->inspectionAdd($this->param));
    }
    
    /*
    记录添加
     */
    public function addOne()
    {
        return $this->apiReturn($this->logicInspection->addOne($this->param));
    }

    /*
    *获取并生成巡查表数据
     */
    public function getAreaData()
    {
        return $this->apiReturn($this->logicInspection->getAreaData($this->param));
    }

    /**
    *提交数据
     */
    public function finishRecord()
    {
        return $this->apiReturn($this->logicInspection->finishRecord($this->param));
    }

    /*
    *获取检测记录
     */
    public function getRecord()
    {
        return $this->apiReturn($this->logicInspection->getRecord($this->param));
    }

    /*
    *获取检测记录表数据
    */
    public function getRecordDetail()
    {
        return $this->apiReturn($this->logicInspection->getRecordDetail($this->param));
    }

    /*
    *提交审核
     */
    public function submitReview()
    {
        return $this->apiReturn($this->logicInspection->submitReview($this->param));
    }

    /*
    *删除记录
    */
    public function recordDel()
    {
        return $this->apiReturn($this->logicInspection->recordDel($this->param));
    }
}