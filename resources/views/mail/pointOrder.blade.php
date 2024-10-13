<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
  <style type="text/css">
    body,
    table,
    td {
      font-family: Helvetica, Arial, sans-serif !important;
    }

    a {
      text-decoration: none;
    }

    img {
      -ms-interpolation-mode: bicubic;
      width: 100%;
      height: auto;
    }

    .container {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
    }

    .header {
      text-align: center;
      padding: 20px;
    }

    .card {
      border-radius: 6px;
      border: 1px solid #e2e8f0;
      padding: 40px;
      background-color: #ffffff;
    }

    .footer {
      text-align: center;
      color: #718096;
      padding: 20px;
    }

    .message {
      border: 1px solid #e2e8f0;
      border-radius: 4px;
      padding: 10px;
      background-color: #f9f9f9;
    }
  </style>
</head>

<body style="margin: 0; padding: 0; background-color: #f7fafc;">
  <table class="container" role="presentation">
    <tr>
      <td class="header">
        <img src="https://scontent.fmnl17-1.fna.fbcdn.net/v/t39.30808-6/395230712_122118591386063246_3069262199382701706_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeF3TvLcqEu0luHCExtftUoiC13derB72XoLXd16sHvZeldH_biMSyB-5DaMdbzZSMXoGtFEEt3DU4qrO390bF5j&_nc_ohc=xHjDiQ0_jNkQ7kNvgE-Hxy-&_nc_ht=scontent.fmnl17-1.fna&oh=00_AYBTBpQnrO0xHh4mGsc6CbG0VHHKExHGcJ59F0Mkd-GHGA&oe=66BB9D0F" alt="Logo">
      </td>
    </tr>
    <tr>
      <td>
        <div class="card">
          <h1 style="font-size: 28px; font-weight: 700; margin: 0;">Notification</h1>
          <p>Thank you for reaching out to us. Below is your message:</p>
          <div class="message">{{ $mailMessage }}<b>Total Start Points:  {{ $totalStarPoints }}</b></div>
          <div class="footer">{{ $email }}<br>Best regards,<br><a href="https://tripidkard.com">Tripidkard</a></div>
        </div>
      </td>
    </tr>
  </table>
</body>

</html>
