<link rel="stylesheet" href="/Css/login.css">
<div>
    <form action="/inscription" method="post">
        <div class="login-box">
            <h1><?= esc($title) ?></h1>
            <div class="text-box">
                <i class="fas fa-user"></i>
                <input type="text" name="username" id="username" placeholder="username" required>
            </div>
            <div class="text-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required>
            </div>
            <div class="text-box">
                <i class="fas fa-id-card"></i>
                <input type="text" name="last-name" id="last-name" placeholder="last-name" required>
            </div>
            <div class="text-box">
                <i class="fas fa-id-card"></i>
                <input type="text" name="first-name" id="first-name" placeholder="first-name" required>
            </div>
            <div class="text-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Adresse mail" required>
            </div>
            <div class="text-box">
                <i class="fas fa-genderless" placeholder="Sexe"></i>
                <select name="sex" id="sex" placeholder="sex" required>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </div>

            <br><br>
            <div class="text-box">
                <label for="codeParainage">Inscrivez le code de vôtre parain si vous en avez, sinon ne mettez rien</label>
                <i class="fas fa-link"></i>
                <input type="text" name="codeParainage" id="codeParainage" placeholder="code de parainage (facultatif)">
            </div>
            <br>

            
            <input class="btn" type="submit" value="Inscription">
        </div>
    </form>
</div>