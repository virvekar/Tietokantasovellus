<h1>Puuhan lisäys</h1>
<form class="form-horizontal" role="form" action="lomake.html" method="POST">
    <div class="form-group">
        <label for="inputPuuhaNimi" class="col-md-2 control-label">Puuhan nimi</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="inputPuuhanNimi" name="puuhanNimi" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">                 
            Puuha-luokka:   <select name="Puuha-luokka" id="luokkasailio">
                <option value="any" selected>Mikä tahansa</option>
                <option value="kirja">Kirjan lukeminen</option>
                <option value="oudot">Oudot</option>
                <option value="luento">Luennon aikana</option>
                <option value="urheilu">Urheilu</option>
                <option value="lautapelit">Lautapelit</option>
                <option value="lastenAskartelu">Lasten askartelu</option>
            </select></div>
        <div class="col-md-3 ">
            <input type="text" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="inputKuvaus" class="col-md-2 control-label">Kuvaus</label>
        <div class="col-md-10">
            <input type="text" style="height: 200px; width: 300px" class="form-control" id="inputKuvaus" name="kuvaus" >
        </div>
    </div>
    <div class="form-group">
        <label for="inputKesto" class="col-md-2 control-label">Kesto</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="inputKesto" name="kesto" >
        </div>
    </div>
    <div class="form-group">
        <label for="inputHenkilomaara" class="col-md-2 control-label">Henkilömäärä</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="inputHenkilomaara" name="henkilomaara">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">                 
            Paikka:   <select name="Paikka" id="paikkasailio">
                <option value="any" selected>Missä tahansa</option>
                <option value="kotona">Kotona</option>
                <option value="ulkona">Ulkona</option>
                <option value="julkinen">Julkinen</option>

            </select></div>
        <div class="col-md-3 ">
            <input type="text" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">                 
            Taidot:   <select name="Taidot" id="taitosailio">
                <option value="none" selected>Ei erityistaitoja</option>
                <option value="japani">Japanin kieli</option>
                <option value="php">PHP:n koodays</option>
                <option value="kitaranSoitto">kitaranSoitto</option>

            </select></div>
        <div class="col-md-3 ">
            <input type="text" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" class="btn btn-default">Lisää puuha</button>
        </div>
    </div>
</form>

