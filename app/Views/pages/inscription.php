<link rel="stylesheet" href="/Css/connexion.css">
<div>
    <form id="box" action="inscription" method="post">
        <h1><?= esc($title) ?></h1>
            <input type="text" name="Identifiant" id="Identifiant" placeholder="Identifiant" required>

            <input type="password" name="Password" id="Password" placeholder="Mot de passe" required>

            <input type="text" name="Last-name" id="Nom" placeholder="Nom" required>

            <input type="text" name="First-name" id="Prénoms" placeholder="Prénoms" required>

            <input type="email" name="Mail" id="Mail" placeholder="Adresse mail" required>
            
            <input type="text" name="codeParainage" id="codeParainage" placeholder="code de parainage">
            
            <select name="Sex" id="Sex" required>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
            </select>

            <input type="submit" value="Inscription">
        </form>
</div>