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

<?php
// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, "https://aigulleur.herokuapp.com/salon");

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);
$salons= JSON_DECODE($output);

?>



<div class="container">
<div class="row">
    <diV class="col-md-offset-3 col-md-6">
        <div class="panel panel-info">
            <diV class="panel-heading">
                <div class="page-header">
                    <p>
                    <h1 class="text-center">  Sign in to MyApp</h1>
                    </p>
                </div>

            </diV>
            <div class="panel-body">
                <form class="text-center form" id="form1" method="POST" >

                    <label for="text">Salons</label>
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <select name="salon" class="form-control" id="salon"  tabindex="1" required autofocus>
                            <?php
                                for($i=0;$i<count($salons);$i++){
                                ?>
                                    <option value="<?php echo $salons[$i]->title ?>"><?php echo $salons[$i]->title ?></option>
                                    <?php
                                }
                            ?>
                            </select>
                        </div>
                    </div>

                    <label for="text">Username</label>
                    <div class="row">

                        <div class="col-md-offset-3 col-md-6">
                            <input type="text" name="username" id="username" class="form-control" tabindex="2" required placeholder="username" > <br/>

                        </div>
                    </div>


                </form>

            </div>

            <div class="panel-footer">
                <button type="submit" class="btn btn-success" name="connexion"  form="form1">Connexion</button>
                <a  class="btn btn-warning  pull-right"  href="">Annuler</a>

            </div>

        </div>

    </div>
</div>


</div>



<script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        $(document).on('submit', '.form', function(e) {
            e.preventDefault();
            let salon = document.getElementById("salon").value;
            let username = document.getElementById("username").value;
            let data = {
                "username":username,
                "salon":salon
            };
            console.log(data);
            $.ajax({
                type: 'POST',
                url: 'https://aigulleur.herokuapp.com/subscribe',
                data: $(this).serialize(),
                success : function(response){
                    //$('.client').append('A message has been sent to server from this client!<br />');
                    console.log(response);
                    if(response=="good"){
                        localStorage.setItem('tchat-user', JSON.stringify(data));
                        document.location.href="discussions.php";
                    }
                },
                error : function(response){
                    console.log('Something went wrong.');
                    console.log(response);
                },
                cache: false
            });

            return false;
        });
    });
</script>
</body>
</html>
