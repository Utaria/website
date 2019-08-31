<div class="app-content-body ">
  <div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Les cartes Paysafe utilisées</h1>
  </div>

  <div class="wrapper-md">
    <div class="panel panel-default">
      <div class="panel-heading font-bold">Les derniers codes Paysafe</div>

      <div class="table-responsive">
        <table ui-jq="dataTable" ui-options="{
						sAjaxSource: '?data=true',
						aoColumns: [
							{ mData: 'playername' },
							{ mData: 'email' },
							{ mData: 'date' },
							{ mData: 'product' },
							{ mData: 'code' },
							{ mData: 'validated' },
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
						iDisplayLength: 50,
						columnDefs: [
							{targets: -1,orderable: false},
							{targets: -2,orderable: false},
							{targets: -3,orderable: false}
						]
					}" class="table table-striped b-t b-b">
          <thead>
          <tr>
            <th style="width:15%">Joueur</th>
            <th style="width:20%">E-mail</th>
            <th style="width:15%">Date</th>
            <th style="width:15%">Produit</th>
            <th style="width:20%">Code</th>
            <th style="width:5%">Validé</th>
            <th style="width:10%">Actions</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

      <footer class="panel-footer"></footer>
    </div>
  </div>
</div>
