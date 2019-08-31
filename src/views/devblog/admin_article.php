<div class="app-content-body">
    <?php if ($d->action == "edit"): ?>
      <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3">Editer l'article : <b><?= $d->article->title ?></b></h1>
      </div>
    <?php elseif ($d->action == "comments"): ?>
      <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3">Commentaires de l'article : <b><?= $d->article->title ?></b></h1>
      </div>
    <?php elseif ($d->action == "new"): ?>
      <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3">Ecrire un nouvel article</h1>
      </div>
    <?php endif; ?>

    <?php if ($d->action == "edit" || $d->action == "new"): ?>
      <div class="wrapper-md" ng-controller="FormDevblogArticleEditCtrl">
        <div class="panel panel-default">
          <div class="panel-heading font-bold">
              <?php if ($d->action == 'edit'): ?>
                Edition de l'article
              <?php elseif ($d->action == 'new'): ?>
                Création d'un nouvel article
              <?php endif; ?>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" method="POST" onsubmit="return updateContent()">

                <?php if ($d->action == "new"): ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Titre de l'article</label>
                    <div class="col-sm-10">
                      <input type="text" name="title" class="form-control">
                    </div>
                  </div>

                  <div class="line line-dashed b-b line-lg pull-in"></div>
                <?php endif; ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Contenu de l'article</label>
                <div class="col-sm-10">
                  <div class="btn-toolbar m-b-sm btn-editor" data-role="editor-toolbar" data-target="#editor">
                    <!-- <div class="btn-group dropdown" dropdown>
                                          <a class="btn btn-default" dropdown-toggle data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                          <ul class="dropdown-menu">
                                              <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li>
                                              <li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li>
                                              <li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li>
                                          </ul>
                                      </div> -->
                    <div class="btn-group dropdown" dropdown>
                      <a class="btn btn-default" dropdown-toggle data-toggle="dropdown" data-tooltip title="Taille"><i
                            class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a data-edit="fontSize 5" style="font-size:24px">Grand</a></li>
                        <li><a data-edit="fontSize 3" style="font-size:18px">Moyen</a></li>
                        <li><a data-edit="removeFormat" style="font-size:16px">Normal</a></li>
                        <li><a data-edit="fontSize 1" style="font-size:14px">Petit</a></li>
                      </ul>
                    </div>
                    <div class="btn-group">
                      <a class="btn btn-default" data-tooltip data-edit="bold" title="Gras (Ctrl+B)"><i
                            class="fa fa-bold"></i></a>
                      <a class="btn btn-default" data-tooltip data-edit="italic" title="Italique (Ctrl+I)"><i
                            class="fa fa-italic"></i></a>
                      <a class="btn btn-default" data-tooltip data-edit="strikethrough" title="Barré"><i
                            class="fa fa-strikethrough"></i></a>
                      <a class="btn btn-default" data-tooltip data-edit="underline" title="Sous-ligné (Ctrl+U)"><i
                            class="fa fa-underline"></i></a>
                    </div>
                    <div class="btn-group dropdown" id="colorBtn" dropdown>
                      <a class="btn btn-default" dropdown-toggle data-toggle="dropdown" data-tooltip
                         title="Modifier la couleur"><i class="fa fa-tint"></i></a>
                      <div class="dropdown-menu" style="width:288px">
                        <div class="input-group m-l-xs m-r-xs" data-keepOpenOnClick>
                          <input class="form-control input-sm" ui-jq="spectrum" ui-options="{
													flat: true,
													showInput: true,
													showInitial: true,
													preferredFormat: 'hex',
													showPalette: true,
												    palette: [ ],
												    showSelectionPalette: true,
												    selectionPalette: ['red', 'green', 'blue'],
												    showButtons: true,
												    allowEmpty: true,
												    change: colorChange,
												    cancelText: 'Annuler',
												    chooseText: 'Choisir'
												}" id="colorInput" placeholder="Couleur" type="text"/>
                        </div>
                      </div>
                    </div>
                    <div class="btn-group">
                      <a class="btn btn-default" data-edit="insertunorderedlist" data-tooltip title="Liste à puce"><i
                            class="fa fa-list-ul"></i></a>
                      <a class="btn btn-default" data-edit="insertorderedlist" data-tooltip title="Liste numérotée"><i
                            class="fa fa-list-ol"></i></a>
                      <a class="btn btn-default" data-edit="outdent" data-tooltip
                         title="Reduire l'indentation (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                      <a class="btn btn-default" data-edit="indent" data-tooltip title="Indenter (Tab)"><i
                            class="fa fa-indent"></i></a>
                    </div>
                    <div class="btn-group">
                      <a class="btn btn-default" data-tooltip data-edit="justifyleft" title="Aligner à gauche (Ctrl+L)"><i
                            class="fa fa-align-left"></i></a>
                      <a class="btn btn-default" data-tooltip data-edit="justifycenter" title="Centrer (Ctrl+E)"><i
                            class="fa fa-align-center"></i></a>
                      <a class="btn btn-default" data-tooltip data-edit="justifyright"
                         title="Aligner à droite (Ctrl+R)"><i class="fa fa-align-right"></i></a>
                      <a class="btn btn-default" data-tooltip data-edit="justifyfull" title="Justifier (Ctrl+J)"><i
                            class="fa fa-align-justify"></i></a>
                    </div>
                    <div class="btn-group dropdown" dropdown>
                      <a class="btn btn-default" dropdown-toggle data-toggle="dropdown" data-tooltip
                         title="Créer un lien"><i class="fa fa-link"></i></a>
                      <div class="dropdown-menu">
                        <div class="input-group m-l-xs m-r-xs" data-keepOpenOnClick>
                          <input class="form-control input-sm" id="LinkInput" placeholder="URL" type="text"
                                 data-edit="createLink"/>
                          <div class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button">Ajouter</button>
                          </div>
                        </div>
                      </div>
                      <a class="btn btn-default" data-edit="unlink" data-tooltip title="Supprimer le lien"><i
                            class="fa fa-unlink"></i></a>
                    </div>

                    <div class="btn-group">
                      <!-- <a class="btn btn-default" data-tooltip title="Insérer une image (ou glisser-la juste)" id="pictureBtn" onclick="document.getElementById('insertImage').click();"><i class="fa fa-picture-o"></i></a> -->
                      <!-- <input type="file" id="insertImage" data-edit="insertImage" style="position:absolute; opacity:0; width:1px; height:1px;z-index:-2" /> -->
                      <span class="dropdown" dropdown>
											<a class="btn btn-default" dropdown-toggle data-toggle="dropdown" data-tooltip
                         title="Insérer une image"><i class="fa fa-image"></i></a>
											<div class="dropdown-menu">
												<div class="input-group m-l-xs m-r-xs" data-keepOpenOnClick>
													<input class="form-control input-sm" id="ImageLinkInput" placeholder="URL" type="text"/>
													<div class="input-group-btn">
														<button class="btn btn-sm btn-default" type="button"
                                    onclick="pasteImageWithLink(this.parentNode.parentNode.querySelector('input').value);">Ajouter</button>
													</div>
												</div>
											</div>
										</span>

                      <span class="dropdown" dropdown>
											<a class="btn btn-default" dropdown-toggle data-toggle="dropdown" data-tooltip
                         title="Ajouter une vidéo YouTube"><i class="fa fa-youtube"></i></a>
											<div class="dropdown-menu">
												<div class="input-group m-l-xs m-r-xs" data-keepOpenOnClick>
													<input class="form-control input-sm" id="YTLinkInput" placeholder="URL" type="text"/>
													<div class="input-group-btn">
														<button class="btn btn-sm btn-default" type="button"
                                    onclick="pasteYTVideo(this.parentNode.parentNode.querySelector('input').value);">Ajouter</button>
													</div>
												</div>
											</div>
										</span>
                    </div>
                    <div class="btn-group">
                      <a class="btn btn-default" data-edit="undo" data-tooltip title="Retour (Ctrl+Z)"><i
                            class="fa fa-undo"></i></a>
                      <a class="btn btn-default" data-edit="redo" data-tooltip title="Refaire (Ctrl+Y)"><i
                            class="fa fa-repeat"></i></a>
                    </div>
                    <!-- <div class="btn-group">
										<a class="btn btn-default" href="/devblog/<?= slugify($d->article->title) ?>?preview" target="_blank" data-tooltip title="Prévisualiser votre article sur le site">Prévisualiser</a>
									</div> -->
                  </div>
                  <div ui-jq="wysiwyg" id="wysiwyg-editor-content" class="form-control"
                       style="overflow:scroll;min-height:400px">
                      <?= ($d->action == 'edit') ? $d->article->content : '' ?>
                  </div>

                  <textarea name="content" id="content-fake-textarea" class="hidden"></textarea>
                </div>
              </div>

              <div class="line line-dashed b-b line-lg pull-in"></div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Catégorie</label>
                <div class="col-sm-10">
                  <select name="category" class="form-control m-b">
                      <?php foreach ($d->categories as $v): ?>
                        <option<?= ($d->action == 'edit' && $v->id == $d->article->category_id) ? " selected" : "" ?>
                            value="<?= $v->id ?>"><?= ucfirst($v->name) ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>

                <?php if ($d->action == 'new' || $d->article->draft || strtotime($d->article->date) > time()): ?>
                  <div class="line line-dashed b-b line-lg pull-in"></div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Publier l'article</label>
                    <div class="col-sm-10">
                        <?php if ($d->action == 'new' || $d->article->draft): ?>
                          <label class="i-switch i-switch-lg m-t-xs m-r">
                            <input name="publish" type="checkbox" onchange="updatePubOpts(this);">
                            <i></i>
                          </label>

                          <div id="pub_opts" style="display:none">
                            <p class="text-danger">Vous ne pourrez pas revenir en arrière !</p>
                            <div class="radio">
                              <label class="i-checks">
                                <input type="radio" name="publication" value="now" checked
                                       onchange="updatePubDate(this);">
                                <i></i>
                                Publier maintenant
                              </label>
                            </div>
                            <div class="radio">
                              <label class="i-checks">
                                <input type="radio" name="publication" value="planified"
                                       onchange="updatePubDate(this);">
                                <i></i>
                                Planifier la publication
                              </label>
                            </div>

                            <div id="pub_report_date" class="row" style="display:none;margin-top:10px">
                              <label class="col-md-1 control-label">Le</label>
                              <div class="col-md-3">
                                <div class="input-group w-md">
                                  <input type="text" name="publish_date" class="form-control"
                                         ui-options="{format:'d/m/Y',min:new Date(),locale:'fr',hide_on_select:true}"
                                         ui-jq="bootstrap_pickmeup" required/>
                                </div>
                              </div>
                              <label class="col-md-1 control-label">à</label>
                              <div class="col-md-3">
                                <div class="input-group w-md">
                                  <input type="text" name="publish_time" class="form-control" ui-jq="timepicker"
                                         ui-options="{'timeFormat': 'H:i', 'step': 15}"
                                         value="<?= date("H") ?>:<?= date("i") ?>" required/>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php else: $time = strtotime($d->article->date); ?>
                          <label class="col-md-4 control-label"><b>Article planifié pour le <?= date("d/m/Y", $time) ?>
                              à <?= date("H:i", $time) ?>.</b></label>
                        <?php endif; ?>
                    </div>
                  </div>
                <?php endif; ?>

              <div class="line line-dashed b-b line-lg pull-in"></div>

              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                  <a href="<?= BASE_URL . ADMIN_PREFIX ?>/devblog/articles" class="btn btn-default">Annuler</a>
                  <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php elseif ($d->action == "comments"): ?>
      <div class="wrapper-md">
        <div class="panel panel-default">
          <div class="panel-heading">
            Tous les commentaires de l'article
          </div>
          <div class="table-responsive">
            <table ui-jq="dataTable" ui-options="{
							sAjaxSource: '?data=true',
							aoColumns: [
								{ mData: 'id' },
								{ mData: 'content' },
								{ mData: 'author' },
								{ mData: 'date' },
								{ mData: 'parent_comment' },
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
								emptyTable: 'Aucune donnée à afficher',
								info: 'Affichage de _START_ à _END_ entrées sur _TOTAL_ entrées'
							},
							order: [[ 3, 'desc' ]],
							columnDefs: [
								{targets: -1,orderable: false}
							]
						}" class="table table-striped b-t b-b">
              <thead>
              <tr>
                <th style="width:5%">#</th>
                <th style="width:35%">Corps du commentaire</th>
                <th style="width:15%">Auteur</th>
                <th style="width:15%">Date</th>
                <th style="width:20%">En réponse à</th>
                <th style="width:15%">Actions</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php endif; ?>
</div>

<script type="text/javascript">
    function updatePubOpts (el) {
        var checked = el.checked;
        var optsContainer = document.getElementById("pub_opts");

        optsContainer.style.display = ((checked) ? "block" : "none");
    }

    function updatePubDate (el) {
        var reported = (el.value == "planified");
        var reportDateContainer = document.getElementById("pub_report_date");

        reportDateContainer.style.display = ((reported) ? "block" : "none");
    }

    function updateContent () {
        var val = document.getElementById("wysiwyg-editor-content").innerHTML;
        document.getElementById("content-fake-textarea").value = val;

        if (val == "") {
            alert("Veuillez remplir le contenu de l'article !");
            return false;
        }
    }


    function pasteHtmlAtCaret (html, selectPastedContent) {
        var sel, range;
        if (window.getSelection) {
            // IE9 and non-IE
            sel = window.getSelection();
            if (sel.getRangeAt && sel.rangeCount) {
                range = sel.getRangeAt(0);
                range.deleteContents();

                // Range.createContextualFragment() would be useful here but is
                // only relatively recently standardized and is not supported in
                // some browsers (IE9, for one)
                var el = document.createElement("div");
                el.innerHTML = html;
                var frag = document.createDocumentFragment(), node, lastNode;
                while ((node = el.firstChild)) {
                    lastNode = frag.appendChild(node);
                }
                var firstNode = frag.firstChild;
                range.insertNode(frag);

                // Preserve the selection
                if (lastNode) {
                    range = range.cloneRange();
                    range.setStartAfter(lastNode);
                    if (selectPastedContent) {
                        range.setStartBefore(firstNode);
                    } else {
                        range.collapse(true);
                    }
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            }
        } else if ((sel = document.selection) && sel.type != "Control") {
            // IE < 9
            var originalRange = sel.createRange();
            originalRange.collapse(true);
            sel.createRange().pasteHTML(html);
            if (selectPastedContent) {
                range = sel.createRange();
                range.setEndPoint("StartToStart", originalRange);
                range.select();
            }
        }
    }

    function pasteYTVideo (value) {
        var id = youtube_parser(value);

        pasteHtmlAtCaret(
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + id + '" frameborder="0" allowfullscreen></iframe>',
            false
        );
    }

    function youtube_parser (url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    }

    function pasteImageWithLink (url) {
        pasteHtmlAtCaret('<div><img src="' + url + '" ></div>', false);
    }

    function colorChange (color) {
        if (!jQuery("#colorBtn").hasClass("open")) return false;
        $("#colorBtn").removeClass('open');
        $("#colorBtn a").attr("expanded", "false");

        if (color == null) {
            document.execCommand("removeFormat", false, "foreColor");
            return false;
        }

        // document.execCommand('styleWithCSS', false, true);
        document.execCommand('foreColor', false, color.toHexString());
    }
</script>
