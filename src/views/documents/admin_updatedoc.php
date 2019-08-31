<div class="app-content-body ">
  <div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Suggérer une modification pour <b><?= $d->name ?></b></h1>
  </div>

  <div class="wrapper-md">
    <div class="panel panel-default">
      <div class="panel-heading font-bold">Ajout d'une étape de modification pour le document</div>
      <div class="panel-body" id="panelBody">
        <form method="POST" action="" id="form-ch">
          <div class="form-group">
            <div class="col-sm-12">
              <label>Selectionnez le nouveau fichier (.pdf requis)</label>
              <input type="hidden" name="newfile" value="yes">
              <input type="file" name="pdf" accept="application/pdf" id="pdfchooser">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <br/>
              <div class="wrapper-md">
                <div class="row">
                  <div class="col-sm-9" id="bar-container">
                    <div class="progress progress-xs m-t-sm dk" style="margin-bottom:0">
                      <div class="progress-bar progress-bar-success" style="width:0">
                      </div>
                    </div>
                    <span>En attente de l'envoi du document.</span>
                  </div>
                  <div class="col-sm-3">
                    <button type="submit" class="btn btn-md btn-primary" disabled="true">Suggérer cette modification
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <footer class="panel-footer">
      </footer>
    </div>
  </div>
</div>

<script type="text/javascript">
    window.addEventListener("load", function () {
        var inp = document.getElementById("pdfchooser");
        var form = document.getElementById("form-ch");
        var bc = document.getElementById("bar-container");
        var bcm = bc.querySelector("span");

        inp.onchange = function () {
            var ext = this.value.match(/\.([^\.]+)$/)[1];

            if (ext == "pdf") {
                this.disabled = true;
                sendFile(this.files[0]);
            } else {
                bcm.innerHTML = "<i class='fa fa-times'></i> Fichier non valide.";
            }
        }

        function sendFile (file) {
            var formData = new FormData();
            formData.append("file", file);

            var xhr = new XMLHttpRequest();
            xhr.addEventListener('progress', function (e) {
                var done = e.position || e.loaded, total = e.totalSize || e.total;
                var perc = (Math.floor(done / total * 1000) / 10);

                if (perc == Infinity) return;

                bc.style.width = perc + '%';
                bcm.innerHTML = "Téléversement du document... " + Math.round(perc) + "%";
            }, false);
            if (xhr.upload) {
                xhr.upload.onprogress = function (e) {
                    var done = e.position || e.loaded, total = e.totalSize || e.total;
                    var perc = (Math.floor(done / total * 1000) / 10);

                    if (perc == Infinity) return;

                    bc.querySelector('.progress-bar').style.width = perc + '%';
                    bcm.innerHTML = "Téléversement du document... " + Math.round(perc) + "%";
                };
            }
            xhr.onreadystatechange = function (e) {
                if (4 == this.readyState) {
                    bcm.innerHTML = "Document envoyé !";
                    setTimeout(function () {
                        form.querySelector('button').disabled = false;
                    }, 1000);
                }
            };

            xhr.open('post', '?post=true', true);
            xhr.send(formData);
        }
    });
</script>
