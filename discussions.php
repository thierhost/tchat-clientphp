<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tchat </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        body
        {
            padding-top: 70px;
        //background-color:;
            line-height: 26px;
            font-family: "High Tower Text","Times New Roman", Times, serif;
            font-style: BOLD;
            font-size:20px;

        }
        .connexion
        {
            background-color:red;
        }
    </style>
</head>
<body>



<script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        let data = JSON.parse(localStorage.getItem('tchat-user'));
        if( !data || !data.salon || !data.username){
            document.location.href="index.php";
        }
        function waitForMsg(){
            $.ajax({
                type: "GET",
                url: "https://aigulleur.herokuapp.com/"+data.salon,
                async: true,
                cache: false,
                success: function(data){
                     console.log(data);
                    $(".messageliste").empty();
                    for(let i=0; i<data.length;i++){
                        $(".messageliste").append("<blockquote >"+ data[i].message+ "<br> <small class='pull-right'>"+ data[i].username+"</small> </blockquote>")
                    }
                    setTimeout(waitForMsg(),1000);
                },
                error: function(XMLHttpRequest,textStatus,errorThrown) {
                   setTimeout(waitForMsg(),15000);
                }
            });
        }

        $('#envoyer').click(function(){
            let sms = document.getElementById("sms").value;
            if(sms!=""){
                data.message= sms;
                $.ajax({
                    type: 'POST',
                    url: 'https://aigulleur.herokuapp.com/messages',
                    data: data,
                    success : function(response){
                        console.log(response);
                        if(response=="good"){
                            document.getElementById("sms").value="";
                        }
                    },
                    error : function(response){
                        console.log('Something went wrong.');
                        console.log(response);
                    },
                    cache: false
                });

            }
        });



        waitForMsg();
    });
</script>

</body>
</html>
