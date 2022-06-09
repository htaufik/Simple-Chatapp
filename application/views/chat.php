<!DOCTYPE html>
<html lang="en">
<head>
    <title>Simple Chat Application</title>
    <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/7.1/pusher.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12 m-2">
            <div id="msg">
            <?php foreach($chat as $list){
                echo "<p>
                <span><b>$list->user</b></span> -
                <span>$list->message</span>
                </p>";
            }
            ?>
            </div>
            <div class="form-group">
                <input type="text" name="user" id="user" class="form-control" placeholder="Your name...">
            </div>
            <div class="form-group">
                <input type="text" name="message" id="message" class="form-control" placeholder="Your message...">
            </div>
            <div class="form-group">
                <input type="button" value="Send" class="btn btn-primary btn-block" onclick="store();">
            </div>
        </div>
    </div>
</div>

<script>
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('554aba53b4ec71b7871d', {
    cluster: 'ap1'
});

var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
//   alert(JSON.stringify(data));
addData(data);
});

function addData(data){
    var str = '';
    for(var z in data){
        str += '<p><span><b>'+data[ z ].user+'</b></span> - <span>'+data[ z ].message+'</span>';
    }
    $('#msg').html(str);
}

</script>

<script>
    function store(){
        var value = {
            user: $('#user').val(),
            message: $('#message').val()
        }
        $.ajax({
            url: '<?=site_url();?>/chat/store',
            type: 'POST',
            data: value,
            dataType: 'JSON'
        });
    }
</script>

</body>
</html>