
    <script type="text/javascript">
        var ws;
        function ToggleConnectionClicked() {
            try {
                ws = new WebSocket("ws://192.168.0.12:9527");//连接服务器
                ws.onopen = function(event){alert("已经与服务器建立了连接\r\n当前连接状态："+this.readyState);};
                ws.onmessage = function(event){
                    console.log('456');};
                ws.onclose = function(event){alert("已经与服务器断开连接\r\n当前连接状态："+this.readyState);};
                ws.onerror = function(event){alert("WebSocket异常！");};

            } catch (ex) {
                alert(ex.message);
            }
        };

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
                $('#top').html($('#top').html() + "<p >" + content + "</p>");
                $("#top").scrollTop($("#top").prop("scrollHeight"));
                $('#content').val('');
                datatype(0, content);
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

<button id='ToggleConnection' type="button" onclick='ToggleConnectionClicked();'>连接服务器</button><br /><br />
    <div class="alert alert-success " style="overflow:auto;height: 200px" id="top">
    </div>
    <div class="alert">
        <input id="content"  style="border:0;outline:none;">
        <button id='send' type="button" onclick='chat();'>发送</button>
    </div>
    <button id='ToggleConnection' type="button" onclick='seestate();'>查看状态</button><br /><br />
