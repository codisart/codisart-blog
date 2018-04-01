<div id="boutonForm" >Laissez-moi une suggestion !</div>

<form id="formMessage" action="suggestions.php" onsubmit="return verificationForm();" method="post">
    <img src="img/fermer.png" />
    <h2>Laisser un message :</h2>

    <p>
        <input id="pseudo" name="pseudo" type="text" required="required" value=""/>
        <label for="pseudo" >Pseudo <em>(obligatoire)</em></label>
    </p>

    <p>
        <input id="mail" name="email" type="text" required="required" value="" />
        <label for="mail" >Email <em>(obligatoire : ne sera pas affiché)</em></label>
    </p>

    <p>
        <textarea id="suggestion" name="suggestion" cols="50" rows="9" required="required"></textarea>
    </p>

    <p>
        <input type="text" name="asali" id="asali" value="" />
        <input id="submit" name="submit" value="Valider" type="submit" class="button">
    </p>
</form>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
 $(document).ready( function() {
    $('#boutonForm').on('click', function (){
        $('#formMessage').show();
    });

    $('#formMessage img').on('click', function (){
        $('#formMessage').hide();
    });
 });
</script>
