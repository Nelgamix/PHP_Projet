<fieldset>
    <legend>Compte</legend>
    <!--<div class="col-md-6 form_nc" style="border-left: 1px solid #d8d8d8">
        <!- FORM LOGIN ->
        <form action="login.ctrl.php" method="post">
            <table>
                <thead>
                <tr>
                    <th colspan="2">Se connecter</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Utilisateur: </td>
                    <td><input type="text" name="user" /></td>
                </tr>
                <tr>
                    <td>Mot de passe: </td>
                    <td><input type="password" name="password" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="connect" value="Se connecter" /></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>-->
    <fieldset class="col-md-offset-1 col-md-4">
        <legend>Se connecter</legend>
        <form action="parametres.ctrl.php" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="user" class="col-sm-offset-1 col-sm-3 control-label">Utilisateur</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="user" id="user" placeholder="Utilisateur">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-offset-1 col-sm-3 control-label">Mot de passe</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-10">
                    <button type="submit" name="connect" class="btn btn-default">Se connecter</button>
                </div>
            </div>
        </form>
    </fieldset>

    <fieldset class="col-md-offset-2 col-md-4">
        <legend>S'inscrire</legend>
        <form action="parametres.ctrl.php" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="user" class="col-sm-offset-1 col-sm-3 control-label">Utilisateur</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="user" name="user" placeholder="Utilisateur">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-offset-1 col-sm-3 control-label">Mot de passe</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-10">
                    <button type="submit" name="signup" class="btn btn-default">S'enregistrer</button>
                </div>
            </div>
        </form>
    </fieldset>


    <!--<div class="col-md-6 form_nc">
        <!- FORM NOUVEL USER ->
        <form action="login.ctrl.php" method="post">
            <table>
                <thead>
                <tr>
                    <th colspan="2">S'inscrire</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Utilisateur: </td>
                    <td><input type="text" name="user" /></td>
                </tr>
                <tr>
                    <td>Mot de passe: </td>
                    <td><input type="password" name="password" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="signup" value="S'inscrire" /></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>-->
</fieldset>
