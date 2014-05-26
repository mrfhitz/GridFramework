try{
    $('#debug_command').keypress(function(e) {
        if(e.which == 13) {
            var command = document.getElementById('debug_command');
            var log = all_commands;
            var work = false;
            var message;

            var slit = command.value.split(" ");
            switch (slit[0]) {
                case 'clear':
                    work = true;
                    log.innerHTML = "";
                break;
                case 'help':
                    work = true;
                    message = help();
                break;
                case 'status':
                    work = true;
                    message = '<p>Status: ON</p>';
                    break;
                case 'scream':
                    if(slit.length == 2){
                        work = true;
                        if(slit[1] == "on"){
                            show_hide_class('visible');
                            message = "<p>Debug messages are now visible</p>";
                        } else if(slit[1] == "off") {
                            show_hide_class('hidden');
                            message = "<p>Debug messages are now invisible</p>";
                        }else { work = false; }
                    }
                break;
                case 'info':
                    work = true;
                    message = gerPageInfo();
                break;
                case 'goto':
                    work = redirect(slit);
                    break;
                case 'plugins':
                    work = true;
                    message = getPlugins();
                    break;
            }


            if(work == false){
                log.innerHTML += '<p style="color: red;"> >' + command.value + ' <small style="color: #fff">(command not found)</small></p>';
            }else {
                log.innerHTML += '<p style="color: green;"> >' + command.value + '</p>';
            }

            if(typeof message != 'undefined' && work == true)
                log.innerHTML += message;

            command.value = "";
        }
    });

    function gerPageInfo(){
        var str = "";

        str += "<p><strong>Title: </strong> "+document.title+";</p>";
        str += "<p><strong>Description: </strong> "+document.getElementsByName('description')[0].getAttribute('content');+";</p>";
        str += "<p><strong>KeyWords: </strong> "+document.getElementsByName('keywords')[0].getAttribute('content');+";</p>";
        str += "<p><strong>Author: </strong> "+document.getElementsByName('author')[0].getAttribute('content');+";</p>";
        str += "<p><strong>Template: </strong> "+document.getElementsByName('template')[0].getAttribute('content');+".</p>";

        return str;
    }

    function getPlugins(){
        var str = "<p>" + document.getElementsByName('plugins')[0].getAttribute('content').replace(/\,/g,"  <strong>Loaded!</strong></p><p>") + "  <strong>Loaded!</strong></p>";
        return str;
        }

    function help() {
        var str = "";

        str += "<p><strong>info: </strong> Show all the info about that page (Google stuff);</p>";
        str += "<p><strong>scream on|off: </strong> Show/or dot the debug messages;</p>";
        str += "<p><strong>plugins: </strong> See all the plugins;</p>";
        str += "<p><strong>goto &lt;page_name&gt;: </strong> Go to some page by name;</p>";
        str += "<p><strong>clear: </strong> Clear the console;</p>";
        str += "<p><strong>help: </strong> show all the commands you can use.</p>";

        return str;
    }

    function show_hide_class(op){
        var cls = document.getElementsByClassName('debug_scream');

        for(i=0;i < cls.length;i++) {
            cls[i].style.visibility = op;
        }
    }

    function redirect(info){
        var work = false;
        var url = "index.php?p=";

        if(info.length == 2){
            work = true;
            url += info[1];
        }else if (info.length == 3){
            work = true;
            url += info[1] + ":" + info[2];
        }

        if(work == true)
            window.location.href = url;
        return work;
    }

    document.getElementById('debug_status').style.color = "green";
    document.getElementById('debug_status').innerHTML = "ON";

} catch(err) {
    console.log("Error: " + err + ".");
}