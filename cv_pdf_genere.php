<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">


    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">


    <title>Mon_CV</title>

    <style>
        h1{
            color: #02717A;
            font-family: Arial, "Helvetica Neue", sans-serif;

        }
        .wrapper {
            width: 680px;
            margin: 0 auto;


        }
        .formation{
            padding-left: 20px;
            padding-right: 20px;
            color: white;
            background-color: #02717A;
            border-radius: 15px;
        }
        .projet{
            background-color: #09565e;
            border-radius: 15px;
            padding-left: 10px;
            padding-right: 10px;

        }
        .date_projet{
            color: #CCCCCC;
        }

        .date{
            color: #CCCCCC;
        }

        .leftcolomn {
            margin-right: 200px;
            width: 400px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .rightcolomn {
            float : right;

            border: 2px solid black;
            width: 150px;

        }


        img {
            display: block; /* Évite les marges indésirables sous l'image */
            max-width: 100%; /* Assure que l'image ne dépasse pas sa colonne */
            height: auto; /* Garde le ratio de l'image */
        }
    </style>

</head>
<body>
    <div class="wrapper">
        <div class="rightcolomn">
            <?php
            $pathphoto = $_SESSION['photo'];
            $type = pathinfo($pathphoto, PATHINFO_EXTENSION);
            $data = file_get_contents($pathphoto);
            $base64 = 'data:images/' . $type . ';base64,' . base64_encode($data);
            ?>



            <img src= '<?php echo $base64?>' alt="image de profil" style="width: 150px; height: 150px;">
        </div><br>

        <div class="leftcolomn">
            <h1><b><?php echo $_SESSION['nom'].' '.$_SESSION['prenom']?></b></h1>
            <br>
            <p><?php echo $_SESSION['bio']?></p>
            ___________________________________________________________
            <h4><b>Coordonnées</b> </h4>
            <h6>Email :<?php echo $_SESSION['email']?></h6>
            ___________________________________________________________
            <h4><b>Formations</b> </h4>

            <?php

            $recherche_formation = "SELECT * FROM formation WHERE identifiant_utilisateur = ".$_SESSION['identifiant_utilisateur']." ORDER BY date_debut DESC";

            $result_recherche_formation = mysqli_query($conn, $recherche_formation);

            while ($data = mysqli_fetch_assoc($result_recherche_formation)) {
            ?>
                <div class = "formation">
                    <table>
                        <tr><h4><b><?php echo $data['nom']?></b></h4></tr>

                        <?php
                        $date_de_debut_formation = date("F Y", strtotime($data['date_debut']));
                        if (date("Y", strtotime($data['date_fin']))=='-0001'){
                        echo'<h6 class="date"><i>Depuis '.$date_de_debut_formation.'</i></h6>';
                        }else{
                        $date_de_fin_formation = date("F Y", strtotime($data['date_fin']));
                        echo'<h6 class="date"><i>De '.$date_de_debut_formation.' à '.$date_de_fin_formation.'</i></h6>';
                        }
                        ?>

                        <p><?php echo $data['description']?></p>

                        <?php

                        $formation = $data['identifiant_formation'];

                        $recherche_projet = "SELECT * FROM projet WHERE identifiant_formation = $formation ORDER BY date DESC";
                        $result_recherche_projet = mysqli_query($conn, $recherche_projet);

                        while($data2 = mysqli_fetch_assoc($result_recherche_projet)) {

                            echo'<div class = "projet">';

                            echo'<h6><u>Projet : '.$data2['nom'].'</u></h6>';

                            $date_projet = explode('-', $data2['date']);
                            $annee_projet = $date_projet[0];
                            $mois_projet = $date_projet[1];

                            if ($date_projet[0] == "0000"){
                                echo'<h6 class="date_projet"> </h6>';
                            }
                            else {
                                if($date_projet[1]== "00"){
                                    echo'<h6 class="date_projet"><i>En '.$date_projet[0].'</i></h6>';
                                }
                                else{
                                    $date_de_projet_normal = date("F Y", strtotime($data2['date']));
                                    echo'<h6 class="date_projet"><i>'.$date_de_projet_normal.'</i></h6>';
                                }
                            }
                            echo'<p>'.$data2['description'].'</p>';
                            echo'</div>';
                        }
                        ?>


                    </table>

                </div><br>
                <?php

            }
            ?>

            ___________________________________________________________<br>
            <p>© 2024 ECE In</p>


        </div>


    </div>







</body>
</html>

