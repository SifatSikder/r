<!doctype html>
<html lang="en">
<head>
    <style>
        @page {
            margin: 0 !important;
            padding: 0 !important;
        }
        body{
            background-position: center;
            background-size: 100%;
            background-repeat: no-repeat;
            color: #000000;
        }
        table{
            width: 100%;
            border-spacing: 0;
            padding: 100px;
        }
        .text-center{text-align: center;}
        .text-justify{text-align: justify;}
        .sign-border{
            display: inline-block;
            width: 200px;
            border-bottom: 5px solid {{$cert_settings['participant_name_border_color']}};
        }
        .fs-lg-1{
            color: {{$cert_settings['participant_name_color']}};
            font-size: {{$cert_settings['participant_name_font_size']}}px;
            font-weight: bold;
            margin: 20px 0 20px 0;
            padding: 50px 20px 0 20px;
            display: inline-block;
            border-bottom: 5px solid {{$cert_settings['participant_name_border_color']}};
        }
        .fs-1{
            font-size: 50px;
            margin: 0;
            padding: 25px 0 0 0;
        }
        .fs-3{
            font-size: 25px;
            margin: 0;
            padding: 25px 0 0 0;
        }
        .fs-p{
            font-size: 17px;
            margin: 0;
            padding: 25px 0 0 0;
        }
        .fs-text{
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }
        .mot4ai-cert-bg-tr{
            position: fixed;
            top: 0;
            right: 0;
            width: 300px;
        }
        .mot4ai-cert-bg-bl{
            position: fixed;
            bottom: 0;
            left: 0;
            width: 300px;
        }
        footer {
            position: fixed;
            bottom: 30px;
            right: 30px;
        }
        footer a{
            color: #000000;
            text-decoration: none;
        }
    </style>
</head>
<body style="background-image: url('{{public_path('storage/media/image/'.$cert_settings['certificate_bg'])}}')">

<img class="mot4ai-cert-bg-tr" src="{{public_path('img/certificate/mot4ai-cert-bg-tr.png')}}" alt="">
<img class="mot4ai-cert-bg-bl" src="{{public_path('img/certificate/mot4ai-cert-bg-bl.png')}}" alt="">

<table>
    <tr>
        <td colspan="4" class="text-left"><img style="width: 150px;margin-top: 20px" src="{{public_path('storage/media/image/'.$cert_settings['certificate_logo'])}}" alt=""></td>
    </tr>
    <tr>
        <td colspan="4" class="text-left">
            <p class="fs-1"><strong>CERTIFICATE</strong></p>
            <p class="fs-3">OF PARTICIPATION</p>
            <p class="fs-p">This Certificate Is Proudly Presented to</p>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="text-center">
            <p class="fs-lg-1"><strong>{{$workshop['user']['full_name']}}</strong></p>
            <p class="fs-p text-justify">
                {!! nl2br($cert_settings['description_letter']) !!}
            </p>
            <br><br><br>
            <br><br><br>
        </td>
    </tr>
    <tr>
        <td> &nbsp; </td>
        <td class="text-center">
            <p class="fs-text">{{$cert_settings['signature']}} <br><br></p>
            <div class="sign-border"></div>
            <p class="fs-text">SIGNATURE</p>
        </td>
        <td class="text-center">
            <p class="fs-text">{{date('d M, Y')}} <br><br></p>
            <div class="sign-border"></div>
            <p class="fs-text">DATE</p>
        </td>
        <td> &nbsp; </td>
    </tr>

</table>

<footer>
    <a href="www.raidot.com">www.raidot.com</a>
</footer>

</body>
</html>
