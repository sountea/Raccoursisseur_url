

<?php




if(isset($_GET['q'])){

	// VARIABLE
	$shortcut = htmlspecialchars($_GET['q']);

	// IS A SHORTCUT ?
	$bdd = new PDO('mysql:host=localhost:3310;dbname=bitly;charset=utf8', 'root', '');
	$req =$bdd->prepare('SELECT COUNT(*) AS x FROM links WHERE shortcut = ?');
	$req->execute(array($shortcut));

	while($result = $req->fetch()){

		if($result['x'] != 1){
			header('location: index.php?error=true&message=Adresse url non connue');
			exit();
		}

	}

	// REDIRECTION
	$req = $bdd->prepare('SELECT * FROM links WHERE shortcut = ?');
	$req->execute(array($shortcut));

	while($result = $req->fetch()){

        header('location:'.$result['url']);
		exit();

	}

}



if(isset($_POST['url']) ){
$url=$_POST['url'];
echo $url;

if(!filter_var($url,FILTER_VALIDATE_URL)){
    header('location:index.php/?error=true&message=Adresse url non valide');
exit();
}

// SHORTCUT
$shortcut = crypt($url, rand());

// HAS BEEN ALREADY SEND ?
$bdd = new PDO('mysql:host=localhost:3310;dbname=bitly;charset=utf8', 'root', '');
$req = $bdd->prepare('SELECT COUNT(*) AS x FROM links WHERE url = ?');
$req->execute(array($url));

while($result = $req->fetch()){

    if($result['x'] != 0){
        header('location:index.php/?error=true&message=Adresse déjà raccourcie');
        exit();
    }

}

// SENDING
$req = $bdd->prepare('INSERT INTO links(url, shortcut) VALUES(?, ?)');
$req->execute(array($url, $shortcut));

header('location:index.php/?short='.$shortcut);
exit();
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0"/>
    <link rel="stylesheet" href="design/design.css" />
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="pictures/favico.png">


    <title>Document</title>
</head>
<body>
    <section id="hello">

        <div class="container">
                            <header id="logo"><img class="image" alt="logo" src="pictures/logo.png"></header>
                        
                            <h1 class="text-center text-4xl text-white titre1">UNE URL LONGUE ? RACCOURCISSEZ-LÂ</h1>
                            <h2 class="text-center mb-6 text-white titre2">Largement meilleur et plus court que les autres</h2>
                            
                            <form method="post" action="index.php" class="mt-5">
                            <input type="url" class="champ" name="url" placeholder="Collez un lien à raccourcir">
                            <button type="submit" id="button" class="font-bold">RACCOURCIR</button>
                        
                            </form>
                            <?php
                            if(isset($_GET['error'] )&& isset($_GET['message'])) { ?>
                            <div class="center">
                                <div id="result">
                                    <b><?php echo htmlspecialchars($_GET['message'])?></b>
                                </div>
                            </div>


                            <?php } else if(isset($_GET['short'])) { ?>
                                    <div class="center">
                                        <div id="result">
                                            <b>URL RACCOURCIE : </b>
                                            http://localhost/raccoursisseur_url/?q=<?php echo htmlspecialchars($_GET['short']); ?>
                                        </div>
                                    </div>
                                <?php } ?>



        </div>
    </section>
    <section id="marques" class="bg-blue-100">

        <div class="container2 ">
        

                <h1 class="text-center text-xl p-3 titre3 ">CES MARQUES NOUS FONT CONFIANCE</h1>
                <div class="flex space-x-6 marque ">
                <img class="societe" alt="1" src="pictures/1.png">
                <img class="societe" alt="2" src="pictures/2.png">
                <img class="societe" alt="3" src="pictures/3.png">
                <img class="societe" alt="4" src="pictures/4.png">
                </div>


        </div>
    </section>


    <footer class="text-center">
    

    <img id="logos" src="pictures/logo2.png" class="m-auto pt-1">
    <br> 2018 bitly<br>
        
            <a href="" class="">Contact</a>.
            <a href="" class="">À propos</a>

    

    </footer>


    
</body>
</html>
<style>
#result {
	color: white;
	margin: 20px;
	padding: 30px;
	border: 1px solid white;
	border-radius: 10px;
	display: inline-block;
}



.center {
	text-align: center;
}
#hello{
  
    height:500px;
    background-color:blue;
    background-repeat: no-repeat;
    background-size: cover;
}

body{
    margin:0;
    box-sizing:border-box;
    min-width: 100vh;
 
    padding:0;
    background-color:white;
}
html {
   margin: 0px;
 
}


footer #logos{
    height: 35px;
}

.container{
    width:1100px;
   
    margin: 0 auto;
}



.champ{
    width: 50%;
    
    margin-right: 10px;
    padding: 17px 30px;
    border-radius: 3px;
    border: none;
}
.image{
    
    height:50px;
  
}
.container2{
    width:500px;
    margin:0 auto
}
.societe{
   
        height:40px;
      
  
}
#marques{
 
    height:150px; 
}
#button {
    background-color: coral;
    color:white;
    border-radius: 3px;
    padding: 17px 30px;
    border: none;
}
#hello form{
   text-align: center;
}
#logo{
    padding:30px
}
@media screen and (max-width: 640px) {
    #hello{
  
    height:600px;
    background-color:blue;
    background-repeat: no-repeat;
    background-size: cover;
}
.container{
    width:500px;
   
    margin: 0 auto;
}
.titre1{
    font-size:35px;
}
.titre2{
    font-size:19px;
}
.titre3{
    font-size:26px
}
#marques{
 
 height:350px; 
}
.marque{
    margin-top:100px;
}
}
@media screen and (max-width: 587px) {
    .container{
    width:400px;
   
    margin: 0 auto;
    
}
.container2{
    width:400px;
    margin:0 auto
}
.societe{
   
   height:30px;
 

}
}
 






</style>