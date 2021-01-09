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

        #communicateur-detail {
            display: none;
        }

        .communicateur-perso-detail {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            color: white;
            font-weight: bold;
            box-shadow: 0px 0px 3px black;
            font-size: 13px;
        }

        .communicateur-perso-detail>* {
            width: 30%;
            padding: 5px;
            text-align: center;
        }

        .communicateur-fileul-detail {
            margin: 5px;
            color: white;
            display: flex;
            flex-direction: column;
            width: 70%;
        }

        footer#footer {
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

            .communicateur-perso-detail {
                display: flex;
                flex-direction: column;
                flex-wrap: wrap;
                font-size: 13px;
                align-items: center;
            }

            .communicateur-perso-detail>* {
                padding: 5px;
                width: 100%;
            }

            .communicateur-fileul-detail {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div id='dashboard'>
        <div id="left-side">
            <li class="activeD"> <i class="fas fa-handshake"></i> <span> Liste d'attente <?php echo "<div class='badge badge-primary'>" . count($userWaitingArray) . "</div>" ?></span> </li>
            <li> <i class="fas fa-check"></i> <span> Validés <?php echo "<div class='badge badge-primary'>" . count($validateUserArray) . "</div>" ?></span> </li>
            <li style="display: flex;flex-direction:row;justify-content:space-between;align-items:center"><span><i class="fas fa-users"></i> Communicateurs <?php echo "<div class='badge badge-primary'>" . count($communicateurUserArray) . "</div>" ?> </span> <i class="fas fa-chevron-circle-right"></i> </li>

            <div id="commerciaux-list">
                <?php

                use App\Libraries\Helper;

                #var_dump($communicateurUserArray);

                if (isset($communicateurUserArray) && !empty($communicateurUserArray)) {
                    foreach ($communicateurUserArray as $key) {
                        //var_dump($key);

                ?>
                        <div class="commerciaux-item">
                            <?php echo "<div hidden >" . $key['token'] . "</div>" ?>
                            <?php echo "<div>" . $key['last_name'] . "</div>" ?>
                            <?php echo "<div>" . $key['first_name'] . "</div>" ?>
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
                            // var_dump($userwaiting);
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
                                    <?php echo ("<div > Parrain : " . $userwaiting["parrain"]["last_name"] . " " . $userwaiting["parrain"]["first_name"] . "</div>"); ?>
                                    <?php
                                    if ($userwaiting["slugPackage"] == "niveau-2") {
                                        echo ("<div > Package : 2</div>");
                                    } else if ($userwaiting["slugPackage"] == "niveau-1") {
                                        echo ("<div > Package : 1</div>");
                                    }
                                    ?>
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
                    <h3>Communicateurs</h3>
                    <a href="<?php echo Helper::getBaseUrl(); ?>/inscription/02047r01212/niveau-2" target="_blank" rel="noopener noreferrer">
                        <i title="Ajouter un communicateur" style="border-radius:50%;font-size:20px; color:white;background-color:#1d75bd;height:40px;width:40px;padding: 10px;text-align:center" class="fa fa-plus"> </i>
                    </a>
                </div>

                <div id="communicateur-detail">
                    <div class="communicateur-perso-detail card card-body bg-dark "></div>
                    <hr>
                    <div>
                        <h5>Filleuls <span class="badge badge-primary" >0</span> </h5>
                        <div class="communicateur-fileul-list">
                        </div>
                    </div>
                </div>
            </div>

            <div id="valides">
                <h3>Liste des comptes validés</h3>
                <div>
                    <?php
                    if (isset($validateUserArray) && !empty($validateUserArray))
                        foreach ($validateUserArray as $user) {
                            // var_dump($user);
                    ?>
                        <div class="card card-body bg-dark user">
                            <div>
                                <?php echo "<div hidden >" . $user['token'] . "</div>" ?>
                                <?php echo "<div> Nom : " . $user['last_name'] . "</div>" ?>
                                <?php echo "<div> Prenom : " . $user['first_name'] . "</div>" ?>
                                <?php echo "<div> Package : " . $user["package"]['designation'] . "</div>" ?>
                                <?php echo "<div> Email : " . $user['email'] . "</div>" ?>
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
                //console.log(data)
                if(data.status == "success"){
                    $(node).remove()
                }
            },
            error: function(data) {
                alert("Error ! Try again.")
                //console.log(data)
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
                //console.log(data)
                if(data.status == "success"){
                    $(node).remove()
                }
            },
            error: function(data) {
                 alert("Error ! Try again.")
                //console.log(data)
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

// -------------------------------------------------------------

    let delete_user = (node, token) =>{

        $.ajax({
            url : "/apis/users/delete/"+token,
            type: "GET",
            contentType : false,
            processData : false,
            success : function(data){
                // console.log(data)
                if(data.status == "success"){
                    $(node).remove()
                }else if(data.status == "failed"){
                    alert(data.message)
                }
            },
            error: function(data){
                console.log(data.status)
                // alert("erreur")
            }
        })
        
    }

    let validate_users = document.querySelectorAll(".user")

    for (let index = 0; index < validate_users.length; index++) {
        if(validate_users.length > 0){
            const element = validate_users[index];
            element.children[1].children[0].addEventListener('click', function(e) {
                //console.log(element.children[0].children[0].textContent)
                delete_user(element, element.children[0].children[0].textContent)
            })
        }
    }

// ----------------------------------------------------------------------

    let commerciaux = document.querySelectorAll("#commerciaux-list > div")

    $('.communicateur-perso-detail').html('')
    let show_communicateur_detail = (token)=>{

        if(token !== null){
            $.ajax({
                url : "/apis/users/get/"+token,
                type : "GET",
                processData : false,
                contentType : false,
                success : function(data){
                    if(data.status != "failed"){
                        // remplir les infos sur le communicateur

                        let communicateur_detail = "<div>Nom & prénoms : "+ data.first_name+ " "+ data.last_name +"</div><div>Email : " +data.email+ "</div><div>Sexe : "+ data.sex +"</div><div> Numero Whatsapp : "+ data.whatsappNumber +"</div><div>Pays : "+data.country+"</div>"
                        $('.communicateur-perso-detail').html(communicateur_detail)
                        $.ajax({
                            url: "/apis/users/godFather/godDauhters/"+token,
                            type : "GET",
                            processData : false,
                            contentType : false,
                            success : function(data){
                                $("#communicateur-detail").fadeIn()
                                //console.log(data)
                                if(data.status != "failed"){
                                    // remplir les infos sur les fileuls
                                    let fileuls = ''
                                    for (let index = 0; index < data.length; index++) {
                                        const element = data[index];
                                        let fileul = "<div class=\"communicateur-fileul-detail card card-body bg-dark \"><div>"+element.first_name+ " " + element.last_name +"</div><div>" + element.type + "</div><div> " +element.email+ " </div></div>"
                                        fileuls += fileul
                                    }
                                    $("#communicateur-detail h5 > span").html(data.length)
                                    $(".communicateur-fileul-list").html(fileuls)
                                }else{
                                    $(".communicateur-fileul-list").html(data.message)
                                    $("#communicateur-detail h5 > span").html(0)
                                }
                            },
                            error : function(data){
                                //console.log(data)
                                 alert("Error ! Try again.")
                            }
                        })
                    }else{
                        alert(data.message)
                    }
                },
                error : function(data){
                    //console.log(data)
                     alert("Error ! Try again.")
                }
            })
        }
    }

    for (let index = 0; index < commerciaux.length; index++) {
        const element = commerciaux[index];
        element.addEventListener("click", function(e){
            show_communicateur_detail(element.children[0].textContent)
        })
    }

</script>

</html>