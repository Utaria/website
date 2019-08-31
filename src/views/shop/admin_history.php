<div class="app-content-body ">
  <div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Historique de la boutique</h1>
  </div>

  <div class="wrapper-md">
    <div class="panel panel-default">
      <div class="panel-heading font-bold">Les derniers achats</div>

      <div class="table-responsive">
        <table ui-jq="dataTable" ui-options="{
						sAjaxSource: '?data=true',
						aoColumns: [
							{ mData: 'playername' },
							{ mData: 'payment_mean' },
							{ mData: 'ordertime' },
							{ mData: 'coins_buyed' },
							{ mData: 'order_value' }
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
						iDisplayLength: 50
					}" class="table table-striped b-t b-b">
          <thead>
          <tr>
            <th style="width:20%">Joueur</th>
            <th style="width:25%">Moyen de paiement</th>
            <th style="width:25%">Date</th>
            <th style="width:15%">Coins achetés</th>
            <th style="width:15%">Valeur de l'achat</th>
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
