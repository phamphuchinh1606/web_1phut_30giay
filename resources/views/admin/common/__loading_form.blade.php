<style>
    .loading{
        position:fixed;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        height: 100%;
        width: 100%;
        display: fixed;
        justify-content: center;
        align-items: center;
        z-index: 1072;

    }
    .loading img{
        position: absolute;
        z-index: 1073;
        left: 50%;
        top: 50%;
        width: 200px;
        height: 200px;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    @media (max-width: 767px){
        .loading img{
            width: 120px;
        }
    }
</style>

<div class='loading' id="loading" style="display: none">
    <img src="{{\App\Helpers\AppHelper::assetPublic('images/spiner.svg')}}" alt="loading"/>
</div>

