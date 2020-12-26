<div id="cgu-box">
    <div id="cgu">
        <h3 style="text-align:center;">Conditions Générales d'Utilisation</h3>
        <div>
            Le programme de vulgarisation de l’outil informatique en Afrique (VOIA) met à la disposition de ses apprenants une plateforme numérique pour les renseigner et faciliter leurs inscriptions à la formation en communication digitale. En s'inscrivant, l’utilisateur reconnaît qu'il est pleinement informé et qu'il est tenu par l'ensemble des dispositions de nos conditions générales d'utilisation et de notre politique de confidentialité.
            <hr>
            <button type="button" class="btn btn-secondary">Compris</button>
        </div>
    </div>
</div>
</body>

<style>
    #footer>div>div:hover {
        text-decoration: underline;
        cursor: pointer;
    }
</style>

<footer id="footer">
    <span>&copy;2020 - VOIA</span>
    <div style="display: flex;flex-direction:column;flex-wrap:wrap;align-items:center;width:80%;margin:10px">
        <div> Conditions générales d'utilisations </div>
        <div> Politique de confidentialité </div>
    </div>
</footer>

<script>
    $('#cgu button.btn.btn-secondary').on("click", function(e){
        $("#cgu-box").slideUp()
    })
    
    
    $("#footer>div>div:nth-child(1)").on("click", function(e) {
        $("#cgu-box").slideDown()
        $("#cgu-box").css({
            "display": "flex"
        })
    })
</script>

</html>