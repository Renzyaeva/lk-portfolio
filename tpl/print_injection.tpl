<script type="text/javascript" language="javascript" src="/js/jquery-1.6.4.min.js"></script>
<style>
    .no-print
    {
        display: none !important;
    }
   /* img
    {
        display: none !important;
    }*/

    h1{
        font-size: 14pt !important;
        font-weight: bold;
        width: 100%;
        text-align: center;
    }

    body{
        font-family: "Times New Roman";
        font-size: 10pt !important;
        color: black;
        width: 100%
    }

    a:hover {
        text-decoration: none;
    }
    a {
        text-decoration: none;
        color: black;
        cursor: inherit;
    }

    @media print
    {
        @page { size: portrait; }
        .no-print
        {
            display: none !important;
        }

        .print {
            margin: 0px;
            display: block;
        }

        html {
            height: auto;
        }

        body {
            line-height: 12px;
        }
    }

    .msg-good {
        background-color: white;
        border-left: white;
        color: #333;
        padding: 5px;
    }

    .msg-neutral {
        background-color: white;
        border-left: white;
        color: #333;
        padding: 5px;
    }

    .msg-warning {
        background-color: white;
        border-left: white;
        color: #333;
        padding: 5px;
    }

    .ispgut{
        box-shadow: none;
        border: 1px solid black;
    }

    .ispguth{
        background: white;
    }

    .ispgut td {
        padding: 1px;
        border: 1px solid black;
    }

    table.ispgut tbody tr table tr:hover {
        background: none;
    }

    div{
        display: block;
    }

</style>


<script>

    $( document ).ready(function() {
        //$(".print > div").css('margin','0px');
        $("div").attr('onclick','');
        $("div").css('display','block');

        $(".print > div").css('margin','0px');


        $(".no-print").remove();
        $(".portfolio_tbl").remove();
        $(".portfolio_img").remove();
        $("img").remove();
    });

    window.onload = function() { window.print(); }
</script>