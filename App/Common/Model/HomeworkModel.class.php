<?phpnamespace Common\Model;use Think\Model;class HomeworkModel extends Model {    protected function _after_select(&$resultSet, $options) {        foreach($resultSet as &$result)        {            if(false===$this->_after_find($result, $options))            {                return false;            }        }    }    protected function _after_find(&$result, $options) {        $result['send_member_info']=D('Member')->find($result['member_id']);        $result['subject_info']=M('Subject')->find($result['subject_id']);        $result['readnums']=M('__HOMEWORK_READ__')->where(array('homework_id'=>$result['id'],'is_read'=>0))->count();        $result['unreadnums']=M('__HOMEWORK_READ__')->where(array('homework_id'=>$result['id'],'is_read'=>1))->count();        $result['readinfo']=M('__HOMEWORK_READ__ hr')->join('__MEMBER__ m on m.id=hr.member_id','left')->where(array('hr.homework_id'=>$result['id'],'hr.is_read'=>0))->select();        $result['unreadinfo']=M('__HOMEWORK_READ__ hr')->join('__MEMBER__ m on m.id=hr.member_id','left')->where(array('hr.homework_id'=>$result['id'],'hr.is_read'=>1))->select();        $result['comment_list']=D('HomeworkComment')->where(array('homework_id'=>$result['id'],'reply_id'=>0,'is_delete'=>0))->order('addtime desc')->select();    }}