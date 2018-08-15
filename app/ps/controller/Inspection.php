<?php
namespace app\ps\controller;

class Inspection extends PsBase
{
    /**
     * inspection列表
     */
    public function recordList()
    {
        if(IS_POST || IS_AJAX){
            if(isset($this->param['action']) ){
                $this->ajaxGetData($this->param['action']);
            }
        }
        $where = $this->logicInspection->getWhere($this->param);

        $this->assign('list', $this->logicInspection->getRecordList($where));
        return $this->fetch('record_list');
    }

    /**
    * 农产检测
    */
    public function Agriculture()
    {
        if(IS_POST || IS_AJAX){
            if(isset($this->param['action']) ){
                $this->ajaxGetData($this->param['action']);
            }else{
                $this->jump($this->logicInspection->agricultureAdd($this->param));
            } 
        }
        $this->param['record_type']=1;

        $this->assign('list',$this->logicInspection->getUnmarkData($this->param));
        if(isset($this->param['review'])){
            $this->assign('review',$this->logicInspection->getReviewData($this->param['review']));
        }
        return $this->fetch('agriculture');
    }

     /**
    * 标品收货
    */
    public function mark()
    {
        if(IS_POST || IS_AJAX){
            if(isset($this->param['action']) ){
                $this->ajaxGetData($this->param['action']);
            }else{
                $this->jump($this->logicInspection->getMarks($this->param,2));
            } 
        }

        $this->assign('list', $this->logicInspection->getMarks($this->param,2));
        if(isset($this->param['review'])){
            $this->assign('review',$this->logicInspection->getReviewData($this->param['review']));
        }
        return $this->fetch('');
    }

    /**
    * 生鲜收货
    */
     public function fresh()
    {
        if(IS_POST || IS_AJAX){
            if(isset($this->param['action']) ){
                $this->ajaxGetData($this->param['action']);
            }else{
                $this->jump($this->logicInspection->freshAdd($this->param));
            } 
        }
        
        $this->param['record_type']=3;
        $this->assign('list',$this->logicInspection->getUnmarkData($this->param));
        if(isset($this->param['review'])){
            $this->assign('review',$this->logicInspection->getReviewData($this->param['review']));
        }
        return $this->fetch('fresh');
    }

    /**
    * 包装易耗品收货
    */
    public function packing()
    {
        if(IS_POST || IS_AJAX){
            if(isset($this->param['action']) ){
                $this->ajaxGetData($this->param['action']);
            }else{
                $this->jump($this->logicInspection->getMarks($this->param,4));
            } 
        }

        $this->assign('list',$this->logicInspection->getMarks($this->param,4));
        if(isset($this->param['review'])){
            $this->assign('review',$this->logicInspection->getReviewData($this->param['review']));
        }
        return $this->fetch('');
    }


        /**
    * 添加分拣巡查记录
    */
    public function sorting()
    {
        if(IS_POST || IS_AJAX){
            if(isset($this->param['action']) ){
                $this->ajaxGetData($this->param['action']);
            }else{
                $this->jump($this->logicInspectionSort->sortingAdd($this->param));
            } 
        }
        $list = $this->logicInspectionSort->getForm($this->param);
        $this->assign('list', $list);
        $this->assign('shift', $this->logicInspectionSort->getShift());
        if(isset($this->param['review'])){
            $this->assign('review',$this->logicInspection->getReviewData($this->param['review']));
        }
        return $this->fetch('');
    }

    /**
    * 添加储存巡查记录
    */
   public function storage()
   {

        if(IS_POST || IS_AJAX){
            if(isset($this->param['action']) ){
                $this->ajaxGetData($this->param['action']);
            }else{
                $this->jump($this->logicInspectionStorage->storageAdd($this->param));
            } 
        }
        $list = $this->logicInspectionStorage->getForm($this->param);
        $this->assign('list', $list);
        $this->assign('shift', $this->logicInspectionStorage->getShift());
        if(isset($this->param['review'])){
            $this->assign('review',$this->logicInspection->getReviewData($this->param['review']));
        }
        return $this->fetch('');

   }
   
  
    //ajax请求
    private function ajaxGetData($action = '')
    {
        unset($this->param['action']);
        switch ($action) {

            // 获取订单
            case 'getPurchase':
                return $this->logicInspection->getPurchase($this->param);;
                break;

            // 根据订单获取数据
            case 'getUnmarkData':
                return $this->jump($this->logicInspection->getUnmarkData($this->param));
                break;
            // 获取订单商品
            case 'getGoods':
                return  $this->logicInspection->getGoods($this->param);
                break;
             // 提交数据
            case 'recordEdit':
                return   $this->jump($this->logicInspection->recordEdit($this->param));
                break;
             // 删除数据
            case 'inspectionDel':        

                return   $this->jump($this->logicInspection->inspectionDel(['id' => $this->param['id']]));
                break;

             // 更新数据
            case 'inspectionUpdate':        

                return   $this->jump($this->logicInspection->updateInspection($this->param));
                break;
             // 删除表数据
            case 'recordDel':        

                return    $this->jump($this->logicInspection->recordDel($this->param));
                break;

            default:
                return 'Request url error ...';
                break;
        }

    }


    /*记录表数据删除*/
    public function recordDel()
    {
        $this->jump($this->logicInspection->recordDel($this->param));
    }

    /*记录表数据更新*/
    public function recordEdit()
    {
        $this->jump($this->logicInspection->recordEdit($this->param));
    }




    /**
     * 分拣区域列表
     */
    public function sortingArea()
    {
        $where = $this->logicInspection->getWhere($this->param);
        $where['area_type']='0';
        $this->assign('list', $this->logicInspection->getAreaList($where));

     
        IS_POST && $this->jump($this->logicInspection->areaAdd($this->param));


        return $this->fetch('sorting_area');
    }




    /**
     * 储存列表
     */
    public function storageArea()
    {
        $where = $this->logicInspection->getWhere($this->param);
        $where['area_type']='1';
        $this->assign('list', $this->logicInspection->getAreaList($where));

        IS_POST && $this->jump($this->logicInspection->areaAdd($this->param));


        return $this->fetch('storage_area');
    }

    /**
    * inspection添加
    */
    public function inspectionAdd()
    {
        $data=$this->logicCommon->view_style('view_add');

        IS_POST && $this->jump($this->logicInspection->inspectionAdd($this->param));

        $this->assign('fields',$data);

        return $this->fetch('inspection_edit');
    }



    /**
    *记录数据更新
    */
   public function inspectionUpdate()
   {
        IS_POST && $this->jump($this->logicInspection->updateInspection($this->param));
   }

    /**
    * inspection删除
    */
    public function inspectionDel($id = 0)
    {
        $this->jump($this->logicInspection->inspectionDel(['id' => $id]));
    }

    /**
    * inspection_area删除
    */
    public function areaDel($id = 0)
    {

        $this->jump($this->logicInspection->areaDel(['id' => $id]));
    }
    /**
    * 数据状态设置
    */
    public function setStatus()
    {

        $this->jump($this->logicPsBase->setStatus('PsInspection', $this->param));
    }

    /**
    * 区域管理数据状态设置
    */
    public function areaStatus()
    {
        $this->jump($this->logicPsBase->setStatus('PsInspectionArea', $this->param));
    }


    /**
    * 返回订单数据
    */
    public function getPurchase()
    {
        $this->logicInspection->getPurchase($this->param);
    }

    /**
    *根据订单ID返回订单内商品数据
    */
    public function getGoods()
    {
        $this->logicInspection->getGoods($this->param);
    }

    /*
    *根据非标品订单ID和表类型获取表数据
     */
    public function getUnmarkData()
    {
        $this->jump($this->logicInspection->getUnmarkData($this->param));
    }
}
