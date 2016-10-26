$('.autocomplete').autocompleter({
    // marker for autocomplete matches
    highlightMatches: true,
    // object to local or url to remote search
    source: [{"label": '', "name": "请选择"}],
    // show hint
    hint: false,
    // abort source if empty field
    empty: true,
    // max results
    limit: 10,
    template: '{{ label }} {{ name }}',
    callback: function (value, index, selected) {
    }
});
$(".autocomplete").each(function () {
    var mydatas = $(this).attr('datas');
    mydatas = $.parseJSON(mydatas);
    var hidden_id = $(this).attr('hidden_id');
    var _this = $(this);
    var option = {
        // marker for autocomplete matches
        highlightMatches: true,
        // object to local or url to remote search
        source: mydatas,
        // show hint
        hint: false,
        // abort source if empty field
        empty: true,
        // max results
        limit: 10,
        template: '{{ label }} {{ name }}',
        callback: function (value, index, selected) {
            if (selected) {
                $('#' + hidden_id).val(selected.val);
                _this.val(selected.name);
            }
        }
    };
    _this.autocompleter('option', option);
});
updateOption    = function(dom,callback){
    if(callback==undefined)
    {
        callback=function(){};
    }
    var _this=$("#"+dom);
    var mydatas = _this.attr('datas');
    mydatas = $.parseJSON(mydatas);
    var hidden_id = _this.attr('hidden_id');
    var option = {
        // marker for autocomplete matches
        highlightMatches: true,
        // object to local or url to remote search
        source: mydatas,
        // show hint
        hint: false,
        // abort source if empty field
        empty: true,
        // max results
        limit: 10,
        template: '{{ label }} {{ name }}',
        callback: function (value, index, selected) {
            if (selected) {
                $('#' + hidden_id).val(selected.val);
                _this.val(selected.name);
                callback(selected);
            }
        }
    };
    _this.autocompleter('option', option);
};