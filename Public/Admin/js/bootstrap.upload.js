var modal_html='<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id="resetModalLabel">上传</h4> </div> <div class="modal-body"> <form id="uploadform" enctype="multipart/form-data"> <div class="form-group"> <input type="file" class="form-control" name="file" id="file"> </div> </form> </div> <div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">返回</button> <button type="button" class="btn btn-primary" id="uploadbutton">上传</button> </div> </div> </div></div>';
function myupload()
{
    var upload_modal=$("#upload_modal");
    if(upload_modal.length===0)
    {
        $("body").append(modal_html);
    }
    upload_modal=$("#upload_modal");
    $("#upload_modal").modal('show');
    $("#uploadbutton").click(function(){
        var fdata=$("#uploadform").serialize();
        $.post("{:U('Home/Upload/index')}",fdata,function(data){
            if(0==data.status)
            {
                alert(data.info);return false;
            }
            alert(data.info);
        },'json');
    });
}