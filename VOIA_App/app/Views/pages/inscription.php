<link rel="stylesheet" href="/Css/login.css">
<style>
    .error {
        color: red;
        background-color: white;
    }

    .success {
        color: green;
        background-color: white;
    }

    #state {
        display: none;
        text-align: center;
        padding: 10px;
        margin: 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    #descriptif {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #descriptif h2 {
        font-weight: bold;
        margin: 10px;
    }

    #descriptif>div {
        width: 60%;
        font-weight: 14px;
        font-weight: bold;
        text-align: justify;
    }
</style>
<div>
    <form id="inscription-form">

    <div id="descriptif">
            <h2>BIENVENUE SUR VOIA</h2>
            <div>
                Véritables outils à tous faire, nos Smartphones cumulent en un seul gadget une multitude de fonctions. Cependant, l’utilisation générale que nous en faisons se résume aux réseaux sociaux, aux appels et aux contenus multimédia. Parallèlement, disposer d’un Smartphone connecté s’avère être plus que suffisant pour bénéficier de nombreuses opportunités. Pour ce faire, le programme de Vulgarisation de l’Outil Informatique en Afrique (VOIA) met à votre disposition une formation certifiante en communication digitale pour nous instruire sur cette mine d’or inexplorée qui sommeille dans nos téléphones.
                Inscrivez-vous via le formulaire ci-dessous et profitez de cette opportunité.
            </div>
        </div>
        
        <div class="login-box">
            <h3 style="text-align: center; font-weight : bold"><?= esc($title) ?></h3>
            
            <div style='color:red;margin-top:20px;margin-left:-50px;font-size:14px;' >
                <strong>*</strong> designe les champs obligatoires
            </div>
            
            <div class="text-box">
                <i class="fas fa-user"></i>
                <input type="text" name="username" id="Identifiant" placeholder="Nom d'utilisateur *" required>
            </div>
            <div class="text-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="Password" placeholder="Mot de passe *" required>
            </div>
            
            <div class="text-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="conf_password" id="ConfPassword" placeholder="Mot de passe à nouveau *" required>
            </div>
            
            <div class="text-box">
                <i class="fas fa-id-card"></i>
                <input type="text" name="last_name" id="Nom" placeholder="Nom *" required>
            </div>
            <div class="text-box">
                <i class="fas fa-id-card"></i>
                <input type="text" name="first_name" id="Prénoms" placeholder="Prénoms *" required>
            </div>
            <div class="text-box">
                <i class="fa fa-flag"></i>
                <select name="country" id="country">
                </select>
            </div>
            <div class="text-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="Mail" placeholder="Adresse mail *" required>
            </div>
            
            <div class="text-box">
                <i class="fas fa-phone"></i>
                <input type="tel" name="numero" id="numero" placeholder="Numero de telephone *" required>
            </div>
            
            <div class="text-box">
                <i class="fab fa-whatsapp"></i>
                <input type="tel" name="numero_whatsapp" id="numero_whatsapp" placeholder="Numero de telephone Whatsapp *" required>
            </div>

            <div class="text-box">
                <i class="fas fa-genderless" placeholder="Sexe"></i>
                <select name="sex" id="Sex" placeholder="sex">
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </div>
            <div id="state">

            </div>
            <input class="btn" type="submit" value="Inscription">

        </div>
    </form>
</div>

<script type="module">
   import {server_url, pays} from "/JS/config.js"

    let country_list_index =(Object.keys(pays)).sort()
    let countryFill = ""
    
    let getCodeByCountry = (object, index)=>{
        //console.log(index)
        return object[index]["phone_code"]
    }
    
    //getCodeByCountry(pays, "a b")
    
    for (let index = 0; index < country_list_index.length; index++) {
        let element = country_list_index[index]
        countryFill += "<option value=\""+pays[element]["name"]+"\">"+pays[element]["name"]+"(<span>"+pays[element]["phone_code"]+"</span>)</option>"
    }
    
    $("select#country").html(countryFill)
    
    
    
    $("#numero").val("00"+getCodeByCountry(pays, $("select#country").val()))
    $("#numero_whatsapp").val("00"+getCodeByCountry(pays, $("select#country").val()))
    // console.log(getCodeByCountry(pays, $("select#country").val()))
    $("select#country").change(function(e){
        $("#numero").val("00"+getCodeByCountry(pays, $(e.target).val()))
        $("#numero_whatsapp").val("00"+getCodeByCountry(pays, $(e.target).val()))
        console.log($(e.target).val())
    })

    let parrain = null
    $("#state").hide()
    $("input.btn").on('click', function(e) {
    let connexion_data = new FormData(document.getElementById("inscription-form"))
        
    <?php if (isset($parrainUser) && $parrainUser['token'] !== "") { ?>
        connexion_data.append("codeParainnage", "<?php echo $parrainUser['matricule']; ?>")
    <?php } else { ?>
        window.location.pathname = "/"
    <?php } ?>
    
    <?php if (isset($slugPackage) && $slugPackage !== "") { ?>
        connexion_data.append("slugPackage", "<?php echo $slugPackage; ?>")
    <?php } else { ?>
        window.location.pathname = "/"
    <?php } ?>
    
    e.preventDefault()
    
    if($("#Password").val() == "" || $("#Identifiant").val() == "" || $("#Mail").val() == "" || $("#Nom").val() == "" || $("#Prénoms").val() == "" || $("#numero_whatsapp").val() == ""  || $("#numero").val() == "" || $("#numero").val() == "00"+getCodeByCountry(pays, $("select#country").val()) || $("#numero_whatsapp").val() == "00"+getCodeByCountry(pays, $("select#country").val()) ){
        $("#state").show()
        $("#state").removeClass("success")
        $("#state").addClass("error")
        $("#state").text('Tous les champs sont obligatoires *')
    }else{
        if ($('#Password').val()!== $("#ConfPassword").val()){
            $("#state").show()
            $("#state").removeClass("success")
            $("#state").addClass("error")
            $("#state").text('Les mots de passe sont incompatibles')
        }else{
            let url = '/apis/userswaiting/store'
            let isCommercial = false
            if (window.location.pathname.split('/')[2] == "02047r01212") {
                url = '/apis/users/store'
                isCommercial = true
                connexion_data.append("type","commercial")
            }
            $.ajax({
            url: url,
            type: "POST",
            data: connexion_data,
            processData: false,
            contentType: false,
            success: function(data) {
                $("#state").hide()
                if (data.status == "success") {
                    $("#state").slideDown()
                    $("#state").removeClass("error")
                    $("#state").addClass("suuccess")
                    isCommercial ? $("#state").text("Inscription terminée! Commercial ajouté !") : $("#state").text("Inscription terminée! Le compte sera activé après confirmation du paiement des frais d'inscription !")

                } else if (data.status == "failed") {
                    $("#state").show()
                    $("#state").removeClass("success")
                    $("#state").addClass("error")
                    $("#state").text(data.message)
                }
            },
            error: function(data) {
                $("#state").show()
                $("#state").removeClass("success")
                $("#state").addClass("error")
                $("#state").text("Erreur de connexion ! Veuillez re-essayer !")
            }
        })
            
        }
    }
    
        


    })
</script>