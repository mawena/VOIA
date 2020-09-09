<link rel="stylesheet" href="/Css/login.css">
<div>
    <form action="/inscription" method="post">
        <div class="login-box">
            <h1><?= esc($title) ?></h1>
            <div class="text-box">
                <i class="fas fa-user"></i>
                <input type="text" name="Identifiant" id="Identifiant" placeholder="Identifiant" required>
            </div>
            <div class="text-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="Password" id="Password" placeholder="Mot de passe" required>
            </div>
            <div class="text-box">
                <i class="fas fa-id-card"></i>
                <input type="text" name="Last-name" id="Nom" placeholder="Nom" required>
            </div>
            <div class="text-box">
                <i class="fas fa-id-card"></i>
                <input type="text" name="First-name" id="Prénoms" placeholder="Prénoms" required>
            </div>
            <div class="text-box">
            <i class="fas fa-envelope"></i>
            <input type="email" name="Mail" id="Mail" placeholder="Adresse mail" required>
        </div>
        <div class="text-box">
            <i class="fas fa-link"></i>
            <input type="text" name="codeParainage" id="codeParainage" placeholder="code de parainage (facultatif)">
        </div>
        <div class="text-box">
                <i class="fas fa-genderless" placeholder="Sexe"></i>
                <select name="Sex" id="Sex" placeholder="sex" required>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </div>
                <input class="btn" type="submit" value="Inscription">
        </div>
    </form>
</div>