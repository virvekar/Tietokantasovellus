
            <div id="my-tab-content" class="tab-content">
                <div class="tab-pane active" id="haku">
                    <h1>Puuha-haku</h1>

                    <div class="row">
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
                        <div class="col-md-3 col-md-offset-1">
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <form name="input" action="html_form_action.asp" method="get">
                        Kesto: <input type="text" name="kesto">
                    </form> 
                    <form name="input" action="html_form_action.asp" method="get">
                        Henkilömäärä: <input type="text" name="henkilomaara">
                    </form> 
                    Paikka:   <select name="Paikka" id="paikka">
                        <option value="anyPaikka" selected>Mikä tahansa</option>
                        <option value="kotona">Kotona</option>
                        <option value="ulkona">Ulkona</option>
                        <option value="julkinen">Julkinen</option>

                    </select> <br>
                    <button type="button" class="btn btn-xs btn-default"> Hae</button>
                  
                    

                </div>
            </div>

