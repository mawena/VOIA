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

        #communicateurs-list,
        #communicateurs {
            display: none;
        }

        /* #commerciaux-list-box {} */

        #communicateurs-list {
            display: none;
            width: 90%;
            height: auto;
            margin-left: 10%;
            /* overflow-y: scroll; */
        }

        .communicateurs-item {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            border: 1px solid black;
            margin: 3px;
            padding: 10px;
        }

        #communicateurs-list>div:hover {
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

        #confBox {
            position: fixed;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 100000000000;
        }

        #confBox>div {
            text-align: center;
            width: 30%;
            height: auto;
            background-color: white;
            display: flex;
            color: black;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #confBox>div>* {
            padding: 20px;
        }

        #search_box {
            padding: 10px;
            margin: 10px;
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            align-items: center;
        }

        #search_box>* {
            margin: 3px;
        }

        #search_box input {
            width: 70%;
            padding: 13px;
        }

        #search_box select {
            width: 20%;
            padding: 13px;
        }

        #search_box button {
            width: 10%;
        }

        #hors-systeme {
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

            #communicateurs-list {
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

            #confBox>div {
                width: 90%;
            }

            #search_box input {
                width: 100%;
            }

            #commerciaux-list-box{
                width: 100%;
            }
        }

        * {
            scrollbar-width: thin;
        }
    </style>
</head>

<body>
    <div id='dashboard'>
        <div id="left-side">
            <a href="#waiting">
                <li class="activeD"> <i class="fas fa-handshake"></i> <span> Liste d'attente <?php echo "<div class='badge badge-primary'>" . (!empty($userWaitingArray) ? count($userWaitingArray) : 0) . "</div>" ?></span> </li>
            </a>
            <a href="#valides">
                <li> <i class="fas fa-check"></i> <span> Validés <?php echo "<div class='badge badge-primary'>" . (!empty($validateUserArray) ? count($validateUserArray) : 0) . "</div>" ?></span> </li>
            </a>
            <a href="#hors-systeme">
                <li> <i class="fas fa-times"></i> <span> Hors Système <?php echo "<div class='badge badge-primary'>0</div>" ?></span> </li>
            </a>
            <div id="commerciaux-list-box">
                <a href="#communicateurs">
                    <li style="display: flex;flex-direction:row;justify-content:space-between;align-items:center"><span><i class="fas fa-users"></i> Communicateurs <?php echo "<div class='badge badge-primary'>" . (!empty($communicateurUserArray) ? count($communicateurUserArray) : 0) . "</div>" ?> </span> <i title="Dérouler/Enrouler" style="font-size : 20px" class="fas fa-chevron-circle-right"></i> </li>
                </a>

                <div id="communicateurs-list">
                    <?php

                    use App\Libraries\Helper;

                    if (isset($communicateurUserArray) && !empty($communicateurUserArray)) {
                        foreach ($communicateurUserArray as $key) {
                            if (strtolower($key['first_name']) != "voia") {
                    ?>
                                <div class="communicateurs-item">
                                    <div style="cursor:pointer;">
                                        <?php echo "<div hidden >" . $key['token'] . "</div>" ?>
                                        <?php echo "<div>" . $key['last_name'] . "</div>" ?>
                                        <?php echo "<div>" . $key['first_name'] . "</div>" ?>
                                    </div>
                                    <div style="font-size : 14px; font-weight : bold; cursor:pointer;">
                                        &times;
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>

        </div>
        <div id="right-side">
            <div id="search_box">
                <select class="form-control" name="filter" id="filter">
                    <option value="0">Nom</option>
                    <option value="0">Prenoms</option>
                    <option value="0">Pays</option>
                    <option value="0">Type</option>
                </select>
                <input class="form-control" type="text" placeholder="Recherche">
                <button type="button" class="btn btn-primary"> <i class="fa fa-search"></i> </button>
            </div>
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
                                    <?php echo ("<div >Pays : " . $userwaiting["country"] . "</div>"); ?>
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

            <div id="hors-systeme">
                <h3>Hors système</h3>
            </div>

            <div id="communicateurs">
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
                        <h4>Filleuls</h4>
                        <div class="communicateur-fileul-list">

                        </div>
                    </div>
                </div>
            </div>

            <div id="valides">
                <h3>Liste des utilisateurs validés </h3>
                <div>
                    <?php
                    if (isset($validateUserArray) && !empty($validateUserArray))
                        foreach ($validateUserArray as $user) {
                    ?>
                        <div class="card card-body bg-dark user">
                            <div>
                                <?php echo "<div hidden >" . $user['token'] . "</div>" ?>
                                <?php echo "<div> Nom : " . $user['last_name'] . "</div>" ?>
                                <?php echo "<div> Prenom : " . $user['first_name'] . "</div>" ?>
                                <?php echo "<div> Sexe : " . $user['sex'] . "</div>" ?>
                                <?php echo "<div> Package : " . $user["package"]['designation'] . "</div>" ?>
                                <?php echo "<div> Email : " . $user['email'] . "</div>" ?>
                                <?php echo ("<div >Tel : " . $user["phoneNumber"] . "</div>"); ?>
                                <?php echo ("<div >Whatsapp : " . $user["whatsappNumber"] . "</div>"); ?>
                                <?php echo ("<div >Pays : " . $user["country"] . "</div>"); ?>
                                <?php echo ("<div >" . $user["package"]["designation"] . "</div>"); ?>
                                <?php echo ("<div >Parrain : " . $user["parrain"]["last_name"] . ' ' . $user["parrain"]["first_name"] . "</div>"); ?>
                            </div>
                            <div>
                                <button title="Supprimer"> &times; </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

</body>
<div id="confBox">
    <div>
        <div>
            Voulez-vous vraiment réaliser cette action ?
        </div>

        <div style="display: flex; flex-direction:row; justify-content:space-around;width:60%">
            <button type="button" class="btn btn-primary ok ">Continuer</button>
            <button type="button" class="btn btn-danger cancel ">Annuler</button>
        </div>
    </div>
</div>

<script type="module">
    $("#confBox button.cancel").on("click", function(e) {
        $("#confBox").fadeOut()
    })

    //-------------------------   LES FONCTIONS DE CHANGEMENT DE PAGE

    function show_waiting(params = 'on') {
        if (params == "on") {
            $("#waiting").css({
                "display": "block"
            })
            $("#communicateurs-list").hide()
        } else if (params == "off") {
            $("#waiting").css({
                "display": "none"
            })
        }
    }

    function show_communicateurs(params = 'on') {
        if (params == "on") {
            $("#communicateurs").css({
                "display": "block"
            })
            $("#communicateurs-list").slideToggle()
        } else if (params == "off") {
            $("#communicateurs").css({
                "display": "none"
            })
        }
    }

    function show_valides(params = 'on') {
        if (params == "on") {
            $("#valides").css({
                "display": "block"
            })
            $("#communicateurs-list").hide()
        } else if (params == "off") {
            $("#valides").css({
                "display": "none"
            })
        }
    }

    // ------------------ lES handles des boutons servant à changer les pages -------

    let changePage = () => {

        switch (window.location.hash) {
            case '#waiting':
                show_communicateurs('off')
                show_waiting()
                show_valides("off")

                $("#left-side a li").removeClass("activeD")
                $("#left-side > a:nth-child(1) li").addClass("activeD")

                $("#commerciaux-list-box i:last-child()").addClass('fa-chevron-circle-right')
                $("#commerciaux-list-box i:last-child()").removeClass('fa-chevron-circle-down')
                break;

            case "#valides":
                show_waiting('off')
                show_communicateurs('off')
                show_valides()

                $("#left-side a li").removeClass("activeD")
                $("#left-side > a:nth-child(2)  li").addClass("activeD")

                $("#commerciaux-list-box i:last-child()").addClass('fa-chevron-circle-right')
                $("#commerciaux-list-box i:last-child()").removeClass('fa-chevron-circle-down')
                break

            case "#communicateurs":
                show_waiting('off')
                show_communicateurs()
                show_valides("off")

                $("#left-side > a  li").removeClass("activeD")
                $("#left-side > div  li").addClass("activeD")

                $("#commerciaux-list-box i:last-child()").toggleClass('fa-chevron-circle-right')
                $("#commerciaux-list-box i:last-child()").toggleClass('fa-chevron-circle-down')
                break

            default:
                break;
        }
    }

    changePage()
    window.addEventListener("hashchange", function(e) {
        changePage()
    })

    $(" a > li > i").on("click", function(e) {
        $("#communicateurs-list").slideToggle()
        $("#commerciaux-list-box i:last-child()").toggleClass('fa-chevron-circle-right')
        $("#commerciaux-list-box i:last-child()").toggleClass('fa-chevron-circle-down')
    })

    //  fonction de suppression des elements en liste d'attente

    let deleteWaitingUser = (node, token) => {

        $.ajax({
            url: "/apis/userswaiting/delete/" + token,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data)
                if (data.status == "success") {
                    $(node).remove()
                    window.location.reload()
                }
            },
            error: function(data) {
                alert("Erreur ! Veuillez réessayer plus tard")
                console.log(data)
            }
        })
    }
    // Function de validation des elements en liste d'attente

    let validateWaitingUser = (node, token) => {
        $.ajax({
            url: "/apis/userswaiting/validate/" + token,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data) {
                // console.log(data)
                if (data.status == "success") {
                    $(node).remove()
                    window.location.reload()
                }
            },
            error: function(data) {
                alert("Erreur ! Veuillez réessayer plus tard")
                // console.log(data)
            }
        })
    }

    let waiting_users = document.getElementsByClassName('waiting-user')

    for (let index = 0; index < waiting_users.length; index++) {
        if (waiting_users.length > 0) {
            const element = waiting_users[index];
            element.children[1].children[0].addEventListener('click', function(e) {
                $('#confBox').fadeIn()
                $('#confBox').css({
                    "display": "flex"
                })
                $("#confBox .ok").on("click", function(e) {
                    validateWaitingUser(element, element.children[0].children[1].textContent)
                    $('#confBox').fadeOut()
                })
            })
            element.children[1].children[1].addEventListener('click', function(e) {
                $('#confBox').fadeIn()
                $('#confBox').css({
                    "display": "flex"
                })
                $("#confBox .ok").on("click", function(e) {
                    deleteWaitingUser(element, element.children[0].children[1].textContent)
                    $('#confBox').fadeOut()
                })
            })
        }
    }

    // -------------------------------------------------------------

    let delete_user = (node, token) => {

        $.ajax({
            url: "/apis/users/delete/" + token,
            type: "GET",
            contentType: false,
            processData: false,
            success: function(data) {
                // console.log(data)
                if (data.status == "success") {
                    $(node).remove()
                    window.location.reload()
                } else if (data.status == "failed") {
                    alert(data.message)
                }
            },
            error: function(data) {
                console.log(data.status)
                // alert("erreur")
                alert("Erreur ! Veuillez réessayer plus tard")

            }
        })
    }
    let validate_users = document.querySelectorAll(".user")
    for (let index = 0; index < validate_users.length; index++) {
        if (validate_users.length > 0) {
            const element = validate_users[index];
            element.children[1].children[0].addEventListener('click', function(e) {
                // console.log(element.children[0].children[0].textContent)
                $('#confBox').fadeIn()
                $('#confBox').css({
                    "display": "flex"
                })
                $("#confBox .ok").on("click", function(e) {
                    delete_user(element, element.children[0].children[0].textContent)

                    $('#confBox').fadeOut()
                })
            })
        }
    }

    // ----------------------------------------------------------------------

    let communicateurs = document.querySelectorAll("#communicateurs-list > div")

    $('.communicateur-perso-detail').html('')
    let show_communicateur_detail = (token) => {

        if (token !== null) {
            $.ajax({
                url: "/apis/users/get/" + token,
                type: "GET",
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status != "failed") {
                        // remplir les infos sur le communicateur  
                        let communicateur_detail = "<div>Nom & prénoms : " + data.first_name + " " + data.last_name + "</div><div>Email : " + data.email + "</div><div>Sexe : " + data.sex + "</div><div> Numero Whatsapp : " + data.whatsappNumber + "</div><div>Pays : " + data.country + "</div>"
                        $('.communicateur-perso-detail').html(communicateur_detail)
                        $.ajax({
                            url: "/apis/users/godFather/godDauhters/" + token,
                            type: "GET",
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                $("#communicateur-detail").fadeIn()
                                // console.log(data)

                                if (data.status != "failed") {
                                    // remplir les infos sur les fileuls
                                    let fileuls1 = ''
                                    let fileuls2 = ''
                                    let fileuls1_length = 0
                                    let fileuls2_length = 0

                                    if (data["niveau-1"]) {
                                        fileuls1_length = data["niveau-1"].length
                                        for (let index = 0; index < data["niveau-1"].length; index++) {
                                            let element = data["niveau-1"][index];
                                            let fileul = "<div class=\"communicateur-fileul-detail card card-body bg-dark \"><div>" + element.first_name + " " + element.last_name + "</div><div style='text-transform : uppercase;' >" + element.type + "</div><div> " + element.email + " </div><div> " + element.phoneNumber + " </div><div> " + element.sex + " </div><div> " + element.country + " </div></div>"
                                            fileuls1 += fileul
                                        }
                                    }

                                    if (data['niveau-2']) {
                                        fileuls2_length = data["niveau-2"].length

                                        for (let index = 0; index < data["niveau-2"].length; index++) {
                                            let element = data["niveau-2"][index];
                                            let fileul = "<div class=\"communicateur-fileul-detail card card-body bg-dark \"><div>" + element.first_name + " " + element.last_name + "</div><div style='text-transform : uppercase;' >" + element.type + "</div><div> " + element.email + " </div><div> " + element.phoneNumber + " </div><div> " + element.sex + " </div><div> " + element.country + " </div></div>"
                                            fileuls2 += fileul
                                        }
                                    }
                                    // console.log(fileuls1_length)
                                    // console.log(fileuls2_length)

                                    let fil = '<h5>Package 1 <span class="badge badge-primary">' + fileuls1_length + '</span> </h5><div>' + fileuls1 + '</div><hr/><h5>Package 2 <span class="badge badge-primary">' + fileuls2_length + '</span> </h5><div>' + fileuls2 + '</div>'
                                    $(".communicateur-fileul-list").html(fil)

                                } else {
                                    $(".communicateur-fileul-list").html(data.message)
                                }
                            },
                            error: function(data) {
                                console.log(data)
                                alert("Erreur ! Veuillez réessayer plus tard")
                            }
                        })
                    } else {
                        alert(data.message)
                        // alert("Erreur ! Veuillez réessayer plus tard")
                    }
                },
                error: function(data) {
                    console.log(data)
                    alert("Erreur ! Veuillez réessayer plus tard")
                }
            })
        }
    }

    for (let index = 0; index < communicateurs.length; index++) {
        const element = communicateurs[index];
        element.children[0].addEventListener("click", function(e) {
            show_communicateur_detail(element.children[0].children[0].textContent)
        })

        element.children[1].addEventListener("click", function(e) {
            $('#confBox').fadeIn()
            $('#confBox').css({
                "display": "flex"
            })
            $("#confBox .ok").on("click", function(e) {
                delete_user(element, element.children[0].children[0].textContent)
                $('#confBox').fadeOut()
            })
        })
    }
</script>

</html>