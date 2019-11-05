@extends('layouts.client')
<style>
    .bonus-btn{
        height: 200px;
        width: 200px;
    }
    .modal-content {
        height: 90vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>
@section('content')
    <input required class="form-control qr" name="qr">
    <!-- Modal -->
    <div id="bonus" class="modal fade" role="dialog">
        <div class="modal-dialog modal-here" style="width: 100%;">

        </div>
    </div>

    {{--// Popup Modal //--}}
    <div id="popup" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 50%;">

            <!-- Modal content-->
            <div class="modal-content" style="height: 50%;">
                <h1 style="text-align: center; margin-top: 0">Շնորհավորում ենք, Դուք Ունեք <span class="bonus-span"></span>լ Բոնուս</h1>
            </div>

        </div>
    </div>

    {{--// Popup Modal Redeem //--}}
    <div id="popup-redeem" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 50%;">

            <!-- Modal content-->
            <div class="modal-content" style="height: 50%;">
                <h1 style="text-align: center; margin-top: 0">Շնորհավորում ենք, Դուք Հաջողությամբ Օգտագործեցիք <span class="redeem-span"></span>լ Ձեր Բոնուսային Միավորներից</h1>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".qr").focus();
            window.id = 1;
            $(".qr").keydown(function(e){
                if(e.key == "Enter") {
                    window.qr = $(".qr").val();
                    $(".qr").val("");
                    $.post("/get-client", {qr: window.qr}, function( data ) {
                        if(data == 0) return;
                        $("#bonus").modal();
                        $(".modal-here").html(data);
                    });
                }
            });
            $(document).on("click", function(){
                $(".qr").focus();
            });
            $(document).on("keydown", function(){
                if($("#bonus").css("display") == "block") return;
                $(".qr").focus();
            });
            $(document).on("keyup", ".redeem-value", function (e) {
                e.stopPropagation();
                let max = parseFloat($(".current-bonus").val());
                if(parseFloat($(this).val()) > max) {
                    $(this).val(max);
                }
            });
            $(document).on("keydown", ".redeem-value", function (e) {
                e.stopPropagation();
            });
            $("#bonus").click(function(e){
                e.stopPropagation();
            });
            $(".modal").click(function (e) {
                e.preventDefault();
            });
        });
        function getBonus(){
            $(".preloader").css("display", "block");
            $("#bonus").modal("hide");
            $.post("/bonus", {qr: window.qr, identificator: window.id}).done(function( data ) {
                $(".preloader").css("display", "none");
                if(data == 0) return;
                $("#popup").modal();
                $(".bonus-span").html(data.bonus);
            }).fail(function(){
                $(".preloader").css("display", "none");
                alert("error")
            })
        }
        function redeemBonus(){
            $(".bonus-section").css("display", "none");
            $(".redeem-section").css("display", "block");
        }

        function redeem(max){
            max = parseFloat(max);
            let liter = parseFloat($(".redeem-value").val());
            if(liter > max || liter <= 0) {
                liter = max;
            } else if(liter == 0) {
                return;
            }
            $(".preloader").css("display", "block");
            $.post("/redeem", {qr: window.qr, identificator: window.id, liter: liter}).done(function( data ) {
                $("#bonus").modal("hide");
                if(data.bonus) {
                    $(".preloader").css("display", "none");
                    if(data == 0) return;
                    $("#popup-redeem").modal();
                    $(".redeem-span").html(liter);
                } else if(data == 0) {
                    alert("Նշված քանակը չի համապատասխանում հաճախորդի բոնուսին");
                }
            })
        }

        $('#popup-redeem').on('hidden.bs.modal', function () {
            location.reload();
        });
    </script>
@endsection

