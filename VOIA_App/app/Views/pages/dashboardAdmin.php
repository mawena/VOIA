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

            #commerciaux-list-box {
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
                <li class="activeD"> <i class="fas fa-hourglass"></i> <span> Liste d'attente <?php echo "<div class='badge badge-primary'>" . (!empty($userWaitingArray) ? count($userWaitingArray) : 0) . "</div>" ?></span> </li>
            </a>
            <a href="#valides">
                <li> <i class="fas fa-check"></i> <span> Validés <?php echo "<div class='badge badge-primary'>" . (!empty($validateUserArray) ? count($validateUserArray) : 0) . "</div>" ?></span> </li>
            </a>
            <a href="#hors-systeme">
                <li> <i class="fas fa-times"></i> <span> Hors Système <?php echo "<div class='badge badge-primary'>0</div>" ?></span> </li>
            </a>
            <div id="commerciaux-list-box">
                <a href="#communicateurs">
                    <li style="display: flex;flex-direction:row;justify-content:space-between;align-items:center"><span><i class="fas fa-users"></i> Communicateurs <?php echo "<div class='badge badge-primary'>" . (!empty($communicateurUserArray) ? count($communicateurUserArray) : 0) . "</div>" ?> </span> <i title="Dérouler/Enrouler" style="font-size : 20px" class="fas fa-chevron-circle-left"></i> </li>
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
                <button id="search-button" type="button" class="btn btn-primary"> <i class="fa fa-search"></i> </button>
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

<script type="module" src="/JS/dashboardAdmin.js"></script>

<?php if (isset($_SESSION["current_page_hash"])) { ?>
    <script>
        window.location.hash = "#" + "<?php echo $_SESSION['current_page_hash']; ?>"
    </script>
<?php } else { ?>
    <script>
        window.location.hash = "#waiting"
    </script>
<?php } ?>

</html>