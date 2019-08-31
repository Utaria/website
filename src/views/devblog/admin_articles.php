<div class="app-content-body">
  <div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Articles du devblog</h1>
  </div>

  <div class="wrapper-md">
    <div class="panel panel-default">
      <div class="panel-heading">
        Tous les articles
      </div>
      <div class="table-responsive">
        <table ui-jq="dataTable" ui-options="{
						sAjaxSource: '?data=true',
						aoColumns: [
							{ mData: 'title' },
							{ mData: 'content' },
							{ mData: 'date' },
							{ mData: 'category' },
							{ mData: 'author' },
							{ mData: 'views' },
							{ mData: 'state' },
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
            <th style="width:20%">Titre</th>
            <th style="width:30%">Début du contenu</th>
            <th style="width:15%">Date</th>
            <th style="width:8%">Catégorie</th>
            <th style="width:8%">Auteur</th>
            <th style="width:4%">Vues</th>
            <th style="width:5%">Etat</th>
            <th style="width:10%">Actions</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function confirmDelete () {
        return confirm('Voulez-vous vraiment supprimer cet article ?');
    }
</script>
