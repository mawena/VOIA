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
        #waiting-list,
        #valides-list,
        #hors-systeme-list {
            display: none;
        }

        #communicateurs {
            display: none;
        }

        /* Box */
        #communicateurs-list,
        #waiting-list,
        #valides-list,
        #hors-systeme-list {
            display: none;
            width: 90%;
            height: auto;
            margin-left: 10%;
            /* overflow-y: scroll; */
        }

        /* liste des communicateurs */
        .communicateurs-list {
            display: none;
            width: 95%;
            margin-left: 5%;
            justify-content: space-between;
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

            #communicateurs-list,
            #waiting-list,
            #valides-list,
            #hors-systeme-list {
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

            #commerciaux-list-box,
            #waiting-list-box,
            #valides-list-box,
            #hors-systeme-list-box {
                width: 100%;
            }
        }

        * {
            scrollbar-width: thin;
        }

        #left-side>div>div>div {
            border: 1px solid black;
            margin: 3px;
            padding: 10px;
        }

        #left-side>div>div>div {
            cursor: pointer;
        }

        a>li>i {
            cursor: pointer;
        }

        #floating-button-wrapper {
            display: none;
            position: fixed;
            bottom: 15%;
            right: 5%;
            padding: 15px;
            background-color: black;
            color: white;
            z-index: 100000000000;
            cursor: pointer;
            font-size: 15px;
            transition: .1s ease-in-out;
        }

        #floating-button-wrapper:hover {
            scale: 0.9;
            transition: .1s ease-in-out;
        }
    </style>
</head>

<?php

$userWaitingArray_ComDigitale = array_filter($userWaitingArray, function ($v, $k) {
    return $v['slugPackage'] ? in_array($v['slugPackage'], ["niveau-1", "niveau-2"]) || $v['slugPackage'] == null : false;
}, ARRAY_FILTER_USE_BOTH);

$userWaitingArray_Perlage = array_filter($userWaitingArray, function ($v, $k) {
    return $v['slugPackage'] ? $v['slugPackage'] == "niveau-3" : false;
}, ARRAY_FILTER_USE_BOTH);

$userWaitingArray_Sapo = array_filter($userWaitingArray, function ($v, $k) {
    return $v['slugPackage'] ? $v['slugPackage'] == "niveau-4" : false;
}, ARRAY_FILTER_USE_BOTH);



$communicateurUserArray_ComDigitale = array_filter($communicateurUserArray, function ($v, $k) {

    if (isset($v["package"])) {
        return in_array($v["package"][0]["slug"], ["niveau-1", "niveau-2"]);
    } else {
        return true;
    }
}, ARRAY_FILTER_USE_BOTH);

$communicateurUserArray_Perlage = array_filter($communicateurUserArray, function ($v, $k) {

    if (isset($v["package"])) {
        return $v["package"][0]["slug"] == "niveau-3";
    }
}, ARRAY_FILTER_USE_BOTH);

$communicateurUserArray_Sapo = array_filter($communicateurUserArray, function ($v, $k) {

    if (isset($v["package"])) {
        return $v["package"][0]["slug"] == "niveau-4";
    }
}, ARRAY_FILTER_USE_BOTH);



$validateUserArray_ComDigitale = array_filter($validateUserArray, function ($v, $k) {

    if (isset($v["package"])) {
        return in_array($v["package"]["slug"], ["niveau-1", "niveau-2"]);
    } else {
        return true;
    }
}, ARRAY_FILTER_USE_BOTH);

$validateUserArray_Perlage = array_filter($validateUserArray, function ($v, $k) {

    if (isset($v["package"])) {
        return $v["package"]["slug"] == "niveau-3";
    }
}, ARRAY_FILTER_USE_BOTH);

$validateUserArray_Sapo = array_filter($validateUserArray, function ($v, $k) {

    if (isset($v["package"])) {
        return $v["package"]["slug"] == "niveau-4";
    }
}, ARRAY_FILTER_USE_BOTH);

?>

<!--  -->

<body>
    <div id="floating-button-wrapper">
        <i class="fa fa-chevron-up"></i>
    </div>
    <div id='dashboard'>
        <div id="left-side">
            <div id="waiting-list-box">
                <a href="#waiting">
                    <li style="display: flex;flex-direction:row;justify-content:space-between;align-items:center" class="activeD"> <span><i class="fas fa-hourglass"></i> <span> Liste d'attente <?php echo "<div class='badge badge-primary'>" . (!empty($userWaitingArray) ? count($userWaitingArray) : 0) . "</div>" ?></span></span> <i title="Dérouler/Enrouler" style="font-size : 20px" class="fas fa-chevron-circle-left"></i> </li>
                </a>

                <div id="waiting-list">
                    <div>
                        <a href="#waiting-com-digitale">COMMUNICATION DIGITALE <span class="badge badge-primary"> <?php echo count($userWaitingArray_ComDigitale); ?> </span></a>
                    </div>
                    <div>
                        <a href="#waiting-perlage">PERLAGE <span class="badge badge-primary"> <?php echo count($userWaitingArray_Perlage); ?> </span></a>
                    </div>
                    <div>
                        <a href="#waiting-sapo">SAPONNIFICATION <span class="badge badge-primary"> <?php echo count($userWaitingArray_Sapo); ?> </span></a>
                    </div>
                </div>
            </div>

            <div id="valides-list-box">
                <a href="#valides">
                    <li style="display: flex;flex-direction:row;justify-content:space-between;align-items:center"> <span><i class="fas fa-check"></i> <span> Validés <?php echo "<div class='badge badge-primary'>" . (!empty($validateUserArray) ? count($validateUserArray) : 0) . "</div>" ?></span></span> <i title="Dérouler/Enrouler" style="font-size : 20px" class="fas fa-chevron-circle-left"></i> </li>
                </a>

                <div id="valides-list">
                    <div>
                        <a href="#valides-com-digitale">COMMUNICATION DIGITALE <span class="badge badge-primary"> <?php echo count($validateUserArray_ComDigitale); ?> </span> </a>
                    </div>
                    <div>
                        <a href="#valides-perlage">PERLAGE <span class="badge badge-primary"> <?php echo count($validateUserArray_Perlage); ?> </span></a>
                    </div>
                    <div>
                        <a href="#valides-sapo">SAPONNIFICATION <span class="badge badge-primary"> <?php echo count($validateUserArray_Sapo); ?> </span> </a>
                    </div>
                </div>
            </div>

            <div id="hors-systeme-list-box">
                <a href="#hors-systeme">
                    <li style="display: flex;flex-direction:row;justify-content:space-between;align-items:center"> <span><i class="fas fa-times"></i> <span> Hors Système <?php echo "<div class='badge badge-primary'>0</div>" ?></span></span> <i title="Dérouler/Enrouler" style="font-size : 20px" class="fas fa-chevron-circle-left"></i> </li>
                </a>
                <div id="hors-systeme-list">
                    <div>
                        <a href="#hors-systeme-com-digitale">COMMUNICATION DIGITALE</a>
                    </div>
                    <div>
                        <a href="#hors-systeme-perlage">PERLAGE</a>
                    </div>
                    <div>
                        <a href="#hors-systeme-sapo">SAPONNIFICATION</a>
                    </div>
                </div>
            </div>

            <div id="commerciaux-list-box">
                <!-- TODO: Ajouter le moyen de selectionner le type de commercial que l'on veut creer -->
                <a href="#communicateurs">
                    <li style="display: flex;flex-direction:row;justify-content:space-between;align-items:center"><span><i class="fas fa-users"></i> Communicateurs <?php echo "<div class='badge badge-primary'>" . (!empty($communicateurUserArray) ? count($communicateurUserArray) : 0) . "</div>" ?> </span> <i title="Dérouler/Enrouler" style="font-size : 20px" class="fas fa-chevron-circle-left"></i> </li>
                </a>

                <div id="communicateurs-list">
                    <div>
                        <span>
                            COMMUNICATION DIGITALE
                            <span class="badge badge-primary"> <?php echo count($communicateurUserArray_ComDigitale) ?> </span>
                        </span>
                        <!-- <a href="#hors-systeme-com-digitale">COMMUNICATION DIGITALE</a> -->
                    </div>

                    <!-- Liste des commerciaux de com digitale -->
                    <div class="communicateurs-list" style="flex-direction:column; border:none">
                        <?php

                        use App\Libraries\Helper;

                        if (isset($communicateurUserArray_ComDigitale) && !empty($communicateurUserArray_ComDigitale)) {
                            foreach ($communicateurUserArray_ComDigitale as $communicateur) {
                                if (strtolower($communicateur['first_name']) != "voia") {
                        ?>
                                    <div class="communicateurs-item">
                                        <div style="cursor:pointer;">
                                            <?php echo "<div hidden >" . $communicateur['token'] . "</div>" ?>
                                            <?php echo "<div>" . $communicateur['last_name'] . "</div>" ?>
                                            <?php echo "<div>" . $communicateur['first_name'] . "</div>" ?>
                                        </div>
                                        <div style="font-size : 14px; font-weight : bold; cursor:pointer;">
                                            &times;
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <div>
                        <span>
                            PERLAGE
                            <span class="badge badge-primary"> <?php echo count($communicateurUserArray_Perlage) ?> </span>
                        </span>
                        <!-- <a href="#hors-systeme-perlage">PERLAGE</a> -->
                    </div>

                    <!-- Liste des commerciaux de perlage -->
                    <div class="communicateurs-list" style="flex-direction:column; border:none">
                        <?php

                        if (isset($communicateurUserArray_Perlage) && !empty($communicateurUserArray_Perlage)) {
                            foreach ($communicateurUserArray_Perlage as $communicateur) {
                                if (strtolower($communicateur['first_name']) != "voia") {
                        ?>
                                    <div class="communicateurs-item">
                                        <div style="cursor:pointer;">
                                            <?php echo "<div hidden >" . $communicateur['token'] . "</div>" ?>
                                            <?php echo "<div>" . $communicateur['last_name'] . "</div>" ?>
                                            <?php echo "<div>" . $communicateur['first_name'] . "</div>" ?>
                                        </div>
                                        <div style="font-size : 14px; font-weight : bold; cursor:pointer;">
                                            &times;
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <div>
                        <span>
                            SAPONNIFICATION
                            <span class="badge badge-primary"> <?php echo count($communicateurUserArray_Sapo) ?> </span>
                        </span>
                        <!-- <a href="#hors-systeme-sapo">SAPONNIFICATION</a> -->
                    </div>

                    <!-- Liste des commerciaux de sapo -->
                    <div class="communicateurs-list" style="flex-direction:column; border:none">
                        <?php

                        if (isset($communicateurUserArray_Sapo) && !empty($communicateurUserArray_Sapo)) {
                            foreach ($communicateurUserArray_Sapo as $communicateur) {
                                if (strtolower($communicateur['first_name']) != "voia") {
                        ?>
                                    <div class="communicateurs-item">
                                        <div style="cursor:pointer;">
                                            <?php echo "<div hidden >" . $communicateur['token'] . "</div>" ?>
                                            <?php echo "<div>" . $communicateur['last_name'] . "</div>" ?>
                                            <?php echo "<div>" . $communicateur['first_name'] . "</div>" ?>
                                        </div>
                                        <div style="font-size : 14px; font-weight : bold; cursor:pointer;">
                                            &times;
                                        </div>
                                    </div>
                                <?php  }
                                ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="right-side">
            <form method="POST" id="search_box">
                <a href="/admin/dashboard" style="font-size:30px; cursor:pointer" title="Reinitialiser">&times;</a>
                <select class="form-control" name="key" id="filter">
                    <option value="last_name">Nom</option>
                    <option value=first_name>Prenoms</option>
                    <option value="country">Pays</option>
                    <option value="type">Type</option>
                </select>
                <input class="form-control" name="value" type="text" placeholder="Recherche">
                <input id="page" class="form-control" name="page" type="hidden" />
                <button id="search-button" type="button" class="btn btn-primary"> <i class="fa fa-search"></i> </button>
            </form>
            <div id="waiting">
                <h3>Liste des utilisateurs en attente
                    <hr>
                </h3>

                <div id="waiting-com-digitale">
                    <h4>
                        Communication Digitale
                    </h4>

                    <?php

                    if (isset($userWaitingArray_ComDigitale) && !empty($userWaitingArray_ComDigitale)) {
                        foreach ($userWaitingArray_ComDigitale as $userwaiting) {

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
                                    } else if ($userwaiting["slugPackage"] == "niveau-3") {
                                        echo ("<div > Package : 3</div>");
                                    } else if ($userwaiting["slugPackage"] == "niveau-4") {
                                        echo ("<div > Package : 4</div>");
                                    }
                                    ?>
                                </div>
                                <div>
                                    <button title="Valider"> <i class="fa fa-check"></i> </button>
                                    <button title="Supprimer"> &times; </button>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <h5>Il n'y a personne ici !</h5>
                    <?php } ?>
                </div>

                <hr>

                <div id="waiting-perlage">
                    <h4>
                        Perlage
                    </h4>
                    <?php

                    if (isset($userWaitingArray_Perlage) && !empty($userWaitingArray_Perlage)) {
                        foreach ($userWaitingArray_Perlage as $userwaiting) {
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
                                    } else if ($userwaiting["slugPackage"] == "niveau-3") {
                                        echo ("<div > Package : 3</div>");
                                    } else if ($userwaiting["slugPackage"] == "niveau-4") {
                                        echo ("<div > Package : 4</div>");
                                    }
                                    ?>
                                </div>
                                <div>
                                    <button title="Valider"> <i class="fa fa-check"></i> </button>
                                    <button title="Supprimer"> &times; </button>
                                </div>
                            </div>
                        <?php
                        } ?>
                    <?php } else { ?>
                        <h5>Il n'y a personne ici !</h5>
                    <?php } ?>
                </div>

                <hr>

                <div id="waiting-sapo">
                    <h4>
                        Saponification
                    </h4>
                    <?php

                    if (isset($userWaitingArray_Sapo) && !empty($userWaitingArray_Sapo)) {
                        foreach ($userWaitingArray_Sapo as $userwaiting) {
                            if ($userwaiting["slugPackage"] == 'niveau-4') {
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
                                        } else if ($userwaiting["slugPackage"] == "niveau-3") {
                                            echo ("<div > Package : 3</div>");
                                        } else if ($userwaiting["slugPackage"] == "niveau-4") {
                                            echo ("<div > Package : 4</div>");
                                        }
                                        ?>
                                    </div>
                                    <div>
                                        <button title="Valider"> <i class="fa fa-check"></i> </button>
                                        <button title="Supprimer"> &times; </button>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    <?php } else { ?>
                        <h5>Il n'y a personne ici !</h5>
                    <?php } ?>
                </div>
            </div>

            <div id="hors-systeme">
                <h3>Hors système
                    <hr>
                </h3>
                <div>
                    <h4>
                        Communication Digitale
                    </h4>
                </div>
            </div>

            <div id="communicateurs">
                <div style="display:flex; justify-content:space-between;align-items:center;padding:10px">
                    <h3>Communicateurs </h3>
                    <div class="dropdown">
                        <i title="Ajouter un communicateur" style="border-radius:50%;font-size:20px; color:white;background-color:#1d75bd;height:40px;width:40px;padding: 10px;text-align:center" class="fa fa-plus dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> </i>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            <a href="<?php echo Helper::getBaseUrl(); ?>/inscription/02047r01212/niveau-2" target="_blank" rel="noopener noreferrer" class="dropdown-item">
                                Communication Digitale
                            </a>
                            <a class="dropdown-item" href="<?php echo Helper::getBaseUrl(); ?>/inscription/02047r01212/niveau-3" target="_blank" rel="noopener noreferrer">
                                Accessoires Pagnes et perlage
                            </a>
                            <a class="dropdown-item" href="<?php echo Helper::getBaseUrl(); ?>/inscription/02047r01212/niveau-4" target="_blank" rel="noopener noreferrer">
                                Saponification
                            </a>
                        </div>
                    </div>
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
                <h3>Liste des utilisateurs validés
                    <hr>
                </h3>
                <div id="valides-com-digitale">
                    <h4>
                        Communication Digitale
                    </h4>
                    <?php

                    if (isset($validateUserArray) && !empty($validateUserArray))
                        foreach ($validateUserArray as $user) {
                            if ($user["package"]["slug"] == 'niveau-1' || $user["package"]["slug"] == 'niveau-2') {
                    ?>
                            <div class="card card-body bg-dark user">
                                <div>
                                    <?php echo "<div hidden >" . $user['token'] . "</div>" ?>
                                    <?php echo "<div> Nom : " . $user['last_name'] . "</div>" ?>
                                    <?php echo "<div> Prenom : " . $user['first_name'] . "</div>" ?>
                                    <?php echo "<div> Sexe : " . $user['sex'] . "</div>" ?>
                                    <?php echo "<div> Email : " . $user['email'] . "</div>" ?>
                                    <?php echo ("<div >Tel : " . $user["phoneNumber"] . "</div>"); ?>
                                    <?php echo ("<div >Whatsapp : " . $user["whatsappNumber"] . "</div>"); ?>
                                    <?php echo ("<div >Pays : " . $user["country"] . "</div>"); ?>
                                    <?php echo ("<div >" . $user["package"]["designation"] . "</div>"); ?>
                                    <?php echo ("<div >Parrain : " . $user["parrain"]["last_name"] . ' ' . $user["parrain"]["first_name"] . "</div>"); ?>
                                    <?php echo $user["original_parrain"] ? ("<div >Parrain originale : " . $user["original_parrain"] . "</div>") : null  ?>
                                    <?php echo ("<div >Date de validation : " . $user["admissionDate"] . "</div>"); ?>
                                </div>
                                <div>
                                    <button title="Supprimer"> &times; </button>
                                </div>
                            </div>
                        <?php }
                        }
                    else { ?>
                        <h5>
                            Il y'a personne ici
                        </h5>
                    <?php } ?>
                </div>
                <hr>

                <div id="valides-perlage">
                    <h4>
                        Perlage
                    </h4>
                    <?php

                    if (isset($validateUserArray) && !empty($validateUserArray))
                        foreach ($validateUserArray as $user) {

                            if ($user["package"]["slug"] == 'niveau-3') {

                    ?>
                            <div class="card card-body bg-dark user">
                                <div>
                                    <?php echo "<div hidden >" . $user['token'] . "</div>" ?>
                                    <?php echo "<div> Nom : " . $user['last_name'] . "</div>" ?>
                                    <?php echo "<div> Prenom : " . $user['first_name'] . "</div>" ?>
                                    <?php echo "<div> Sexe : " . $user['sex'] . "</div>" ?>
                                    <?php echo "<div> Email : " . $user['email'] . "</div>" ?>
                                    <?php echo ("<div >Tel : " . $user["phoneNumber"] . "</div>"); ?>
                                    <?php echo ("<div >Whatsapp : " . $user["whatsappNumber"] . "</div>"); ?>
                                    <?php echo ("<div >Pays : " . $user["country"] . "</div>"); ?>
                                    <?php echo ("<div >" . $user["package"]["designation"] . "</div>"); ?>
                                    <?php //echo ("<div >Parrain : " . $user["parrain"]["last_name"] . ' ' . $user["parrain"]["first_name"] . "</div>"); 
                                    ?>
                                </div>
                                <div>
                                    <button title="Supprimer"> &times; </button>
                                </div>
                            </div>
                        <?php }
                        }
                    else { ?>
                        <h5>
                            Il y'a personne ici
                        </h5>
                    <?php } ?>
                </div>
                <hr>

                <div id="valides-sapo">
                    <h4>
                        Saponification
                    </h4>
                    <?php

                    if (isset($validateUserArray) && !empty($validateUserArray))
                        foreach ($validateUserArray as $user) {
                            if ($user["package"]["slug"] == 'niveau-4') {
                    ?>
                            <div class="card card-body bg-dark user">
                                <div>
                                    <?php echo "<div hidden >" . $user['token'] . "</div>" ?>
                                    <?php echo "<div> Nom : " . $user['last_name'] . "</div>" ?>
                                    <?php echo "<div> Prenom : " . $user['first_name'] . "</div>" ?>
                                    <?php echo "<div> Sexe : " . $user['sex'] . "</div>" ?>
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
                        <?php }
                        }
                    else { ?>
                        <h5>
                            Il y'a personne ici
                        </h5>
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