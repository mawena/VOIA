<?php #if (!isset($tableau) || empty($tableau)) {
#echo ("No array");
#} else {
?>

<link rel="stylesheet" href="/Css/dashboard.css">
<div id='dashboard'>
    <div id="left-side">
        <li><i class="fas fa-handshake"></i><span> Parainages</span> </li>
        <li> <i class="fa fa-graduation-cap"></i><span> Formations</span> </li>
    </div>
    <div id="right-side">

        <!-- parainages -->

        <div id="parainages">
            <h1>Parainages</h1>

            <div id="parain-tree">

                <!-- 1- Etat du parainage -->
                <div class="product-header">
                    <span style="display: flex; flex-direction:column; justify-content :space-between; width : 80% ">
                        <span>Etat du parainage</span>
                        <span style="font-size: 12px; color : orange">Ce package expire dans <span id="package-expiration-delay" class="badge badge-primary">20 jours</span></span>
                    </span>
                    <i class="fa fa-plus"></i>
                </div>

                <div id="product-content">
                    <div>Package : <span>Business Entrepreunariat</span></div>
                    <div> Description du package :
                        <div style="margin-left: 5%; font-size: 12px;"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus laborum rem commodi, architecto quisquam atque incidunt. Est amet perspiciatis officia laboriosam. Ad provident omnis blanditiis! Dolorum cupiditate rerum ad asperiores error. Error quo commodi fugit nemo. Sint nostrum alias doloribus. Dolores distinctio numquam iusto optio quos inventore praesentium illum vero.</div>
                    </div>
                    <div>Quota de parainage : <span>25%</span> </div>
                    <div class="progress" style="height: 20px; border-radius : 5px">
                        <div class="progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div> Bonus du package : <span> LG SmartTV </span> </div>
                </div>

                <!-- 2- Containers : Liste des fileuls -->
                <div class="parain-tree-header"> <span>Fileuls <span style="font-size: 14px" class="badge badge-secondary"> 4 </span></span> <i class="fa fa-plus"></i></div>

                <div id="parain-tree-list">

                    <!-- 2.1- Liste des fileuls -->
                    <div class="fileul">
                        <div class="fileul-pic">
                            <img src="/Images/pic-test/pic.jpg" alt="pic">
                        </div>
                        <div class="fileul-data">
                            <div>Alan Coles</div>
                            <div>Entrepreneur</div>
                        </div>
                    </div>

                    <div class="fileul">
                        <div class="fileul-pic">
                            <img src="/Images/pic-test/pic.jpg" alt="pic">
                        </div>
                        <div class="fileul-data">
                            <div>Alan Coles</div>
                            <div>Entrepreneur</div>
                        </div>
                    </div>

                    <div class="fileul">
                        <div class="fileul-pic">
                            <img src="/Images/pic-test/pic.jpg" alt="pic">
                        </div>
                        <div class="fileul-data">
                            <div>Alan Coles</div>
                            <div>Entrepreneur</div>
                        </div>
                    </div>
                    <div class="fileul">
                        <div class="fileul-pic">
                            <img src="/Images/pic-test/pic.jpg" alt="pic">
                        </div>
                        <div class="fileul-data">
                            <div>Alan Coles</div>
                            <div>Entrepreneur</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- formations -->

        <div id="formations">
            <h1>Formations</h1>

            <!-- Nom du paquet + cours  -->
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Nom du paquet</li>
                        <li class="breadcrumb-item active">Cours</li>
                    </ol>
                </nav>
            </div>

            <div>
                <!-- Liste des cours -->
                <div class="cours">
                    <div> <span>Le nom du Cours</span> <i class="fa fa-arrow-down "></i> </div>
                    <div></div>
                    <div> Details sur le cours :</div>
                    <div>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Incidunt aperiam quam eaque dolorum porro quaerat neque doloribus nihil dolores dolor blanditiis est, voluptatem ducimus natus architecto repellat tempore laudantium a accusamus eligendi alias earum sunt officiis? Odio aspernatur aut numquam necessitatibus minima ullam alias unde ducimus ad. Voluptatem, facilis neque.</div>
                    <div>Status : <span class="badge badge-light"> Indisponible </span> </div>
                </div>

                <div class="cours">
                    <div> <span>Le nom du Cours</span> <i class="fa fa-arrow-down "></i> </div>
                    <div></div>
                    <div> Details sur le cours :</div>
                    <div>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Incidunt aperiam quam eaque dolorum porro quaerat neque doloribus nihil dolores dolor blanditiis est, voluptatem ducimus natus architecto repellat tempore laudantium a accusamus eligendi alias earum sunt officiis? Odio aspernatur aut numquam necessitatibus minima ullam alias unde ducimus ad. Voluptatem, facilis neque.</div>
                    <div>Status : <span class="badge badge-info"> En cours </span> </div>
                </div>

                <div class="cours">
                    <div> <span>Le nom du Cours</span> <i class="fa fa-arrow-down "> </i> </div>
                    <div></div>
                    <div>Details sur le cours :</div>
                    <div>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Incidunt aperiam quam eaque dolorum porro quaerat neque doloribus nihil dolores dolor blanditiis est, voluptatem ducimus natus architecto repellat tempore laudantium a accusamus eligendi alias earum sunt officiis? Odio aspernatur aut numquam necessitatibus minima ullam alias unde ducimus ad. Voluptatem, facilis neque.</div>
                    <div>Status : <span class="badge badge-success">Achevé</span> </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function show_formations(params = 'on') {
        if (params == "on") {
            $("#formations").css({
                "display": "flex"
            })
        } else if (params == "off") {
            $("#formations").css({
                "display": "none"
            })
        }
    }

    function show_parainages(params = 'on') {
        if (params == "on") {
            $("#parainages").css({
                "display": "flex"
            })
        } else if (params == "off") {
            $("#parainages").css({
                "display": "none"
            })
        }
    }

    $("#left-side li:nth(1)").on("click", function(e) {
        show_formations()
        show_parainages('off')
    })

    $("#left-side li:nth(0)").on("click", function(e) {
        show_parainages()
        show_formations("off")
    })

    $(".parain-tree-header i").on("click", function() {
        $(".parain-tree-header i").toggleClass("fa fa-plus")
        $(".parain-tree-header i").toggleClass("fa fa-minus")
        $("#parain-tree-list").slideToggle(1000)
    })

    $(".product-header i").on("click", function() {
        $(".product-header i").toggleClass("fa fa-plus")
        $(".product-header i").toggleClass("fa fa-minus")
        $("#product-content").slideToggle(1000)
    })

    let cours = document.getElementsByClassName('cours')

    for (let index = 0; index < cours.length; index++) {
        cours[index].children[0].addEventListener("click", function(event) {
            $(cours[index].children[2]).slideToggle()
            $(cours[index].children[3]).slideToggle()
            $(cours[index].children[0].children[1]).toggleClass("fa fa-arrow-up")
            $(cours[index].children[0].children[1]).toggleClass("fa fa-arrow-down")
        })
    }
</script>

<?php # } 
?>