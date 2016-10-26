<?phpnamespace Admin\Controller;class DatamainController extends CommonController {    public function city() {        $Model = D('City');        if (IS_AJAX) {            $id = I('id', 0, 'intval');            if (empty($id)) {                $this->error('参数错误');            }            $info = $Model->find($id);            if (empty($info)) {                $this->error('未查找到数据');            }            $this->success($info);        }        if (false === $list = $Model->select()) {            $this->error($Model->getError());        }        $this->assign('list', $list);        $this->display();    }    public function cityAdd() {        $Model = D('City');        $post = I('');        if (isset($post['id']) && empty($post['id'])) {            unset($post['id']);        }        if (false === $data = $Model->create($post)) {            $this->error($Model->getError());        }        if (isset($data['id'])) {            if (false === $Model->save()) {                $this->error($Model->getError());            }        } else {            if (false === $Model->add()) {                $this->error($Model->getError());            }        }        $this->success();    }    public function cityDel() {        $Model = D('City');        $id = I('id', 0, 'intval');        if (empty($id)) {            $this->error('参数错误');        }        $info = $Model->find($id);        if (empty($info)) {            $this->error('未查找到数据');        }        $Model->startTrans();        if (false === $Model->delete($id)) {            $Model->rollback();            $this->error($Model->getError());        }        $Model->commit();        $this->success();    }    public function area() {        $Model = D('Area');        if (IS_AJAX) {            $id = I('id', 0, 'intval');            if (empty($id)) {                $this->error('参数错误');            }            $info = $Model->find($id);            if (empty($info)) {                $this->error('未查找到数据');            }            $this->success($info);        }        if (false === $list = $Model->select()) {            $this->error($Model->getError());        }        $this->assign('citylist', M('City')->select());        $this->assign('list', $list);        $this->display();    }    public function areaAdd() {        $Model = D('Area');        $post = I('');        if (isset($post['id']) && empty($post['id'])) {            unset($post['id']);        }        if (false === $data = $Model->create($post)) {            $this->error($Model->getError());        }        if (isset($data['id'])) {            if (false === $Model->save()) {                $this->error($Model->getError());            }        } else {            if (false === $Model->add()) {                $this->error($Model->getError());            }        }        $this->success();    }    public function areaDel() {        $Model = D('Area');        $id = I('id', 0, 'intval');        if (empty($id)) {            $this->error('参数错误');        }        $info = $Model->find($id);        if (empty($info)) {            $this->error('未查找到数据');        }        $Model->startTrans();        if (false === $Model->delete($id)) {            $Model->rollback();            $this->error($Model->getError());        }        $Model->commit();        $this->success();    }    public function school() {        $Model = D('School');        if (IS_AJAX) {            $id = I('id', 0, 'intval');            if (empty($id)) {                $this->error('参数错误');            }            $info = $Model->find($id);            if (empty($info)) {                $this->error('未查找到数据');            }            $this->success($info);        }        if (false === $list = $Model->select()) {            $this->error($Model->getError());        }        $this->assign('list', $list);        $this->assign('arealist', M('Area')->select());        $this->display();    }    public function schoolAdd() {        $Model = D('School');        $post = I('');        if (isset($post['id']) && empty($post['id'])) {            unset($post['id']);        }        if (false === $data = $Model->create($post)) {            $this->error($Model->getError());        }        if (isset($data['id'])) {            if (false === $Model->save()) {                $this->error($Model->getError());            }        } else {            if (false === $Model->add()) {                $this->error($Model->getError());            }        }        $this->success();    }    public function schoolDel() {        $Model = D('School');        $id = I('id', 0, 'intval');        if (empty($id)) {            $this->error('参数错误');        }        $info = $Model->find($id);        if (empty($info)) {            $this->error('未查找到数据');        }        $Model->startTrans();        if (false === $Model->delete($id)) {            $Model->rollback();            $this->error($Model->getError());        }        $Model->commit();        $this->success();    }    public function classs() {        $Model = D('Class');        if (IS_AJAX) {            $id = I('id', 0, 'intval');            if (empty($id)) {                $this->error('参数错误');            }            $info = $Model->find($id);            if (empty($info)) {                $this->error('未查找到数据');            }            $this->success($info);        }        if (false === $list = $Model->select()) {            $this->error($Model->getError());        }        $this->assign('list', $list);        $this->assign('schoollist', M('School')->select());        $this->display();    }    public function classsAdd() {        $Model = D('Class');        $post = I('');        if (isset($post['id']) && empty($post['id'])) {            unset($post['id']);        }        if (false === $data = $Model->create($post)) {            $this->error($Model->getError());        }        if (isset($data['id'])) {            if (false === $Model->save()) {                $this->error($Model->getError());            }        } else {            if (false === $Model->add()) {                $this->error($Model->getError());            }        }        $this->success();    }    public function classsDel() {        $Model = D('Class');        $id = I('id', 0, 'intval');        if (empty($id)) {            $this->error('参数错误');        }        $info = $Model->find($id);        if (empty($info)) {            $this->error('未查找到数据');        }        $Model->startTrans();        if (false === $Model->delete($id)) {            $Model->rollback();            $this->error($Model->getError());        }        $Model->commit();        $this->success();    }    /**     * 导入学生 父母表     */    public function import_stu_and_par_info() {        $Class = M('Class');        $this->assign('classlist', $Class->select());        if (IS_POST) {            $class_id = I('class_id', 0, 'intval');            if (empty($class_id)) {                $this->error('请选择班级');            }            $cinfo = $Class->find($class_id);            if (empty($cinfo)) {                $this->error('所选班级不存在');            }            $upload = new \Think\Upload();            $upload->exts = array('xls', 'xlsx'); // 设置附件上传类型            $upload->rootPath = './Uploads/'; // 设置附件上传根目录            $upload->savePath = 'Xls/'; // 设置附件上传（子）目录            $info = $upload->uploadOne($_FILES['xls']);            if (!$info) {                $this->error($upload->getError());            }            $path = $upload->rootPath . $info['savepath'] . $info['savename'];            if (!file_exists($path)) {                $this->error($path . '未上传成功');            }            import("Org.Util.PHPExcel");            import("Org.Util.PHPExcel.IOFactory", '', '.php');            if ($info['ext'] == 'xls') {                import("Org.Util.PHPExcel.Reader.Excel5", '', '.php');                $reader = \PHPExcel_IOFactory::createReader('Excel5');            } elseif ($info['ext'] == 'xlsx') {                import("Org.Util.PHPExcel.Reader.Excel2007", '', '.php');                $reader = \PHPExcel_IOFactory::createReader('Excel2007');            } else {                $this->error('错误的格式');            }            $PHPExcel = $reader->load($path); // 载入excel文件            $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表            $highestRow = $sheet->getHighestRow(); // 取得总行数                   if ($highestRow < 2) {                $this->error('文档中没数据');            }            $Student = D('Student');            $Student->startTrans();            $Member = D('Member');            $class_money = 0;            for ($r = 1; $r < $highestRow; $r++) {                $rowdata = array();                $isnull = true;                for ($i = 0; $i < 13;  ++$i) {                    $val = $sheet->getCellByColumnAndRow($i, $r + 1)->getValue();                    if (is_object($val))                        $val = $val->__toString();                    if (!empty($val)) {                        $isnull = false;                    }                    $rowdata[] = $val;                }                if ($isnull) {                    continue;                }                $studata['class_no'] = $rowdata[0];                $studata['name'] = $rowdata[1];                $map['student_no'] = $studata['student_no'] = $rowdata[2];                $map['class_id'] = $studata['class_id'] = $class_id;                $studata['sex'] = $rowdata[3] == '男' ? 1 : 2;                $map['sfz'] = $studata['sfz'] = $rowdata[4];                $studata['birthday'] = strtotime($rowdata[5]);                $studata['family_ties'] = $rowdata[7];                $studata['phone'] = $rowdata[8];                $studata['family_ties2'] = $rowdata[10];                $studata['phone2'] = $rowdata[11];                $studata['money'] = $rowdata[12];                if (!empty($studata['name']) && !empty($studata['student_no']) && !empty($studata['class_id']) && !empty($studata['sfz']) && !empty($studata['birthday']) && !empty($studata['phone']) && !$Student->where($map)->find()) {                    //数据库不存在 添加                    $Student->create($studata);                    if (false === $student_ids[] = $Student->add()) {                        continue;                    }                    unset($map);                    $memdata['real_name'] = $rowdata[6];                    $memdata['phone'] = $rowdata[8];                    if (!empty($memdata['phone']) && !$Member->where($memdata)->find()) {                        //数据库不存在 添加                        $Member->add($memdata);                    }                    $memdata['real_name'] = $rowdata[9];                    $memdata['phone'] = $rowdata[11];                    if (!empty($memdata['phone']) && !$Member->where($memdata)->find()) {                        //数据库不存在 添加                        $Member->add($memdata);                    }                    unset($memdata);                    $class_money+=doubleval($studata['money']);                }            }            if ($class_money) {                $ClassMoneyLog = D('ClassMoneyLog');                $class_money_data['class_id'] = $class_id;                $class_money_data['money'] = $class_money;                $class_money_data['note'] = '期初余额';                $class_money_data['bz'] = implode(',', $student_ids);                $ClassMoneyLog->create($class_money_data);                $class_money_id = $ClassMoneyLog->add();                $StudentMoneyLog = M('StudentMoneyLog');                $StudentMoneyLog->where(array('student_id' => array('in', $student_ids), 'class_money_id' => 0))->setField('class_money_id', $class_money_id);            }            $Student->commit();            $this->success('操作成功');            return;        }        $this->display();    }    public function teacher() {        $map["teacher_id"] = array("neq", 0);        $teacher = M("member")->where($map)->select();        $this->assign("list", $teacher);        $class = M("class")->select();        $this->assign("class", $class);        $subject = M("subject")->select();        $this->assign("kecheng", $subject);        $this->display();    }    public function teacheradd() {        $data = I();        $realname = $data["real_name"];        $phone = $data["phone"];        $nickname = $data["nickname"];        $email = $data["email"];        $cid = $data["cid"];        $banzhuren = $data["banzhuren"];        if ($banzhuren == 2) {            $cid = 0;        }        if (empty($phone)) {            $this->error("请填写手机号码");        }        if (empty($realname)) {            $this->error("请填写姓名");        }        if ($cid > 0) {            if ($teacher = M("teacher")->where(array("master_class_id" => $cid))->find()) {                $this->error("该班级已经有班主任了");            }        }        if ($_FILES['file0']["name"]) {            $upload = new \Think\Upload(); // 实例化上传类               $upload->maxSize = 3145728; // 设置附件上传大小                $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型 rootPath               $upload->savePath = '/headimgurl/'; // 设置附件上传目录    // 上传单个文件                 $info = $upload->uploadOne($_FILES['file0']);            if (!$info) {// 上传错误提示错误信息                        $this->error($upload->getError());            } else {// 上传成功 获取上传文件信息                         $data["headerurl"] = "/Uploads" . $info['savepath'] . $info['savename'];            }        }        if ($data["id"]) {            $me = M("member")->where(array("id" => $data["id"]))->find();            $member = M("member")->where(array("id" => $data["id"]))->save($data);            $teac["master_class_id"] = $cid;            $t_id = $teacher = M("teacher")->where(array("id" => $me["teacher_id"]))->save($teac);            $this->success("成功");        } else {            $teac["master_class_id"] = $cid;            $t_id = $teacher = M("teacher")->add($teac);            $data["teacher_id"] = $t_id;            if ($member = M("member")->add($data)) {                $this->success("成功");            };        }    }    public function upload() {        print_r($_FILES);    }    public function test() {        $this->display();    }    public function sever() {        print_r($_FILES);    }    public function teacher_show() {        $id = I("id");        $teacher = M("member")->where(array("id" => $id))->find();        $teacher_id = $teacher["teacher_id"];        $tinfo = M('teacher')->where(array("id" => $teacher_id))->find();        $teacher["cid"] = $tinfo["master_class_id"];        if ($class = M("class")->where(array("id" => $tinfo["master_class_id"]))->find()) {            $teacher["cname"] = $class["grade"] . "-" . $class["name"];        } else {            $teacher["cname"] = "请选择";        };        $this->success($teacher);    }    public function teacherdel() {        $id = I("id");        $teacher_id = M("member")->where(array("id" => $id))->field("teacher_id")->find();        $teacher = M("teacher")->where(array("id" => $teacher_id["teacher_id"]))->delete();        $teacher_subject_class_access = M("teacher_subject_class_access")->where(array("teacher_id" => $teacher_id["teacher_id"]))->delete();        $member = M("member")->where(array("id" => $id))->delete();        $this->success("删除成功");    }    public function renke() {        $id = I("id");        $member = M("member")->where(array("id" => $id))->find();        $subject = M("subject")->select();        $class = M("class")->select();        $access = M("teacher_subject_class_access")->where(array("teacher_id" => $member["teacher_id"]))->select();        foreach ($access as &$v) {            $classinfo = M("class")->where(array("id" => $v["class_id"]))->find();            $v["classinfo"] = $classinfo;        }        $info["member"] = $member;        $info["subject"] = $subject;        $info["class"] = $class;        $info["access"] = $access;        $this->success($info);    }    public function renkeadd() {        $data = I();        $member = M("member")->where(array("id" => $data["id"]))->field("teacher_id")->find();        $teacher_id = $member["teacher_id"];        $cid = $data["cid"];        $subject = $data["subject"];        $teacher_subject_class_access = M("teacher_subject_class_access")->where(array("teacher_id" => $teacher_id))->delete();        //print_r($data);die();        foreach ($cid as $k => $v) {            if (!empty($v)) {                $ac["teacher_id"] = $teacher_id;                $ac["class_id"] = $v;                $ac["subject_id"] = $subject[$k];                $teacher_subject_class_access = M("teacher_subject_class_access")->add($ac);            }        }        $this->success("成功");    }}