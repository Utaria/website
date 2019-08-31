<div class="app-content-body">
  <div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Administration des documents du serveur</h1>
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
							{ mData: 'viewed_by' },
							{ mData: 'modification_time' },
							{ mData: 'actions' }
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
            <th style="width:35%">Titre</th>
            <th style="width:35%">Vu par</th>
            <th style="width:20%">Dernière modification</th>
            <th style="width:10%">Actions</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>

    <a href="<?= BASE_URL . ADMIN_PREFIX ?>/documents" class="btn btn-danger"><i class="fa fa-long-arrow-left"></i>
      Retour aux documents</a>
  </div>
</div>
