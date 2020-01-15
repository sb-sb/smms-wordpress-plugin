var pages = 2
jQuery(document).ready(function($) {
    $('#admin-img-file').change(function() {
        for (var i = 0; i < this.files.length; i++) {
            var f = this.files[i];
            var formData = new FormData();
            formData.append('smfile', f);
            $.ajax({
                url: '/index.php/wp-json/smms/api/v2/upload',
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    $('textarea[name="content"]').insertAtCaret('<img class="aligncenter" src="' + res.data.url + '" />');
                    $("html").find("iframe").contents().find("body").append('<img class="aligncenter" src="'+res.data.url+'" />'); 
                }
            })
        }
    });

    //加载图片
    $("#toggleModal").click(function(){
        pages = 2
        $("#img_list > li").remove()
        $.ajax({
            url: '/index.php/wp-json/smms/api/v2/list',
            type: 'GET',
            cache:false,
            dataType: 'json', 
            success: function(data) {
                for(var x in data){
                    $("#img_list").append('<li><img id="modal-image-' + x + '" class="modal-image" src="' + data[x].url + '" /></li>')
                }
                if (data.length < 10) {
                    $('#upload-btn').css('display','none');
                }else{
                    $('#upload-btn').css('display','inline-block');
                }
            }
        })
    }) 
    $("#upload-btn").click(function(){

        $.ajax({
            url: '/index.php/wp-json/smms/api/v2/list',
            type: 'GET',
            cache: false,
            dataType: 'json',
            data: {
                pages: pages
            },
            success: function(data) {
                if (data.length != 0) {
                    for(var x in data){
                        $("#img_list").append('<li><img id="modal-image-' + x + '" class="modal-image" src="' + data[x].url + '" /></li>')

                    }
                    pages++
                }else{
                    $('#upload-btn').css('display','none');
                    alert("已加载完全部图片")
                }
            }
        })
    })

    $(document).mouseup(function(e){
      var _con = $('.modal');   // 设置目标区域
      if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            $(".modal").css('display','none')
      }
    });


    //插入图片
    $("#img_list").on('click','img',function(e){
        $('textarea[name="content"]').insertAtCaret('<img class="aligncenter" src="' + e.target.src + '" />');
        $("html").find("iframe").contents().find("body").append('<img class="aligncenter" src="'+ e.target.src +'" />'); 
    }) 

    $.fn.extend({  
        insertAtCaret: function(myValue) {  
            var $t = $(this)[0];  
              //IE  
            if (document.selection) {  
                this.focus();  
                sel = document.selection.createRange();  
                sel.text = myValue;  
                this.focus();  
            } else  
            //!IE  
            if ($t.selectionStart || $t.selectionStart == "0") {  
                var startPos = $t.selectionStart;  
                var endPos = $t.selectionEnd;  
                var scrollTop = $t.scrollTop;  
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);  
                this.focus();  
                $t.selectionStart = startPos + myValue.length;  
                $t.selectionEnd = startPos + myValue.length;  
                $t.scrollTop = scrollTop;  
            } else {  
                this.value += myValue;  
                this.focus();  
            }  
        }  
    });
})
