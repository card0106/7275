<?php
namespace Crontab\Controller;

class CrontabController extends \Think\Controller{

	public function filedCommission()
	{
		$yesterday = date('Y-m-d', strtotime('-1 days'));
		$model = M('dataList');
		$dataList = $model->where(" onfile=0 AND data_time <= '{$yesterday}' ")->select();
		$members = M('Members');
		$log_str = '---' . $yesterday . "---\r\n";
		if(count($dataList) > 0){
			foreach($dataList as $value){
				if($value['onfile'] == 0 && $value['members_id'] > 0){
					$comission = comission($value);
					$model->startTrans();
					$res = $model->where("id={$value['id']}")->save(['onfile' => 1,'comission' => $comission]);
					$res1 = $members->where("id={$value['members_id']}")->setInc('total_amount', $comission);
					if($res && $res1){
						$model->commit();
						$log_str .= '归档成功(id:' . $value['id'] . '	' . 'member_id:' . $value['members_id'] . '	' . "money:" . $comission . ")\r\n";
					}else{
						$model->rollback();
						$log_str .= '归档失败(id:' . $value['id'] . '	' . 'member_id:' . $value['members_id'] . '	' . "money:" . $comission . ")({var_dump($res), var_dump($res1)})\r\n";
					}
				}
			}
		}
		echo $log_str;
		return $log_str;
	}
}