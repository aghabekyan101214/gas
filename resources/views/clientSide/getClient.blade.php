<!-- Modal content-->
<div class="modal-content">
    <button class="btn btn-danger" data-dismiss="modal" style="position:absolute; right: 0; top: 0; height: 50px;width: 50px; color: white; font-size: 30px">&times;</button>
    <div class="row" style="height: 50%; width: 100%; display: flex; justify-content: center; flex-direction: column">
        <div style="width: 100%;">
            <h1 style="text-align: center; margin-top: 0">Բարի Գալուստ</h1>
            <h1 style="text-align: center; font-size: 50px; font-weight: 400; color: black" class="client-name">{{ $client->name . " " . $client->surname }}</h1>
            @if($bonus >= 5 )
                <h1 style="text-align: center; font-size: 50px; font-weight: 400; color: black">Դուք Ունեք <span style="color: green">{{ $bonus }}</span>  լ Բոնուս </h1>
            @endif
        </div>
    </div>
    <div class="row bonus-section" style="height: 50%; width: 100%">
        <div class="container" style="display: flex; justify-content: space-around;">
            <button onclick="getBonus()" class="btn btn-default bonus-btn black-btn">Կուտակել Բոնուս</button>
            @if($bonus >= 5)
                <button onclick="redeem()" class="btn btn-success bonus-btn">Օգտագործել Բոնուս</button>
            @endif
        </div>
    </div>
    <div class="row redeem-section" style="display: none; height: 50%; width: 100%; background: #000000e3">
        <input type="hidden" class="current-bonus" value="{{ $client->bonus }}">
        <div class="row" style="display: flex; justify-content: center; flex-direction: column; height: 100%">
            <div class="col-md-12" style="padding: 30px; width: 100%;">
                <label style="display: block; color: white; font-size: 30px; margin: 10px 0 12px 0" id="" for="bonus">Բոնուսային Լիտր</label>
                <div style="width: 100%; display: flex">
                    <input type="text" readonly style="width: 50%; height: 70px; border-radius: 25px 0 0 25px; font-size: 40px; color: black" id="bonus telephone-keyboard" step="any" class="redeem-value form-control keyboard vk" value="{{ $client->bonus }}">
                    <button class="btn btn-success" @if($client->bonus == 0) disabled @endif style="width: 50%; border-radius: 0 25px 25px 0; color: white; font-size: 40px" onclick="redeem({{ $client->bonus }})">Օգտագործել</button>
                </div>
            </div>
        </div>
    </div>
</div>

