<div class="app-content-body">
  <div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Documents du serveur</h1>
  </div>

  <div class="wrapper-md">
    <div class="panel panel-default">
      <div class="panel-heading">
        Les documents officiels du serveur
      </div>
      <div class="table-responsive">
        <table ui-jq="dataTable" ui-options="{
						sAjaxSource: '?data=true',
						aoColumns: [
							{ mData: 'name' },
							{ mData: 'creation_time' },
							{ mData: 'modification_time' },
							{ mData: 'modified_by' },
							{ mData: 'access_link' }
						],
						language: {
							search: 'Rechercher :',
							lengthMenu: 'Afficher _MENU_ entrées',
							paginate: {
								first: 'Début',
								last:'Fin',
								next: 'Suivant',
								previous: 'Précédent'
							},
							info: 'Affichage de _START_ à _END_ entrées sur _TOTAL_ entrées'
						},
						order: [[ 2, 'desc' ]],
						columnDefs: [
							{targets: -1,orderable: false}
						]
					}" class="table table-striped b-t b-b">
          <thead>
          <tr>
            <th style="width:40%">Titre</th>
            <th style="width:15%">Mise en ligne le</th>
            <th style="width:15%">Modifié le</th>
            <th style="width:15%">Dernière édition par</th>
            <th style="width:15%">Lien d'accès</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <blockquote class="bg-danger">
      <p style="font-size:.8em"><i class="fa fa-info-circle"></i> &nbsp;Dès lors de l'ouverture d'un document, vous êtes
        convenu de le lire et d'en prendre connaissance. Le document sera considéré comme entièrement lu et accepté dès
        lors du clic sur le lien d'accès du document en question. Nous gardons un historique de lecture des documents.
      </p>
    </blockquote>

      <?php if (getUser()->adminRole == "admin"): ?>
        <a href="<?= BASE_URL . ADMIN_PREFIX ?>/documents/admin" class="btn btn-primary"><i class="fa fa-gear"></i>
          Administration des documents</a>
      <?php endif; ?>
  </div>
</div>
