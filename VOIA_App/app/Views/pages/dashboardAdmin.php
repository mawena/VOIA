<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Css/dashboard.css">
    <title> VOIA </title>

    <style>
        .waiting-user {
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
            border: 1px solid black;
        }

        #commerciaux-list,
        #commerciaux{
            display: none;
        } 
        
        #commerciaux-list {
            display: none;
            width: 90%;
            margin-left: 10%;
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
        
        footer#footer{
            display:none;
        }
    </style>
</head>

<body>
    <div id='dashboard'>
        <div id="left-side">
            <li class="activeD"> <i class="fas fa-handshake"></i> <span> Liste d'attente</span> </li>
            <li style="display: flex;flex-direction:row;justify-content:space-between;align-items:center"><span><i class="fas fa-users"></i> Commerciaux </span> <i class="fas fa-chevron-circle-right"></i> </li>
            <div id="commerciaux-list">
                <div>
                    <div>Alan</div>
                    <div>COLES</div>
                </div>
            </div>
        </div>
        <div id="right-side">
            <div id="waiting" >
                <h3>Liste des utilisateurs en attente</h3>
                <div>
                    <?php
                    if (isset($usersWaitingArray) && !empty($usersWaitingArray)) {
                        foreach ($usersWaitingArray as $user) {
                    ?>
                            <div class="card card-body bg-dark waiting-user">
                                <div>
                                    <?php echo ("<div >" . $user["first_name"] . ' ' . $user["last_name"] . "</div>"); ?>
                                    <?php echo ("<div hidden >" . $user["token"] . "</div>"); ?>
                                    <?php echo ("<div >" . $user["email"] . "</div>"); ?>
                                    <?php echo ("<div >" . $user["sex"] . "</div>"); ?>
                                    <?php echo ("<div >" . $user["phoneNumber"] . "</div>"); ?>
                                    <?php echo ("<div >" . $user["whatsappNumber"] . "</div>"); ?>
                                    <?php echo ("<div >" . $user["admissionDate"] . "</div>"); ?>
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
                <h3>Commerciaux</h3>
            <div>
                
            </div>
        </div>
    </div>
</body>

<script type="module">

    
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
    $("#left-side > li:nth-child(1)").on("click", function(e) {
        show_commerciaux('off')
        show_waiting()
        $("#left-side > li:nth-child(1)").addClass("activeD")
        $("#left-side > li:nth-child(2)").removeClass("activeD")
        $("#left-side > li:nth-child(2) i:last-child()").removeClass('fa-chevron-circle-down')
        $("#left-side > li:nth-child(2) i:last-child()").addClass('fa-chevron-circle-right')
    })
    
    $("#left-side > li:nth-child(2)").on("click", function(e) {
        show_waiting('off')
        show_commerciaux()
        $("#left-side > li:nth-child(2)").addClass("activeD")
        $("#left-side > li:nth-child(1)").removeClass("activeD")
        
        $("#left-side > li:nth-child(2) i:last-child()").removeClass('fa-chevron-circle-right')
        $("#left-side > li:nth-child(2) i:last-child()").addClass('fa-chevron-circle-down')
    })
    $(".parain-tree-header i").on("click", function() {
        $(".parain-tree-header i").toggleClass("fa fa-plus")
        $(".parain-tree-header i").toggleClass("fa fa-minus")
        $("#parain-tree-list").slideToggle(1000)
        $("#parain-tree-list").css({
            "display": "flex"
        })
    })

    $(".product-header i").on("click", function() {
        $(".product-header i").toggleClass("fa fa-plus")
        $(".product-header i").toggleClass("fa fa-minus")
        $("#product-content").slideToggle(1000)
        $("#product-content").css({
            "display": "flex"
        })
    })

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
        const element = waiting_users[index];
        element.children[1].children[0].addEventListener('click', function(e) {
            validateWaitingUser(element, element.children[0].children[1].textContent)
        })

        element.children[1].children[1].addEventListener('click', function(e) {
            deleteWaitingUser(element, element.children[0].children[1].textContent)
        })
    }
</script>

</html>