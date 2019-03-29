<?php
    //initialisation
    $prenoms = $nom = $email = $telephone = $message = "";
    $prenomsError = $nomError = $emailError = $telephoneError = $messageError = "";
    $isSuccess = false;
    $emailTo = 'dorgeleskoble@gmail.com';
    $emailText = "";
    //apres submit
    if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $prenoms = verifyInput($_POST['prenoms']);
            $nom = verifyInput($_POST['nom']);
            $email = verifyInput($_POST['email']);
            $telephone = verifyInput($_POST['telephone']);
            $message = verifyInput($_POST['message']);
            $isSuccess = true;

            if(empty($prenoms))
                {
                    $prenomsError = 'Ahhhh petit faut met ton prenom ub';
                    $isSuccess = false;
                }
            else
                {
                    $emailText .= 'Prenoms : '.$prenoms."\n";
                }

            if(empty($nom))
                {
                    $nomError = 'Ahhhh petit faut met ton nom ub';
                    $isSuccess = false;
                }
            else
                {
                    $emailText .= 'Nom : '.$nom."\n";
                }
            
            
            if(!isEmail($email)) //appel : aek le var de $email
                {
                    $emailError = 'eh tu joue aek moi faut entrer mail là';
                    $isSuccess = false;
                }
            else
                {
                    $emailText .= 'Email : '.$email."\n";
                }
            

            if(!isphone($telephone))
                {
                    $telephoneError = 'seul des chiffre 0-9 et + sont autorise';
                    $isSuccess = false;
                }
            else
                {
                    $emailText .= 'Telephone : '.$telephone."\n";
                }

            if(empty($message))
                {
                    $messageError = 'Ahhhh petit faut met un peu du text ub';
                    $isSuccess = false;
                }
            else
                {
                    $emailText .= 'Message : '.$message."\n";
                }

            if ($isSuccess)
                {
                    $headers = "from: $prenoms $nom <$email>\r\nReply-To: $email";
                    mail($emailTo, 'merci pour votre message', $emailText, $headers);
                    $prenoms = $nom = $email = $telephone = $message = "";
                }
        }

            //functions
    function verifyInput($var)
        {
            $var = trim($var); // nettoie espace supplement
            $var = stripslashes($var); // nettpie tout les anti-slashe
            $var = htmlspecialchars($var); 
            return $var;
        }

    function isEmail($var) //verify email
        {
            return filter_var($var, FILTER_VALIDATE_EMAIL);
        }

    function isphone($var)
        {
            return preg_match('/^[0-9 ]*$/', $var);
        }


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="style.css" rel="stylesheet"> 
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Contactez-moi</title>
</head>
<body>
    <div class="container">
        <div class="heading">
            <div class="divider"></div>
            <h2>CONTACTEZ-MOI</h2>
            <div class="row">
                <div class="col-lg-12 col-lg-offset-1">
                    <form id="contact-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"><!--form-->
                        <div class="row">
                            <div class="col-md-6"><!--pren-->
                                <label for="prenoms">Prénom<span class="etoile"> *</span></label>
                                <input type="text" id="prenoms" name="prenoms" class="form-control" placeholder="Votre prénom" value="<?php echo $prenoms; ?>">
                                <p class="comment"><?php echo $prenomsError; ?></p>
                            </div>

                            <div class="col-md-6"><!--nom-->
                                <label for="nom">Nom<span class="etoile"> *</span></label>
                                <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom" value="<?php echo $nom; ?>">
                                <p class="comment"><?php echo $nomError; ?></p>
                            </div>

                            <div class="col-md-6"><!--email-->
                                <label for="email">Email<span class="etoile"> *</span></label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Votre email" value="<?php echo $email; ?>">
                                <p class="comment"><?php echo $emailError; ?></p>
                            </div>

                            <div class="col-md-6"><!--telephone-->
                                <label for="telephone">Téléphone</label>
                                <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="Votre telephone" value="<?php echo $telephone; ?>">
                                <p class="comment"><?php echo  $telephoneError ?></p>
                            </div>

                            <div class="col-md-12"><!--textarea-->
                                <label for="message">Message<span class="etoile"> *</span></label>
                                <textarea name="message" id="message" class="form-control" placeholder="message" rows="4"><?php echo $message; ?></textarea>
                                <p class="comment"><?php echo $messageError; ?></p>
                            </div>

                            <div class="col-md-12">
                                <p><span class="etoile"><strong>* ces information sont requises</strong></span></p>
                            </div>

                            <div class="col-md-12">
                                <input type="submit" class="button-submit" value="Envoyer">
                            </div>

                        </div>
                        <p class="success-info" style="display:<?php if($isSuccess) echo 'block'; else echo 'none';?>">Message envoyé</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap/js/jquery-3.2.1.slim.min.js"></script>
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
</body>
</html>