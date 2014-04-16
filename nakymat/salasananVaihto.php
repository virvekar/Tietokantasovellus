<h1>Salasanan vaihto:</h1>
<form class="form-horizontal" role="form" action="salasananVaihtoK.php" method="POST">
    <div class="form-group">
        <label for="vanhaSalasana" class="col-md-2 control-label">Vanha salasana</label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="vanhaSalasana" name="vanhaSalasana" >
        </div>
    </div>
    <div class="form-group">
        <label for="salasana" class="col-md-2 control-label">Uusi salasana</label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="salasana" name="salasana" >
        </div>
    </div>
    <div class="form-group">
        <label for="salasana2" class="col-md-2 control-label">Vahvista salasana</label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="salasana2" name="salasana2">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" id=submitvaihda name="submitvaihda" class="btn btn-default">Vaihda salasana</button>
        </div>
    </div>
</form>

