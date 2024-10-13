<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    body, table, td {
      font-family: Helvetica, Arial, sans-serif !important;
    }
    a {
      text-decoration: none;
    }
    * {
      color: inherit;
    }
    img {
      -ms-interpolation-mode: bicubic;
    }
    table {
      font-family: Helvetica, Arial, sans-serif;
      border-spacing: 0px;
      border-collapse: collapse;
    }
    table td {
      border-spacing: 0px;
      border-collapse: collapse;
    }
    @media screen and (max-width: 600px) {
      .w-full {
        width: 100% !important;
      }
    }
  </style>
</head>

<body style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; color: #000000; margin: 0; padding: 0;">

  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
    <tbody>
      <tr>
        <td align="center" bgcolor="#f7fafc">
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto;">
            <tbody>
              <tr>
                <td align="center" style="padding: 40px;">
                  <img src="https://scontent.fmnl17-1.fna.fbcdn.net/v/t39.30808-6/395230712_122118591386063246_3069262199382701706_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeF3TvLcqEu0luHCExtftUoiC13derB72XoLXd16sHvZeldH_biMSyB-5DaMdbzZSMXoGtFEEt3DU4qrO390bF5j&_nc_ohc=xHjDiQ0_jNkQ7kNvgE-Hxy-&_nc_ht=scontent.fmnl17-1.fna&oh=00_AYBTBpQnrO0xHh4mGsc6CbG0VHHKExHGcJ59F0Mkd-GHGA&oe=66BB9D0F"
                    width="150" style="display: block; border: none; outline: none;">
                </td>
              </tr>
            </tbody>
          </table>

          <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px;">
            <tbody>
              <tr>
                <td style="padding: 40px;">
                  <h1 style="font-size: 28px; font-weight: 700;">Notification</h1>
                  <p>Thank you for reaching out to us. Below is your message:</p>

                  <div style="border: 1px solid #e2e8f0; border-radius: 4px; padding: 10px; background-color: #f9f9f9;">
                    {{ $messageContent }}
                  </div>

                  <p style="text-align: center; color: #718096;">{{ $email }}</p>
                </td>
              </tr>
            </tbody>
          </table>

          <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto; text-align: center;">
            <tbody>
              <tr>
                <td style="padding: 24px;">
                  Best regards,<br>
                  <a href="https://tripidkard.com">Tripidkard</a>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>

</body>

</html>
