<div class="app-content-body ">
  <div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Modifier le prix d'un item en survie</h1>
  </div>

  <div class="wrapper-md">
    <div class="panel panel-default">
      <div class="panel-heading font-bold">Modifier le prix d'un item en survie</div>
      <div class="panel-body" id="panelBody">
        <form role="form">
          <div class="form-group">
            <div class="col-sm-12">
              <label>Selectionnez l'item à modifier</label>
              <select name="item_id" class="form-control m-b" onchange="itemChosen(this)">
                <option value="none" selected>Sélectionnez un item</option>

                  <?php foreach ($d->items as $v): ?>
                    <option data-soldprice="<?= $v->sold_price ?>" data-buyingprice="<?= $v->buying_price ?>"
                            value="<?= $v->id ?>">
                        <?= $v->name; ?>
                      (<?= $v->material_id; ?><?= ($v->material_data > 0) ? ":" . $v->material_data : "" ?>)
                    </option>
                  <?php endforeach ?>
              </select>
            </div>
          </div>

          <div id="price-row" style="display:none">
            <div class="form-group">
              <div class="col-sm-6">
                <label>Ancien prix de vente</label>
                <input type="number" class="form-control" id="oldprice" value="100" name="oldprice" step="0.001"
                       disabled>

                <label>Compensation (%)</label>
                <input type="number" class="form-control" id="compensation" value="20" name="compensation" step="0.01"
                       min="0" max="100" onchange="newReduc(this);">
              </div>

              <div class="col-sm-6">
                <label>Nouveau prix de vente</label>
                <input type="number" class="form-control" id="newprice" value="100" name="newprice" min="0" step="0.001"
                       onchange="newPriceChosen(this);">
              </div>
            </div>

            <div class="clear"></div>
          </div>

          <div id="players-row" style="display:none">
            <div class="form-group">
              <div class="col-sm-12">
                <br/>
                <label>Joueurs impactés</label>

                <div class="table-responsive">
                  <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                      <th>Joueur</th>
                      <th>Total échangé (en pièce)</th>
                      <th>Total échangé (en nombre)</th>
                      <th>Portefeuille</th>
                      <th>Nouveau portefeuille</th>
                    </tr>
                    </thead>
                    <tbody id="xhrresults">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <br/>
              <button type="submit" class="btn btn-md btn-primary">Appliquer la modification</button>
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
    var lastItemId = -1;
    var itemChangePerc = -1;
    var compensation = 0.25;

    function itemChosen (select) {
        var option = select.querySelectorAll("option")[select.selectedIndex];

        lastItemId = parseInt(option.value);
        fillTable(null);

        document.getElementById("oldprice").value = option.dataset.soldprice;
        document.getElementById("newprice").value = option.dataset.soldprice;

        document.getElementById("price-row").style.display = "block";
    }

    function newPriceChosen (input) {
        var oldVal = parseFloat(document.getElementById("oldprice").value);
        var val = parseFloat(input.value);
        if (val == oldVal) return;

        itemChangePerc = (oldVal - val) / oldVal;

        var xhr = new XMLHttpRequest();
        xhr.open('get', '?itemdata=' + lastItemId);

        // Track the state changes of the request.
        xhr.onreadystatechange = function () {
            var DONE = 4;
            var OK = 200;

            if (xhr.readyState === DONE)
                if (xhr.status === OK)
                    fillTable(JSON.parse(xhr.responseText));
        };

        xhr.send(null);

        document.getElementById("players-row").style.display = "block";
    }

    function newReduc (input) {
        var val = parseFloat(input.value);
        compensation = val / 100;

        newPriceChosen(document.getElementById("newprice"));
    }

    function fillTable (datas) {
        var table = document.getElementById("xhrresults");

        table.innerHTML = "";
        if (datas == null) return;

        var totPiece = 0, totMoney = 0;
        for (var i = 0; i < datas.length; i++) {
            totPiece += parseFloat(datas[i].S);
            totMoney += parseInt(datas[i].A);
        }

        datas[datas.length] = {
            playername: "<b>Total</b>",
            S: totPiece,
            A: totMoney,
            money: "-"
        };

        var len = datas.length;
        for (var i = 0; i < len; i++) {
            var data = datas[i];

            var tr = document.createElement("tr");
            var td1 = document.createElement("td");
            var td2 = document.createElement("td");
            var td5 = document.createElement("td");
            var td3 = document.createElement("td");
            var td4 = document.createElement("td");

            var exchanged = parseFloat(data.S).toFixed(3);
            var wallet = parseFloat(data.money).toFixed(3);
            var newWallet = calcNewWallet(wallet, parseFloat(data.S));
            var buy = playerHasBuy(datas, data.playername);

            td1.innerHTML = data.playername;
            td2.innerHTML = "<span style='color:green'>+" + exchanged + "</span>";
            td5.innerHTML = "<span style='color:red'>-" + data.A + "</span>";
            if (exchanged < 0) td2.className = "negative";

            td3.innerHTML = wallet;
            td4.innerHTML = newWallet;

            // On regarde si le joueur a aussi acheté l'item
            if (buy != null) {
                var newNewWallet = calcNewWallet(newWallet, parseFloat(buy.S));

                td2.innerHTML += "<br><span style='color:red;'>" + parseFloat(buy.S).toFixed(3) + "</span>";
                td5.innerHTML += "<br><span style='color:green;'>+" + buy.A + "</span>";
                td3.innerHTML += "<br>" + newWallet;
                td4.innerHTML += "<br><input type='hidden' name='new_wallet_" + data.player_id + "' value='" + newNewWallet + "'>" + newNewWallet;

                datas.splice(datas.indexOf(buy), 1);
                len--;
            } else {
                td4.innerHTML = "<input type='hidden' name='new_wallet_" + data.player_id + "' value='" + newWallet + "'>" + newWallet;
            }

            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td5);
            tr.appendChild(td3);
            tr.appendChild(td4);
            table.appendChild(tr);
        }
    }

    function playerHasBuy (datas, playername) {
        var r = null;

        for (var i = 0; i < datas.length; i++) {
            var d = datas[i];

            if (d.playername == playername && parseFloat(d.S) < 0) {
                r = d;
                break;
            }
        }

        return r;
    }

    function calcNewWallet (wallet, exchanged) {
        var newExcVal = exchanged * itemChangePerc;
        var newWallet = wallet - (newExcVal * (1 - compensation));

        if (newWallet < 0) newWallet = 0;
        newWallet = parseFloat(newWallet).toFixed(3);

        return newWallet;
    }
</script>
