<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Css/dashboard.css">
    <title> VOIA </title>

    <style>
        .waiting-user,
        .user {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            color: white;
            font-weight: bold;
            margin: 5px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            border-radius: 5px;
        }

        button:hover {
            color: white;
        }

        #right-side h3 {
            font-weight: bold;
        }

        .activeD {
            border: 2px solid black;
        }

        #commerciaux-list,
        #commerciaux {
            display: none;
        }

        #commerciaux-list {
            display: none;
            width: 90%;
            margin-left: 10%;
            overflow-y: auto;
        }

        #commerciaux-list>div {
            border: 1px solid black;
            border-radius: 1px;
            margin: 3px;
            padding: 10px;
        }

        #commerciaux-list>div:hover {
            border: 1px solid white;
        }

        #valides {
            display: none;
        }

        @media all and (max-width:700px) {
            #dashboard {
                display: flex;
                flex-direction: column;
            }

            #left-side {
                display: flex;
                flex-direction: row;
                width: 100%;
                flex-wrap: wrap;
            }

            #left-side>* {
                width: 50%;
            }

            #commerciaux-list {
                width: 100%;
                margin: 0;
            }
        }

        footer#footer {
            display: none;
        }
    </style>
</head>

<body>
    <div id='dashboard'>
        <div id="left-side">
            <li class="activeD"> <i class="fas fa-handshake"></i> <span> Liste d'attente</span> </li>
            <li> <i class="fas fa-check"></i> <span> Validés </span> </li>
            <li style="display: flex;flex-direction:row;justify-content:space-between;align-items:center"><span><i class="fas fa-users"></i> Commerciaux </span> <i class="fas fa-chevron-circle-right"></i> </li>
            
            <div id="commerciaux-list">
                <?php
                use App\Libraries\Helper;
                
                #var_dump($commercialUserArray);
                
                if(isset($commercialUserArray) && !empty($commercialUserArray)){
                    foreach ($commercialUserArray as $key) {
                        var_dump($key);
                        
                ?>
                    <div>
                        <div>Alan</div>
                        <div>COLES</div>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div id="right-side">
            <div id="waiting">
                <h3>Liste des utilisateurs en attente</h3>
                <div>
                    <?php

                    if (isset($userWaitingArray) && !empty($userWaitingArray)) {
                        foreach ($userWaitingArray as $userwaiting) {
                    ?>
                            <div class="card card-body bg-dark waiting-user">
                                <div>
                                    <?php echo ("<div > Nom : " . $userwaiting["first_name"] . " " . $userwaiting['last_name'] . "</div>"); ?>
                                    <?php echo ("<div hidden >" . $userwaiting["token"] . "</div>"); ?>
                                    <?php echo ("<div >Email : " . $userwaiting["email"] . "</div>"); ?>
                                    <?php echo ("<div >Sexe : " . $userwaiting["sex"] . "</div>"); ?>
                                    <?php echo ("<div >Tel : " . $userwaiting["phoneNumber"] . "</div>"); ?>
                                    <?php echo ("<div >Whatsapp : " . $userwaiting["whatsappNumber"] . "</div>"); ?>
                                    <?php echo ("<div > Date : " . $userwaiting["admissionDate"] . "</div>"); ?>
                                     <?php 
                                        if($userwaiting["slugPackage"]=="niveau-2"){
                                            echo ("<div > Niveau : 2</div>");   
                                        }else if($userwaiting["slugPackage"]=="niveau-1"){
                                            echo ("<div > Niveau : 1</div>"); 
                                        }
                                    ?>
                                    <?php echo ("<div > Date : " . $userwaiting["admissionDate"] . "</div>"); ?>
                                </div>
                                <div>
                                    <button title="Valider"> <i class="fa fa-check"></i> </button>
                                    <button title="Supprimer"> &times; </button>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <h5>Il n'y a personne ici !</h5>
                    <?php } ?>
                </div>
            </div>
            <div id="commerciaux">
                <div style="display:flex; justify-content:space-between;align-items:center;padding:10px">
                    <h3>Commerciaux</h3>
                    <a href="<?php echo Helper::getBaseUrl(); ?>/inscription/02047r01212/niveau-2" target="_blank" rel="noopener noreferrer">
                        <i title="Ajouter un commercial" style="border-radius:50%;font-size:20px; color:white;background-color:#1d75bd;height:40px;width:40px;padding: 10px;text-align:center" class="fa fa-plus"> </i>
                    </a>
                </div>
                <div id="commercial-detail">

                </div>
            </div>

            <div id="valides">
                <h3>Liste des comptes </h3>
                <div>
                    <?php
                    if(isset($validateUserArray) && !empty($validateUserArray))
                    foreach ($validateUserArray as $user) {
                        var_dump($user);
                    ?>
                        <div class="card card-body bg-dark user">
                            <div>
                                <div>Nom : </div>
                                <div hidden></div>
                                <div>Email : </div>
                                <div>Whatsapp : </div>
                            </div>
                            <div>
                                <button title="Supprimer"> &times; </button>
                            </div>
                        </div>
                    <?php    }
                    ?>
                </div>
            </div>
        </div>
</body>

<script type="module">
    //                   LES FONCTIONS DE CHANGEMENT DE PAGE

    function show_waiting(params = 'on') {
        if (params == "on") {
            $("#waiting").css({
                "display": "block"
            })
        $("#commerciaux-list").hide()
        } else if (params == "off") {
            $("#waiting").css({
                "display": "none"
            })
        }
    }

    function show_commerciaux(params = 'on') {
        if (params == "on") {
            $("#commerciaux").css({
                "display": "block"
            })
            $("#commerciaux-list").slideToggle()
        } else if (params == "off") {
            $("#commerciaux").css({
                "display": "none"
            })
        }
    }

    function show_valides(params = 'on') {
        if (params == "on") {
            $("#valides").css({
                "display": "block"
            })
        $("#commerciaux-list").hide()
        } else if (params == "off") {
            $("#valides").css({
                "display": "none"
            })
        }
    }

    // ------------------ lES handles des boutons servant à changer les pages -------

    $("#left-side > li:nth-child(1)").on("click", function(e) {
        show_commerciaux('off')
        show_waiting()
        show_valides("off")
        $("#left-side > li").removeClass("activeD")
        $("#left-side > li:nth-child(1)").addClass("activeD")
        $("#left-side > li:nth-child(3) i:last-child()").removeClass('fa-chevron-circle-down')
        $("#left-side > li:nth-child(3) i:last-child()").addClass('fa-chevron-circle-right')
    })
    
    $("#left-side > li:nth-child(3)").on("click", function(e) {
        show_waiting('off')
        show_commerciaux()
        show_valides("off")

        $("#left-side > li").removeClass("activeD")
        $("#left-side > li:nth-child(3)").addClass("activeD")
        
        $("#left-side > li:nth-child(3) i:last-child()").toggleClass('fa-chevron-circle-right')
        $("#left-side > li:nth-child(3) i:last-child()").toggleClass('fa-chevron-circle-down')
    })

    $("#left-side > li:nth-child(2)").on("click", function(e) {
        show_waiting('off')
        show_commerciaux('off')
        show_valides()

        $("#left-side > li").removeClass("activeD")
        $("#left-side > li:nth-child(3)").addClass("activeD")
        
        $("#left-side > li:nth-child(3) i:last-child()").removeClass('fa-chevron-circle-down')
        $("#left-side > li:nth-child(3) i:last-child()").addClass('fa-chevron-circle-right')
    })


    //  fonction de suppression des elements en liste d'attente

    let deleteWaitingUser = (node, token) => {

        $.ajax({
            url: "/apis/userswaiting/delete/"+token,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data)
                if(data.status == "success"){
                    $(node).remove()
                }
            },
            error: function(data) {
                alert("erreur")
                console.log(data)
            }
        })
    }

    // Function de validation des elements en liste d'attente

    let validateWaitingUser = (node, token) => {

        $.ajax({
            url: "/apis/userswaiting/validate/"+token,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data)
                if(data.status == "success"){
                    $(node).remove()
                }
            },
            error: function(data) {
                alert("erreur")
                console.log(data)
            }
        })
    }

    let waiting_users = document.getElementsByClassName('waiting-user')

    for (let index = 0; index < waiting_users.length; index++) {
        if(waiting_users.length > 0){
            const element = waiting_users[index];
            element.children[1].children[0].addEventListener('click', function(e) {
            validateWaitingUser(element, element.children[0].children[1].textContent)
            })
            element.children[1].children[1].addEventListener('click', function(e) {
                deleteWaitingUser(element, element.children[0].children[1].textContent)
            })
        }
    }

    let commerciaux = document.querySelectorAll("#commerciaux-list > div")

    let show_commercial = (token)=>{
        if(token !== null){
            $.ajax({
                url : "",
                type : "",
                data : "",
                processData : false,
                contentType : false,
                success : function(data){

                },
                error : function(data){

                }
            })
        }
    }

    for (let index = 0; index < commerciaux.length; index++) {
        const element = commerciaux[index];
        element.addEventListener("click", function(e){
            // faire une requete qui servira a afficher les informations sur le commerciale en question à l aide du token

        })
    }

</script>

</html>