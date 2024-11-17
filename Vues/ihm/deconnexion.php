<!-- Le bouton qui va lancer la modal -->
<button type="button" class="btn btn-danger pt-2" data-toggle="modal" data-target="#deconnexion">
  Se déconnecter
</button>

<!-- La modal -->
<div class="modal fade" id="deconnexion" tabindex="-1" role="dialog" aria-labelledby="maDeConnexion" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="maDeConnexion">Se déconnecter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <form action="index.php?vue=Connexion&action=Deconnexion" method="POST" align="center">
              <p>Etes-vous certain de vouloir vous déconnecter ?</p>
              <div class="text-right">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger">Déconnexion</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>