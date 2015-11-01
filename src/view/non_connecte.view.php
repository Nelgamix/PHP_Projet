<fieldset>
    <legend>Compte</legend>
    <div class="col-md-6 form_nc" style="border-left: 1px solid #d8d8d8">
        <!-- FORM LOGIN -->
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
    </div>
    <div class="col-md-6 form_nc">
        <!-- FORM NOUVEL USER -->
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
    </div>
</fieldset>
