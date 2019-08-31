<div class="app-content-body">
  <div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Retours des joueurs</h1>
  </div>

  <div class="wrapper-md">
    <div class="panel panel-default">
      <div class="panel-heading">
        Retours des joueurs
      </div>
      <div class="table-responsive">
        <table ui-jq="dataTable" ui-options="{
						sAjaxSource: '?data=true',
						aoColumns: [
						{ mData: 'playername' },
						{ mData: 'service' },
						{ mData: 'description' },
						{ mData: 'date' },
						{ mData: 'priority' }
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
						order: [[ 3, 'desc' ]],
						iDisplayLength: 25
					}" class="table table-striped b-t b-b">
          <thead>
          <tr>
            <th style="width:10%">Joueur</th>
            <th style="width:15%">Service</th>
            <th style="width:50%">Description</th>
            <th style="width:15%">Date</th>
            <th style="width:10%">Priorité</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
