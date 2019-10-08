<!-- Modal content-->
<div class="modal-content">
    <h1 style="text-align: center; margin-top: 0">Բարի Գալուստ</h1>
    <h1 style="text-align: center" class="client-name">{{ $client->name . " " . $client->surname }}</h1>
    <div class="row bonus-section">
        <div class="container" style="display: flex; justify-content: space-between;">
            <button onclick="getBonus()" class="btn btn-success bonus-btn">Կուտակել Բոնուս</button>
            <button onclick="redeemBonus()" class="btn btn-success bonus-btn">Օգտագործել Բոնուս</button>
        </div>
    </div>
    <div class="row redeem-section" style="display: none">
        <input type="hidden" class="current-bonus" value="{{ $client->bonus }}">
        <div class="form-group">
            <input type="number" step="any" class="redeem-value form-control" value="{{ $client->bonus }}">
        </div>
        <div class="col-md-12" style="text-align: right">
            <button class="btn btn-success" onclick="redeem({{ $client->bonus }})">Օգտագործել</button>
        </div>
    </div>
</div>
