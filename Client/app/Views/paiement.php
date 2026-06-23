<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de paiement</title>
</head>
<h1>page de paiement</h1>
<body>
    <h2>paiement pour le voyage 
    <?php if (!empty($voyages)) : ?>
        
            <?=$voyages[0]['villeDepart']?></li>
            jusqu à
            <?=$voyages[0]['villeArrivee']?></li>
        
        <?php endif; ?>
        </h2>
        <h3>le <?=$voyages[0]['dateDepart']?>  a <?= $voyages[0]['heureDepart'] ?></h3>

        <h2>total a payer <?=$voyages[0]['frais'] ?> Ar</h2>
    
    <form action="/paiement/add" method="post">
        <label for="mode">Selectionner le mode de piement:</label>
         <br>
    <select name="mode_paiement" id="mode_paiement">
        <option value="carte">Carte Bancaire</option>
        <option value="Mvola">Mvola</option>
        <option value="orange_money">Orange Money</option>
        <option value="airtel">Airtel Money</option>
    </select>
    <br><br>
    <label for="numero">saisir le numéro de carte:</label>
    <br>
    <input type="text" name="numero_carte" id="numero_carte">
    <br><br>
    <input type="submit" value="valider paiement">
    </form>
    
</body>
</html>