<!-- Le bouton qui va lancer la modal -->
<button type="button" class="btn btn-primary pb-2" data-toggle="modal" data-target="#connexion">
  Se connecter
</button>

<!-- La modal -->
<div class="modal fade" id="connexion" tabindex="-1" role="dialog" aria-labelledby="maConnexion" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="maConnexion">Saisir vos identifiants</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="index.php?vue=Connexion&action=Verification" method="POST">
          <div class="form-group">
            <label for="role">Choisissez votre rôle:</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="role" id="admin" value="1" required>
              <label class="form-check-label" for="admin">Admin</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="role" id="adherent" value="2" required>
              <label class="form-check-label" for="adherent">Adherent</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="role" id="entraineur" value="3" required>
              <label class="form-check-label" for="entraineur">Entraineur</label>
            </div>
          </div>
          <div class="form-group">
            <label for="login">Login:</label>
            <input type="text" class="form-control" id="login" name="login" placeholder="Votre login" required>
          </div>
          <div class="form-group">
            <label for="pwd">Mot de passe:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Votre mot de passe" required>
          </div>
          <div class="text-right">
            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
