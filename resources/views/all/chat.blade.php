
    <script type="text/javascript">
        var ws;
        try {
            ws = new WebSocket("ws://192.168.0.12:9527");//连接服务器
            ws.onopen = function(event){alert("已经与服务器建立了连接\r\n当前连接状态："+this.readyState);};
            ws.onmessage = function(event){
                console.info(event.data);
                var data = JSON.parse(event.data);
                $('#top').html($('#top').html() + "<span class='pull-left'>&nbsp;"+data.name+":&nbsp;&nbsp;</span><pclass='pull-left' >" + data.content + "</p>");
                $("#top").scrollTop($("#top").prop("scrollHeight"));
            };
            ws.onclose = function(event){alert("已经与服务器断开连接\r\n当前连接状态："+this.readyState);};
            ws.onerror = function(event){alert("WebSocket异常！");};

        } catch (ex) {
            alert(ex.message);
        }

        function SendData(data) {
            try{
                if(data){
                    ws.send(data);
                }
            }catch(ex){
                alert(ex.message);
            }
        };

        function seestate(){
            alert(ws.readyState);
        }
        function datatype(code,data) {
            switch (code){
                case 0:
                    SendData(data);
                    break;
                case 1:
                    break;
                case 2:
                    break;
                case 3:
                    break;
                default:
                    break;
            }

        }
        function chat() {
            var content = $('#content').val();
            if (content) {
                $('#top').html($('#top').html() + "<span class='pull-left'>{{ Auth::user()->name }}&nbsp;:&nbsp;&nbsp;</span><pclass='pull-left' >" + content + "</p>");
                $("#top").scrollTop($("#top").prop("scrollHeight"));
                $('#content').val('');
                var data={
                    name:"{{ Auth::user()->name }}",
                    content:content
                }
                datatype(0, JSON.stringify(data));
            } else {
                alert("不能为空！！");
            }
        }
        $(document).keydown(function(event){
            if(event.keyCode==13) {
                $("#send").click();
            }
        });
    </script>
    <div class="alert alert-success " style="overflow:auto;height: 200px" id="top">
    </div>
    <textarea id="content"   style="resize : none;outline:none" class="form-control" rows="3"></textarea>
    <button id='send' class="btn btn-success pull-right "  style="margin-top: 5%;width: 100px" type="button" onclick='chat();'>发送</button>

