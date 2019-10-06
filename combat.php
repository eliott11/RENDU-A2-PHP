<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0

## CONNECTEZ VOUS A VOTRE BASE DE DONNEE
$pdo = new PDO('mysql:host=127.0.0.1;dbname=rendu_php', "root", "");
## ETAPE 1

## POUVOIR SELECTIONER UN PERSONNE DANS LE PREMIER SELECTEUR

## ETAPE 2

## POUVOIR SELECTIONER UN PERSONNE DANS LE DEUXIEME SELECTEUR

## ETAPE 3

## LORSQUE LON APPPUIE SUR LE BOUTON FIGHT, RETIRER LES PV DE CHAQUE PERSONNAGE PAR RAPPORT A LATK DU PERSONNAGE QUIL COMBAT

## ETAPE 4

## UNE FOIS LE COMBAT LANCER (QUAND ON APPPUIE SUR LE BTN FIGHT) AFFICHER en dessous du formulaire
# pour le premier perso PERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)
# pour le second persoPERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)

## ETAPE 5

## N'AFFICHER DANS LES SELECTEUR QUE LES PERSONNAGES QUI ONT PLUS DE 10 PV


?>

<?php
$select_personnages = $pdo->prepare('SELECT * FROM personnages WHERE pv>10');
$select_personnages->execute();
$personnages = $select_personnages->fetchAll(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rendu Php</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="nav mb-3">
    <a href="./rendu.php" class="nav-link">Acceuil</a>
    <a href="./personnage.php" class="nav-link">Mes Champions</a>
    <a href="./combat.php" class="nav-link">Combats</a>
</nav>

<h1>Combats</h1>
<div class="w-100 mt-5">

    <form method="POST">
        <div class="form-group">
            <select name="personnage_1" id="personnage_1">
            <option value="" selected disabled >Sélection du champion :</option>

                <?php foreach($personnages as $key => $value): ?>
                    <option value="<?php echo $value->name?>"><?php echo $value->name?></option>
                <?php endforeach; ?>

            </select>
        </div>
        <div class="form-group">
            <select name="personnage_2" id="personnage_2">
            <option value="" selected disabled >Choisissez un adversaire</option>

                <?php foreach($personnages as $key => $value): ?>
                    <option value="<?php echo $value->name?>"><?php echo $value->name?></option>
                <?php endforeach; ?>

            </select>
        </div>

        <button class="btn">Fight</button>
        <br>
        <br>
    </form>

</div>

<?php
if (!empty($_POST["personnage_1"])&&!empty($_POST["personnage_2"])) {

$personnage_1 = $_POST["personnage_1"];
$personnage_2 = $_POST["personnage_2"];

$select_persos_form = $pdo->prepare('SELECT * FROM personnages WHERE name IN("'.$personnage_1.'","'.$personnage_2.'")');
$select_persos_form->execute();
$combattants = $select_persos_form->fetchAll(PDO::FETCH_OBJ);

$atk_perso_1 = $combattants[0]->atk;
$atk_perso_2 = $combattants[1]->atk;

$pv_perso_1 = $combattants[0]->pv;
$pv_perso_2 = $combattants[1]->pv;

while($pv_perso_1>0 && $pv_perso_2>0 ) {
    $pv_perso_1=$pv_perso_1-$atk_perso_2;
    echo "Le champion " . $personnage_1 . " perd " . $atk_perso_2 . " PV" . "<br>";
    $pv_perso_2= $pv_perso_2-$atk_perso_1;
    echo "Le champion " . $personnage_2 . " perd " . $atk_perso_1 . " PV" . "<br>";
    }
    if($pv_perso_1>0 && $pv_perso_2<=0){
        echo "Le champion " . $personnage_1 . " a vaincu le champion " . $personnage_2 . "<br>";
    }
    elseif($pv_perso_2>0 && $pv_perso_1<=0){
        echo "Le champion " . $personnage_2 . " a vaincu le champion " . $personnage_1 . "<br>";
    }
    elseif($pv_perso_2<=0 && $pv_perso_1<=0){
        echo "Le champion " . $personnage_1 . " et le champion " . $personnage_2 . " sont éliminés " . "<br>";
    }
}



?>

</body>
</html>
